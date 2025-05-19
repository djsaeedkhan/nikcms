<?php
namespace Admin\Controller;

use Admin\Controller\AppController;
use Admin\View\Helper\ModuleHelper;
use Cake\ORM\TableRegistry;
use Cake\Utility\Inflector;
use Cake\Utility\Text;
use Cake\Event\Event;
use Cake\I18n\Time;
use Cake\I18n\Date;
use Cake\I18n\I18n;
use Cake\ORM\Behavior\TreeBehavior;

class PostsController extends AppController
{
    public function initialize(){
        parent::initialize();
        $user_id = $this->Auth->user('id');
        $this->set(['user_ids'=> $user_id]);
        ini_set('max_input_vars', 100000);
    }
    /* public function beforeFilter(Event $event){
        parent::beforeFilter($event);
        $this->Auth->allow(['edit']);
    } */

    //----------------------------------------------------------------------------------
    public function index(){
        if ($this->request->getQuery('correct_thumbnail')) {
            /* 
                For SirangTalaee Correct product thumbnail 
                رفع مشکل تصاویر شاخص بعد از استفاده از پلاگین thumbnail
                1401-06-21 
            */
            //$this->_correct_thumbnail();
        }
        /* if ($this->request->getQuery('correct_thumbnail')) {
            $this->RunQuery();
        } */

        switch ( ($posts_order = $this->Func->Optionget('posts_order')) ) {
            case 'priority':
                $order = ['Posts.Priority'=>'asc'];
                break;
            
            default:
                $order = ['Posts.created'=>'desc'];
                break;
        }
        
        if(isset($this->request->getParam('?')['sort'])){
            $param = $this->request->getParam('?');
            if($param['sort'] == 'title')
                $order = [
                $this->Posts->translationField($param['sort']) =>(isset($param['direction'])?$param['direction']:'desc')
                ];
            else
                $order = [ 'Posts.'.$param['sort'] =>(isset($param['direction'])?$param['direction']:'desc') ];
        }

        $res = $this->Posts->find('all')
            ->contain(['Users', 'Categories', 'Tags', 'PostMetas','PostsI18n'])
            ->order($order)
            ->where([ 'Posts.post_type'=>$this->post_type,
            'OR'=>[
                    ($this->request->getQuery('text')?[
                        $this->Posts->translationField('title').' LIKE '=>'%'.$this->request->getQuery('text').'%']:null),

                    ($this->request->getQuery('text')?[
                        $this->Posts->translationField('summary').' LIKE '=>'%'.$this->request->getQuery('text').'%']:null),  

                    ($this->request->getQuery('text')?[
                        $this->Posts->translationField('content').' LIKE '=>'%'.$this->request->getQuery('text').'%']:null), 
                ]   
                ]);

        if($this->request->getQuery('categorie')){
            $idd = $this->request->getQuery('categorie');
            $res->matching('Categories', function ($q) use($idd) {
                return $q->where(['Categories.id' => $idd]);
            });
        }

        if($this->request->getQuery('tag')){
            $idd = $this->request->getQuery('tag');
            $res->matching('Tags', function ($q) use($idd) {
                return $q->where(['Tags.id' => $idd]);
            });
        }
            
        $posts = $this->paginate($res);
        $this->set(compact('posts','posts_order'));

        if( $this->request->getQuery('post_type') == 'product' ){
            return $this->render('Shop.Home/posts');
        }
    }
    //----------------------------------------------------------------------------------
    public function add(){
        global $post_id;
        global $post_type;
        $post_type = $this->post_type;
        
        $post = $this->Posts->newEntity();
        $this->set('post_types',$this->post_type);
        if ($this->request->is([ 'post'])) {
            $this->request = $this->request->withData('PostMetas.pin', isset($this->request->getData()['PostMetas']['pin'])?$this->request->getData()['PostMetas']['pin']:0);
            $this->request = $this->request->withData('PostMetas.show_in_slider', isset($this->request->getData()['PostMetas']['show_in_slider'])?$this->request->getData()['PostMetas']['show_in_slider']:0);
            $this->request = $this->request->withData('post_type', $this->post_type );
            $this->request = $this->request->withData('slug', $this->checkSlug($this->request->getData()) );
            $this->request = $this->request->withData('tags._ids', $this->SaveTags($this->request->getData('taglist')) );

            if($this->request->getData()['created']!= ''){
                $time = explode(' ', $this->request->getData()['created'] );
                if($this->Func->Optionget('admin_calender') !=1 and 
                    is_array($time) and count($time) == 2 and isset($time[0]) and isset($time[1])){
                        $time = date('Y-m-d', strtotime($this->Func->shm_to_mil($time[0],'/'))). ' ' .$time[1];
                        $this->request = $this->request->withData('created', $time);
                }
                else{
                    $this->request->getData()['created'] = date('Y-m-d H:i:s');
                }
            }
            else{
                $this->request->getData()['created'] = date('Y-m-d H:i:s');
            }
            
            $post = $this->Posts->patchEntity($post, $this->request->getData());

           
            if ($result = $this->Posts->save($post)) {
                $post_id = $result->id;
                if(count($this->request->getData('PostMetas'))):
                foreach($this->request->getData('PostMetas') as $key=>$val){
                    $this->Func->PostMetaSave($result->id,[
                        'type' => 'meta',
                        'name' => $key,
                        'value' => $val,
                        'action' => 'create']);
                }
                endif;
                
                $this->allCell();
                $this->Flash->success(__d('Admin', 'The post has been saved.'));
                if(isset($this->request->getQuery()['ret'])){
                    return $this->redirect($this->request->getQuery()['ret']);
                }
                else
                    return $this->redirect(['action' => 'Edit',$result->id,'?'=>['post_type'=>$this->post_type]]);
            }
            $this->Flash->error(__d('Admin', 'The post could not be saved. Please, try again.'));
        }

        $this->allCell();
        $users = $this->Posts->Users->find('list')->where([]);

        $categories = $this->Posts->Categories
            ->find('treeList',['keyField'=>'id','valueField'=>'title','spacer' => "—",'escape'=>'false'])
            ->where(['post_type'=>$this->post_type]);

        $tags = $this->Posts->Tags->find('list')
            ->where(['post_type'=>$this->post_type]);
        $this->set(compact('post', 'users', 'categories', 'tags'));
        $this->render('add');
    }
    //----------------------------------------------------------------------------------
    public function edit($id = null)
    {
        global $post_id;
        $post_id = $id;
        global $post_type;
        
        if($this->request->getQuery('langview')){
            $lang = $this->request->getQuery('langview');
            if(isset($this->Func->language_list()[$lang])){
                I18n::setLocale($lang);
                $this->set('change_lang_to',$lang);
                global $current_lang;
                $current_lang = $lang;
            }else{
                $this->Flash->error(__d('Admin', 'زبان انتخاب شده معتبر نمی باشد'));
            }
        }
        
        $post = TableRegistry::getTableLocator()->get('Admin.Posts')
            ->get($id, ['contain' => ['Users', 'Categories', 'Tags', 'Comments', 'PostMetas','PostsI18n']]);

        $this->post_type = $post['post_type'];
        $post_type = $this->post_type;
        $this->set('post_types',$this->post_type);
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            
            $post = TableRegistry::getTableLocator()->get('Admin.Posts')->get($id);
            $create_change = false;
        
            if(isset($this->request->getData()['move_id']) and $this->request->getData()['move_id'] != ''){

                $pv = TableRegistry::getTableLocator()->get('Admin.Posts')->get($this->request->getData()['move_id']);

                /* $temp = TableRegistry::get('Admin.Posts')->get($pv->id);
                $temp->created = $post->created;
                TableRegistry::get('Admin.Posts')->save($temp); */
                switch ($this->request->getData()['move_status']) {
                    case 'same':
                        $this->request = $this->request->withData('created',$pv->created);
                        $create_change = true;
                        break;

                    case 'move':
                        $this->request = $this->request->withData('created',$pv->created);
                        $temp = TableRegistry::getTableLocator()->get('Admin.Posts')->get($pv->id);
                        $temp->created = $post->created;
                        TableRegistry::getTableLocator()->get('Admin.Posts')->save($temp);
                        $create_change = true;
                        break;
                        
                    case 'after':
                        $tmp = $this->Posts->find('all')
                            ->where(['DATE(Posts.created) > ' => date($pv->created->format('Y-m-d H:i:s')), 'Posts.post_type'=>$this->post_type])
                            //->limit(2)
                            ->order(['created'=>'ASC'])
                            ->first();

                        if($tmp){
                            $diff = date_diff($pv->created,$tmp['created']);
                            $now = Time::parse($tmp['created']);

                            if(intval($diff->format('%y')) / 2 != 0)
                                $now->modify('-'.intval($diff->format('%y')).' years');

                            if(intval($diff->format('%m')) / 2 != 0)
                                $now->modify('-'.intval($diff->format('%m')).' months');
                           
                            if(intval($diff->format('%d')) / 2 != 0)
                                $now->modify('-'.intval($diff->format('%d')).' days');

                            if(intval($diff->format('%h')) / 2 != 0)
                                $now->modify('-'.intval($diff->format('%h')).' hours');
                            
                            if(intval($diff->format('%i')) / 2 != 0)
                                $now->modify('-'.intval($diff->format('%i')).' minutes');
                            
                            if(intval($diff->format('%s')) / 2 != 0)
                                $now->modify('-'.intval($diff->format('%s')).' seconds');

                            $this->request = $this->request->withData('created',$now);
                            $create_change = true;
                        }
                        break;
                    
                    default: //before
                        $tmp = $this->Posts->find('all')
                            ->where([
                                'DATE(Posts.created) < ' => date($pv->created->format('Y-m-d H:i:s')), 
                                'Posts.id !='=> $pv->id,
                                'Posts.post_type'=>$this->post_type])
                            ->order(['created'=>'DESC'])
                            ->first();

                        if($tmp){
                            $diff = date_diff($tmp['created'],$pv->created);
                            $now = Time::parse($pv->created);

                            if(intval($diff->format('%y')) / 2 != 0)
                                $now->modify('-'.intval($diff->format('%y')).' years');

                            if(intval($diff->format('%m')) / 2 != 0)
                                $now->modify('-'.intval($diff->format('%m')).' months');
                           
                            if(intval($diff->format('%d')) / 2 != 0)
                                $now->modify('-'.intval($diff->format('%d')).' days');

                            if(intval($diff->format('%h')) / 2 != 0)
                                $now->modify('-'.intval($diff->format('%h')).' hours');
                            
                            if(intval($diff->format('%i')) / 2 != 0)
                                $now->modify('-'.intval($diff->format('%i')).' minutes');
                            
                            if(intval($diff->format('%s')) / 2 != 0)
                                $now->modify('-'.intval($diff->format('%s')).' seconds');

                            $this->request = $this->request->withData('created',$now);
                            $create_change = true;
                        }
                        break;
                }
            }

            $this->request = $this->request->withData('PostMetas.pin',
                isset($this->request->getData()['PostMetas']['pin'])?$this->request->getData()['PostMetas']['pin']:0);

            $this->request = $this->request->withData('PostMetas.show_in_slider',
                isset($this->request->getData()['PostMetas']['show_in_slider'])?$this->request->getData()['PostMetas']['show_in_slider']:0);

            $this->request = $this->request->withData('tags._ids',$this->SaveTags($this->request->getData('taglist')));
            //$this->request = $this->request->withData('slug',strtolower($this->request->getData()['slug']));
            $this->request = $this->request->withData('id',$post_id);
            $this->request = $this->request->withData('slug',$this->checkSlug($this->request->getData()));

            if($create_change == false and $this->request->getData()['created']!= ''){
                $time = explode(' ', str_replace('/','-',$this->request->getData()['created']) );
                if($this->Func->Optionget('admin_calender') !=1 
                    and is_array($time) and count($time) == 2 and isset($time[0]) and isset($time[1])){
                        $time = date('Y-m-d', strtotime($this->Func->shm_to_mil($time[0],'-'))). ' ' .$time[1];
                        //echo( $time);
                        //$time = str_replace('/','-',$time);
                        $this->request = $this->request->withData('created',($time));
                }else{
                    $this->request = $this->request->withData('created',str_replace('/','-',$this->request->getData()['created']) );
                }
            }else{
                $this->request = $this->request->withData('created',$post->created );
            }

            $post = $this->Posts->patchEntity($post, $this->request->getData());
            if ($result = $this->Posts->save($post)) {
                foreach($this->request->getData('PostMetas') as $key=>$val){
                    $this->Func->PostMetaSave($result->id,[
                        'type' => 'meta',
                        'name' => $key,
                        'value' => $val,
                        'action' => 'create']);
                }
                $this->allCell();
                $this->Flash->success(__d('Admin', 'The post has been saved.'));

                return $this->redirect($this->referer());
            }
            else
                $this->Flash->error(__d('Admin', 'The post could not be saved. Please, try again.'));
        }
        $this->allCell();

        $users = $this->Posts->Users->find('list');
        $categories = $this->Posts->Categories->find('list')
            ->where(['post_type'=>$this->post_type]);

        $tags = $this->Posts->Tags->find('list')
            ->where(['post_type'=>$this->post_type ]);

        $categories =  $this->Posts->Categories->find('treeList',['keyField'=>'id','valueField'=>'title'])
            ->where(['post_type'=>$this->post_type])
            ->order(['lft'=>'asc']);

        global $post_meta_list;
        $post_meta_list = [];
        if(isset($post->post_metas))
            $post_meta_list = $this->Func->MetaList($post);

        $this->set(compact('post', 'users', 'categories', 'tags','post_meta_list'));
        $this->render('add');
    }
    //----------------------------------------------------------------------------------
    private function SaveTags($taglist)
    {
        $temp1=array();
        if($taglist =='') return false;

        foreach(json_decode($taglist,true) as $tag){
            $tag = isset($tag['value'])?trim($tag['value']):'';
            $this->Tags = TableRegistry::getTableLocator()->get('Tags');
            $exists = $this->Tags->find('all')->where(['title'=>$tag,'post_type'=>$this->post_type]);
            if($exists->count() != 0){
                array_push($temp1,$exists->first()->toarray()['id']);
            } 
            else
            {
               $data = $this->Tags->newEntity();
               $data = $this->Tags->patchEntity($data,[
                        'title'=>$tag,
                        'slug'=>Text::slug(Text::excerpt($tag,'',20, '...' ),['transliteratorId'=>false]),
                        'post_type'=>$this->post_type]);
                $data = $this->Tags->save($data, ['checkRules' => false]);
                array_push($temp1,$data->id);
            }
        }
        return $temp1;
    }
    //----------------------------------------------------------------------------------
    public function delete($id = null){
        $this->request->allowMethod(['post', 'delete']);

        $delete = [];
        if($id != 'list'):
            $delete [$id] = $id;
        else:
            foreach($this->request->getData() as $k => $v){
                if($k !=0 or $k != null)
                    $delete [$k] = $k;
                else
                    $delete [$v] = $v;
            }
        endif;
        
        if(count($delete)):
            foreach($delete as $id):
                $post = $this->Posts->get($id);
                if ($this->Posts->delete($post))
                    $this->Flash->success(__d('Admin', 'مطلب با عنوان {0} حذف شد.',$post['title']));
                else
                    $this->Flash->error(__d('Admin', 'متاسفانه مطلب با عنوان {0} حذف نشد، لطفا دوباره تلاش کنید.',$post['title']));
            endforeach;
        
        else:
            $this->Flash->error(__d('Admin', 'متاسفانه چیزی برای حذف وجود ندارد')); 
        endif;

        //return $this->redirect($this->referer());
        return $this->redirect(['action' => 'index','?'=>['post_type'=>$post['post_type']]]);
    }
    //----------------------------------------------------------------------------------
    private function allCell(){
        foreach(ModuleHelper::admin_postcnt() as $nav){
            echo $this->cell($nav);
        }
    }
    //----------------------------------------------------------------------------------
    private function checkSlug($data = null){
        $text = mb_strtolower(Text::excerpt(preg_replace('/\s/u', '-',($data['slug']==''?$data['title']:$data['slug'])),'',50) );
        $text = str_ireplace(['.','<','>',';',',','_'],'-',$text);
        $text = strip_tags($text);
        $text = stripslashes($text);
        $text = str_replace('/', '-', $text);

        $p = TableRegistry::getTableLocator()->get('Admin.Posts')->find('all')
            ->where(['slug'=> $text,(isset($data['id'])?['Posts.id !='=>$data['id']]:false)])
            ->toarray();
        if(count($p)){
            return $this->checkSlug([
                'slug'=>$text.'1',
                (isset($data['id'])?['Posts.id !='=>$data['id']]:false)
            ]);
        }
        else{
            return $text;
        }
    }
    //----------------------------------------------------------------------------------
    public function Getdata(){ //last edit : 1398.2.9 // 1397.10.24
        /* 
            type : post , category , tags
            ret  : list , all , first
        */
        //if( !$this->request->is('ajax')) die('Access Denied');

        $post_type  = isset($this->request->getParam('?')['posttype'])?$this->request->getParam('?')['posttype']:'post';
        $type       = isset($this->request->getParam('?')['type'])?$this->request->getParam('?')['type']:null;
        $id         = isset($this->request->getParam('?')['id'])?$this->request->getParam('?')['id']:'0';
        $ret        = isset($this->request->getParam('?')['ret'])?$this->request->getParam('?')['ret']:null;

        $where = [];
        if(isset($this->request->getParam('?')['where'])){
           foreach(explode(',',$this->request->getParam('?')['where']) as $v){
               $temp = explode(':',$v);
               $where[$temp[0]] = $temp[1];
           }
        }

        if($type == 'post'){
            $cond = $where + [
                'field'=>['id','title'],
                'contain'=>[],
                'find_type'=>'list'
            ];
            $data = $this->Query->post($post_type,$cond);
        }
        elseif($type == 'category'){
            $data = $this->Query->category($post_type,[
                'field'=>['id','title'],
                'find_type'=>'treeList'
            ]);
        }
        else
            $data = [];

        $response = $this->response->withType('application/json')->withStringBody(json_encode($data));
        //$response = $this->response->withStringBody('');
        return $response;
    }
    //----------------------------------------------------------------------------------
    /* private function RunQuery(){
        //1401-09-16
        $conn = \Cake\Datasource\ConnectionManager::get('default');
        $p = $conn->execute("
        ALTER TABLE `post_metas` CHANGE `meta_value` `meta_value` LONGTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL;
            COMMIT;");
            var_dump( $p );
    } */
    //----------------------------------------------------------------------------------
}