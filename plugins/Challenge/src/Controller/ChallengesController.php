<?php
namespace Challenge\Controller;

use Cake\Filesystem\File;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;
use Challenge\Controller\AppController;
use \Challenge\clsTbsZip;
use Challenge\Predata;
use Challenge\Chpdf;
use Challenge\Export;
use Sms\Sms;
use \Mpdfs\CreatePdf;

class ChallengesController extends AppController
{
    public function initialize(){
        parent::initialize();
        $this->loadComponent('Admin.Fileupload');
        $this->viewBuilder()->setLayout("login");
        $this->Authentication->addUnauthenticatedActions();
    }
    //------------------------------------------------------------------------
    public function index(){
        
        
        if($this->request->getParam('?')){
            $param = $this->request->getQuery();

            $result = $this->Challenges->find('all')
                ->order(['Challenges.priority'=>'asc'])
                ->contain([
                    'Challengestatuses',
                    'Challengefollowers' => function ($q) {
                        return $q
                        ->select(['challenge_id', 'count' => $q->func()->count('*') ])
                        ->group(['challenge_id']);
                    },
                    'Challengefields',
                    'Challengecats',
                    'Challengetopics',
                    'Challengetags']);

            $result->where(['enable' => 1 ]);
            if(isset($param['title']) and $param['title'] !=''){
                $result->where(['OR'=>[
                    'Challenges.title LIKE '=> '%'.$param['title'].'%',
                    'Challenges.descr LIKE '=> '%'.$param['title'].'%' 
                    ]]) ;
            }
            
            if(isset($param['status']) and $param['status'] !=''){
                $result->where(['Challenges.challengestatus_id IN'=> $param['status']]) ;
            }

            if(isset($param['fields']) and $param['fields'] !=''){
                $t = $param['fields'];
                $result->matching('Challengefields', function ($q) use ($t) {
                    return $q->where(['Challengefields.id IN'=> $t, ]);
                });
            }

            if(isset($param['tag']) and $param['tag'] !=''){
                $t = $param['tag'];
                $result->matching('Challengetags', function ($q) use ($t) {
                    return $q->where(['Challengetags.title IN'=> $t, ]);
                });
            }

            try {
                if(isset($param['topics']) and $param['topics'] !=''){
                    if(is_array(explode(',',$param['topics'])) and count(explode(',',$param['topics'])) > 0 ){
                        $tmp = explode(',',$param['topics']);
                        $param['topics'] = [];
                        foreach($tmp as $v){
                            $param['topics'][$v] = $v;
                        }
                    }
                    $t = is_array($param['topics'])?$param['topics']:[$param['topics']=> $param['topics']];
                    $result->matching('Challengetopics', function ($q) use ($t) {
                        return $q->where(['Challengetopics.id IN '=> $t, ]);
                    });
                }
            } catch (\Throwable $th) {
                //throw $th;
            }
            

            if(isset($param['cats']) and $param['cats'] !=''){
                $t = is_array($param['cats'])?$param['cats']:[$param['cats']=>$param['cats']];
                $result->matching('Challengecats', function ($q) use ($t) {
                    return $q->where(['Challengecats.id IN'=> $t ]);
                });
            }
            $challenges = $this->paginate($result->distinct(),['limit'=>100]);

        }else{
            $this->paginate = [
                'contain' => [
                    'Challengestatuses',
                    'Challengefollowers' => function ($q) {
                        return $q
                            ->select(['challenge_id','count' => $q->func()->count('*')])
                            ->group(['challenge_id']);
                    },
                    'Challengecats',
                    'Challengetopics',
                    'Challengetags'],
                'order'=>['priority'=>'asc'],
            ];
            $challenges = $this->paginate($this->Challenges->find('all')->where(['enable'=>1]));
        }
        $this->set(compact('challenges'));
        
        $this->set([
            //'topics' => $this->getTableLocator()->get('Challengetags')->find('list',['keyField' => 'id','valueField' => 'title'])->toarray(), 
            'cats' => $this->getTableLocator()->get('Challengecats')->find('list',['keyField' => 'id','valueField' => 'title'])->toarray(), 
            'status' => $this->getTableLocator()->get('Challengestatuses')->find('list',['keyField' => 'id','valueField' => 'title'])->toarray(), 
            'topics' => $this->getTableLocator()->get('Challengetopics')->find('list',['keyField' => 'id','valueField' => 'title'])->toarray(), 
            'fields' => $this->getTableLocator()->get('Challengefields')->find('list',['keyField' => 'id','valueField' => 'title'])->toarray(), 
        ]);

        try{
            $this->autoRender = false;
            $this->render('Template.Content/challenge/index');
        }
        catch (\Exception $e){
            $this->viewBuilder()->setLayout("challenge-index");
            $this->render(false);
        }
    }
    //------------------------------------------------------------------------
    public function follow($id = null){
        $id = null;
        if($this->request->getParam(['slug'])){
            $id = $this->request->getParam(['slug']);
        }
        if ( $this->request->is('post') ) {

            if(! $this->request->getAttribute('identity')->get('id')){
                $this->Flash->error('برای دنبال کردن '.__d('Template', 'همیاری').' باید وارد سایت شوید');
                return $this->redirect($this->referer());
            }

            $temp = $this->Challenges->find('all')
                ->where([is_numeric($id)?['Challenges.id'=>$id]:['Challenges.slug'=>$id] ]);
            if( !$temp->first()){
                return $this->redirect($this->referer()); 
            }
            $follow = $this->Challenges->Challengefollowers->find('all')->where([
                'user_id' => $this->request->getAttribute('identity')->get('id'),
                'challenge_id' => $temp->first()['id']
            ]);
            if($follow->first()){
                $this->Challenges->Challengefollowers->delete($follow->first());
                $this->Flash->success('شما دیگر این '.__d('Template', 'همیاری').' را دنبال نمیکنید');
            }
            else
            {
                $challengefollower = $this->Challenges->Challengefollowers->newEntity();
                $challengefollower = $this->Challenges->Challengefollowers->patchEntity(
                    $challengefollower, [
                        'user_id' => $this->request->getAttribute('identity')->get('id'),
                        'challenge_id' => $temp->first()['id']
                    ]);
                if ($this->Challenges->Challengefollowers->save($challengefollower)) {
                    $this->Flash->success('شما با موفقیت این '.__d('Template', 'همیاری').' را دنبال میکنید');
                }
                else{
                    $this->Flash->error('متاسفانه دنبال کردن '.__d('Template', 'همیاری').' ثبت نشد');
                }
            }
        }
        else
        $this->Flash->error(__('متاسفانه درخواست شما غیرمعتبر است'));

        return $this->redirect($this->referer());
    }
    //------------------------------------------------------------------------
    public function view($id = null,$page = 'overview'){
        $list = [];
        try{
            $this->viewBuilder()->setLayout('Template.challenge-single');
        }
        catch (\Exception $e){
            $this->viewBuilder()->setLayout("challenge-single");
        }

        if($this->request->getParam(['slug'])){
            $id = $this->request->getParam(['slug']);
        }
        if($this->request->getParam(['method'])){
            $page = $this->request->getParam(['method']);
        }       

        try{
            $this->viewBuilder()->setLayout('Template.challenge');
        }
        catch (\Exception $e){
            $this->viewBuilder()->setLayout("challenge");
        }
        
        $render = 'overview';
        $challenge_id = $id;
        $temp = $this->Challenges->find('all')
            ->where([
                'enable'=>1,
                is_numeric($id)?['Challenges.id'=>$id]:['Challenges.slug'=>$id]
             ]);

        if( !$temp->first()){
           return $this->redirect('/'); 
        }
        
        $temp = $temp->first();
        $challenge_id = $temp['id'];
        $challenge_slug =$temp['slug'];

        //$this->getRequest()->getSession()->delete('Challenge.chi'.$challenge_id);
        $can_password = false;
        if(isset($temp['password']) and $temp['password'] != ''){
            if($this->getRequest()->getSession()->read('Challenge.chi'.$challenge_id) == 1){
                $can_password = true;
            }
            else{
                if(isset($this->request->getData()['chpass'])){
                    $Wrong_Pass = $this->getRequest()->getSession()->read('Challenge.Errchi'.$challenge_id);
                    if(intval($Wrong_Pass) > 10){
                        $this->Flash->error('شما از تعداد مجاز بیشتر رمز عبور را اشتباه وارد کرده اید. دسترسی شما موقتا لغو شد');
                    }
                    elseif($this->request->getData()['chpass'] ==  $temp['password']){
                        $this->getRequest()->getSession()->write('Challenge.chi'.$challenge_id,1);
                        $can_password = true;
                        $this->redirect($this->referer());
                    }
                    else{
                        $this->getRequest()->getSession()->write('Challenge.Errchi'.$challenge_id,intval($Wrong_Pass)+ 1);
                        $this->Flash->error('رمز وارد شده اشتباه است.');
                    }
                }
                else $this->Flash->error('برای مشاهده این '.__d('Template', 'همیاری').' میبایست رمز عبور را وارد نمایید');
            }
        }
        $this->set(['can_password'=> $can_password]);

        $user = $this->Challenges->Users->find('all')
            ->where(['Users.id' => $this->request->getAttribute('identity')->get('id')])
            ->contain(['Challengeuserprofiles',
            'Challengefollowers' => function ($q) use($challenge_id) {
                return $q->where([
                    'challenge_id'=> $challenge_id
                ]);
            }])->first();

        $this->set([
            'users'=> $user,
            'challenge_ids' , $challenge_id,
            'challenge_slug' , $challenge_slug,
            ]);
        
        
        $challenge = $this->Challenges->find('all')
            ->where([is_numeric($id)?['Challenges.id'=>$id]:['Challenges.slug'=>$id] ])
            ->contain([
                'Challengerelateds'=>['Challenges'], 
                'Challengestatuses', 
                'Challengecats', 
                'Challengetags', 
                'Challengetopics', 
                'Challengeimages', 
                'Challengepartners',
                'Challengeviews',
                'Challengefollowers' => function ($q) {
                    return $q->select([
                            'challenge_id',
                            'count' => $q->func()->count('*')
                    ])->group(['challenge_id']);
                },
            ]);

        switch ($page) {
            case 'timeline':
                $challenge = $challenge->contain([
                    'Challengetimelines' => function ($q) {
                        return $q->order(['dates'=>'asc']);
                    },
                ]);
                $render  = 'timeline';
                break;

            case 'partners':
                $render  = 'partners';
                break;

            case 'solution':
                
                
                $this->Challengeqanswers = TableRegistry::getTableLocator()->get('Challenge.Challengeqanswers');

                if($this->request->getQuery('ajax') and $this->request->getQuery('ajax') == 1 ){

                    if(! $this->request->is('ajax')){
                        $response = $this->response->withType('application/json')->withStringBody(json_encode('error07'));
                        return $response;
                    }
                    
                    if($this->request->getQuery('challenge_id'))
                        $ch_id  = $this->request->getQuery('challenge_id');
                    if($ch_id == null)
                        return false;
                    if ($this->request->getQuery('type') ) {
                        switch ( $this->request->getQuery('type') ) {
                            case 'challengequests':
                                return $this->_challengequests($ch_id);
                                break;
                            default:
                                # code...
                                break;
                        }
                    }
                    $this->autoRender = false;
                }

                $this->Challengequests = TableRegistry::getTableLocator()->get('Challenge.Challengequests');
                $this->Challengequests->recover();
                $forms = $this->Challengequests
                    ->find('threaded')
                    ->order(['priority' =>'asc'])
                    ->where(['challenge_id'=> $challenge_id])
                    ->toarray();
                $this->set('forms',$forms);

                $this->Challengeuserforms = $this->getTableLocator()->get('Challenge.Challengeuserforms');
                /* $this->set(['forms'=> 
                    $this->Challengeuserforms->find('all')
                        ->where(['challenge_id' => $challenge_id,'user_id'=> $this->request->getAttribute('identity')->get('id')])
                        ->first(),
                ]); */

                $user_formlist = $this->Challengeuserforms
                    ->find('all')
                    ->where([
                        'challenge_id' => $challenge_id , 
                        'user_id'=> $this->request->getAttribute('identity')->get('id')]);
                
                $this->set(['formlist_count' => $user_formlist->count()]);

                if($this->request->getQuery('edit')){
                    $userform = $user_formlist->first() ;
                    $id = $this->Challengeqanswers
                        ->find('list',['keyField' => 'challengequest_id','valueField' => 'value'])
                        ->where([
                            'user_id'=> $this->request->getAttribute('identity')->get('id'), 
                            'challenge_id' => $challenge_id ])
                        ->toarray();
                    $this->set([
                        'editform' => $id ,
                    ]);
                    //$render = 'solution_edit';
                }
                elseif($user_formlist->first() and $this->request->getQuery('edit')){
                    $userform = $user_formlist->first() ;
                }
                else
                {
                    $userform = $this->Challengeuserforms->newEntity();
                    if($temp['challengestatus_id'] != 1){
                        $this->Flash->error('مدت زمان شرکت در این '.__d('Template', 'همیاری').' به پایان رسیده است');
                        return $this->redirect($this->referer()); 
                    }
                }

                if ($this->request->is(['post','put','patch']) and $this->request->getAttribute('identity')->get('id') ) {

                    $id_list = $this->Challengeuserforms->find('list',['keyField' => 'id','valueField' => 'id'])
                        ->where([
                            'user_id'=> $this->request->getAttribute('identity')->get('id'), 
                            'challenge_id' => $challenge_id ])
                        ->count();

                    if($id_list)
                        $this->Challengeuserforms->deleteAll(['id IN'=>$id_list]);
                        
                    $count = $this->Challengeuserforms->find('all')->where(['user_id'=> $this->request->getAttribute('identity')->get('id')])->count();
                    $token = 
                        jdate('y','','','','en').'.'.
                        substr("000000".$challenge_id,-3).'.'.
                        substr("000000".$this->request->getAttribute('identity')->get('id'),-6).'.'.
                        substr("000000".($count==0?1:$count),-3);

                    $this->request = $this->request->withData('Challengeuserforms.token1', $token );
                    $this->request = $this->request->withData('Challengeuserforms.user_id',$this->request->getAttribute('identity')->get('id') );
                    $this->request = $this->request->withData('Challengeuserforms.challenge_id', $challenge_id );

                    $userform = $this->Challengeuserforms->patchEntity($userform, $this->request->getData()['Challengeuserforms']);
                    
                    if ($userform = $this->Challengeuserforms->save($userform)) {

                        
                        foreach( $this->request->getdata() as $k => $item){if($k != 'Challengeuserforms'):
                            $tmp = explode('_',$k );
                            if(isset($tmp[0]) and $tmp[0] == 'file' and $item != ''){
                                $item =  'ch'.$challenge_id.'_'.$this->request->getAttribute('identity')->get('id').'_'.$k.'_'.date('m-d-h').'_'.rand(1000,9999);
                               /*  $fuConfig['upload_path'] = WWW_ROOT . 'challenge/';
                                if (!file_exists($fuConfig['upload_path'])) {
                                    mkdir($fuConfig['upload_path'], 0777, true);
                                }
                                $fuConfig['allowed_types'] = 'zip';
                                $fuConfig['file_name'] = 'ch'.$challenge_id.'_'.$this->request->getAttribute('identity')->get('id').'_'.$k.'_'.date('m-d-h').'_'.rand(1000,9999);			
                                $fuConfig['max_size'] = 20000;			
                                $this->Fileupload->init($fuConfig);	
                                if (!$this->Fileupload->upload($k)){
                                    $fError = $this->Fileupload->errors();
                                    $item = '';
                                } else {
                                    $item = $this->Fileupload->output('file_name');
                                } */
                            }
                            $list[] = [
                                'challenge_id' => $challenge_id,
                                'user_id' => $this->request->getAttribute('identity')->get('id'),
                                'types' => isset($tmp[0])?$tmp[0]:'-',
                                'challengequest_id' => isset($tmp[1])?$tmp[1]:'0',
                                'value' => is_array($item)?implode(',',$item):$item,
                            ];
                        endif;}
                        
                        
                        $id = $this->Challengeqanswers->find('list',['keyField' => 'id','valueField' => 'id'])
                            ->where([
                                'user_id'=> $this->request->getAttribute('identity')->get('id'), 
                                'challenge_id' => $challenge_id ])
                            ->toarray();

                        if($id)
                            $this->Challengeqanswers->deleteAll(['id IN'=>$id]);

                        $answer = $this->Challengeqanswers->newEntity();
                        $answer = $this->Challengeqanswers->patchEntities($answer,$list);
                        if($this->Challengeqanswers->saveMany($answer)){
                            $currentuser = $this->getTableLocator()->get('Challenge.Challengeuserprofiles') 
                                ->find('all')
                                ->where(['user_id'=>  $this->request->getAttribute('identity')->get('id') ])
                                ->first();
                               
                            if($this->request->getQuery('edit')){
                                if(isset($this->setting_challenge['sms_edit_challenge']) and 
                                    $this->setting_challenge['sms_edit_challenge']!=''){
                                        if($currentuser and $currentuser['mobile'] != ''){
                                            $sms = new Sms();
                                            $sms->sendsingle([
                                                'mobile' => $currentuser['mobile'],
                                                'text' =>$this->setting_challenge['sms_edit_challenge'],
                                            ]);
                                        }
                                }
                            }
                            else{
                                if(isset($this->setting_challenge['sms_new_challenge']) and 
                                    $this->setting_challenge['sms_new_challenge']!=''){
                                        if($currentuser and $currentuser['mobile'] != ''){
                                            $sms = new Sms();
                                            $sms->sendsingle([
                                                'mobile' => $currentuser['mobile'],
                                                'text' =>$this->setting_challenge['sms_new_challenge'],
                                            ]);
                                        }
                                }
                            }
                            
                            $this->Flash->success('فرم مشارکت شما با موفقیت ثبت گردید.'."<br>".
                                'برای مشاهده لیست مشارکت ها به پنل کاربری تان مراجعه نمایید.'."<br><br>".
                                '<a class="mt-2 button button-rounded button-reveal button-small button-green text-right  ml-2" href="'.Router::url('/challenge/').'">
                                برای مشاهده و مشارکت در دیگر '.__d('Template', 'همیاری').'  اینجا کلیک کنید</a>');

                            //$export = new Export();
                            //$url = $export->getword($userform->id,$this->Auth->user());
                            //$url = $export->getpdf($userform->id,$this->Auth->user(),0);
                        }
                        else{
                            $this->Flash->error('متاسفانه ثبت اطلاعات با موفقیت انجام نشد.');
                        }
                        return $this->redirect('/challenge/'.$challenge_slug);
                    }
                    else
                        $this->Flash->error(__('متاسفانه فرم مشارکت ثبت نشد'));
                }
                elseif($this->request->is('post') and !$this->request->getAttribute('identity')->get('id')){
                    $this->Flash->error('برای ثبت مشارکت در '.__d('Template', 'همیاری').'، ابتدا در سایت وارد شوید');
                }
                $this->set(compact('userform','challenge_id','challenge_slug','forms'));
                $render  = 'solution';
                break;

            case 'forum':
                if(isset($this->request->getQuery()['section'])){
                    $section = intval($this->request->getQuery()['section']);
                    $challenge = $challenge->contain([
                        'Challengeforums'=> function ($q) use($section) {
                            return $q
                                ->where([
                                    'Challengeforums.challengeforumtitle_id' => $section,
                                    'Challengeforums.enable' => 1,
                                    ])
                                ->contain(['Users'=>['Challengeuserprofiles']]);
                        },
                        'Challengeforumtitles'=> function ($q) use($section) {
                            return $q
                                ->where([
                                    'Challengeforumtitles.id' => $section,
                                ]);
                        }]);
                    $render  = 'forum_list';

                    $this->Challengeforums = $this->getTableLocator()->get('Challenge.Challengeforums');
                    $challengeforum = $this->Challengeforums->newEntity();
                    if ($this->request->is('post')) {
                        $this->request = $this->request->withData('user_id',$this->request->getAttribute('identity')->get('id') );
                        $this->request = $this->request->withData('challenge_id', $challenge_id );
                        $this->request = $this->request->withData('challengeforumtitle_id', $section );
                        $this->request = $this->request->withData('enable', 0 );

                        $challengeforum = $this->Challengeforums->patchEntity($challengeforum, $this->request->getData());
                        if ($this->Challengeforums->save($challengeforum)) {
                            $this->Flash->success(__('ثبت نظر شما با موفقیت انجام شد. بعد از تایید در سایت نمایش داده خواهد شد'));
                            return $this->redirect($this->referer());
                        }
                        else
                        $this->Flash->error(__('متاسفانه نظر شما ثبت نشد'));
                    }
                    $this->set(compact('challengeforum'));
                }
                else{
                    $challenge = $challenge->contain([
                        'Challengeforums' => function ($q) {
                            return $q
                                ->where(['enable'=>1])
                                ->select([
                                    'challenge_id',
                                    'challengeforumtitle_id',
                                    'count' => $q->func()->count('*') ])
                               ->group(['challenge_id','challengeforumtitle_id']);
                            }, 
                        'Challengeforumtitles']);
                    $render = 'forum_index';
                }
                break; 

            case 'updates':
                $result = $this->getTableLocator()->get('Admin.Posts')->find('all')
                    ->where(['post_type'=>'chupdates'])
                    ->order(['created'=>'desc'])
                    ->contain(['Postmetas'])
                    ->join([
                        'table' => 'post_metas','alias' => "pm1",'type' => 'LEFT',
                        'conditions' => ["pm1.post_id = Posts.id"] ])
                    ->where([
                        "pm1.meta_key"=>'challenge_id', 
                        "pm1.meta_value"=> $challenge_id ]);
                $this->set([
                    'posts' => $result->toarray()
                ]);
                $render = 'updates';
                
                break;

            case 'community':   
                $challenge = $challenge->contain(['Challengetexts']);
                $users =  
                $this->Challenges->Challengeuserforms
                    ->find('list',['keyField' => 'user_id','valueField' => 'user_id'])
                    ->where(['Challenge_id'=>$challenge_id ])
                    ->toarray();

                $this->Challengeuserprofiles = $this->getTableLocator()->get('Challenge.Challengeuserprofiles');
                $query = $this->Challengeuserprofiles->find('list',['keyField' => 'provice','valueField' => 'count']);
                if(count($users)){
                    $all = $query->select([
                            'provice',
                            'count' => $query->func()->count('*'),
                            ])
                        ->where(['user_id IN'=> $users])
                        ->group(['provice'])
                        ->toarray();
                    $query = $this->Challengeuserprofiles->find('list',['keyField' => 'single','valueField' => 'count']);
                    $user = $query->select([
                            'single',
                            'count' => $query->func()->count('*'),
                            ])
                        ->where(['user_id IN'=> $users])
                        ->group(['single'])
                        ->toarray();
                }
                else{
                    $all = [];
                    $user = [];
                }
                            
                $this->set([
                   'user' => $user,
                   'all'=> $all
                ]);
                $render = 'community';
                break;

            case 'press':    
                $result = $this->getTableLocator()->get('Admin.Posts')->find('all')
                    ->where(['post_type'=>'chnews'])
                    ->order(['created'=>'desc'])
                    ->contain(['Postmetas'])
                    ->join([
                        'table' => 'post_metas','alias' => "pm1",'type' => 'LEFT',
                        'conditions' => ["pm1.post_id = Posts.id"] ])
                    ->where([
                        "pm1.meta_key"=>'challenge_id', 
                        "pm1.meta_value"=> $challenge_id ]);
                $this->set([
                    'posts' => $result->toarray()
                ]);
                $render = 'press';
                break;

            case 'resources':    
                $result = $this->getTableLocator()->get('Admin.Posts')->find('all')
                    ->where(['post_type'=>'chresource'])
                    ->order(['created'=>'desc'])
                    ->contain(['Postmetas'])
                    ->join([
                        'table' => 'post_metas','alias' => "pm1",'type' => 'LEFT',
                        'conditions' => ["pm1.post_id = Posts.id"] ])
                    ->where([
                        "pm1.meta_key"=>'challenge_id', 
                        "pm1.meta_value"=> $challenge_id ]);
                $this->set(['posts' => $result->toarray()]);
                $render = 'resource';
                break;

            default:
                $challenge = $challenge->contain(['Challengetexts']);
                $render = 'overview';
                break;
        }
        $challenge = $challenge->first();
        $this->set('forum_count',$this->Challenges->Challengeforums->find('all')
            ->where(['Challengeforums.challenge_id'=>$challenge_id,'enable'=>1])
            ->select(['challenge_id'])->count());
        $this->set([
            'challenge' => $challenge,
            'page' => $page
            ]);
            
        $viewModel = $this->getTableLocator()->get('Challenge.Challengeviews');
        if(isset($challenge->challengeviews[0]['views'])){
            $views = ($challenge->challengeviews[0]['views']);
            $query = $viewModel->query();
            $query->update()
                ->set(["views = $views+ 1"])
                ->where(['id' => $challenge->challengeviews[0]['id'] ])
                ->execute();
        }
        else{
            $viewModel->save($viewModel->newEntity([
                'challenge_id'  => $challenge['id'],
                'views' => 1 ,
            ]));
            $challenge->challengeviews[0]['views'] = 1;
        }
        try{
            $this->render('Template.Challenges/'.$render);
        }
        catch (\Exception $e){
            $this->render($render);
        }
    }
    //-----------------------------------------------------------------------------

    public function profile($num = null, $num2 = null){
        try{
            $this->viewBuilder()->setLayout('Template.profile');
        }
        catch (\Exception $e){
            $this->viewBuilder()->setLayout("profile");
        }
        
        if( !$this->Auth->user()){
            return $this->redirect(['plugin'=>false,'controller'=>'users','action'=>'login']);
        }
        $user = $this->getTableLocator()->get('Challenge.Challengeuserprofiles')->find('all')
            ->where(['user_id'=> $this->request->getAttribute('identity')->get('id')])
            ->contain(['Users','Challengetopics'])
            ->first();
        $predata = new Predata();
        $this->set([
            'user_profiles' => $user,
            'eductions' => $predata->gettype('eductions'),
            'group' => $predata->gettype('group'),
            'gender' => $predata->gettype('gender'),
            'center' => $predata->gettype('center'),
        ]);
        $this->_profile_default();
        switch ($num) {
            case 'challenge':
                $this->_profile_challenge($num2);
                $this->set(['page'=>'profile/challenge']);
                try{
                    $this->render('Template.profile/my_challenge');
                }
                catch (\Exception $e){
                    $this->render('/Challenges/profile/my_challenge');
                }
                break;
            
            case 'edit':
                $this->_profile_edit();
                $this->set(['page'=>'profile/edit']);
                try{
                    $this->render('Template.profile/edit');
                }
                catch (\Exception $e){
                    $this->render('/Challenges/profile/edit'); //Read From plugins\Challenge\src\Template\Element
                }
                break;

            case 'password':
                $id = $this->getRequest()->getSession()->read('Auth.User.id');
                $this->set(['users'=> $this->getTableLocator()->get('Admin.Users')->get($id, ['contain' => ['UserMetas']])]);
                $this->set(['page'=>'profile/password']);
                $this->render('/Challenges/profile/password');
                break;

            default:
                $this->_profile_default();
                $this->set(['page'=>'profile/index']);
                try{
                    $this->render('Template.profile/default');
                }
                catch (\Exception $e){
                    $this->render('/Challenges/profile/default');
                }
                break;
        }
    }
    function _profile_challenge($id = null){
        $this->Userforms = $this->getTableLocator()->get('Challenge.Challengeuserforms');
        $results = $this->Userforms->find('all')
                ->where(['Challengeuserforms.user_id'=>$this->request->getAttribute('identity')->get('id')])
                ->order(['Challengeuserforms.id'=>'desc'])
                ->contain([
                    'Challenges'=>[
                        'Challengerelateds'=>['Challenges'], 
                        'Challengestatuses', 
                        'Challengecats', 
                        'Challengetags', 
                        'Challengetopics', 
                        'Challengeimages', 
                        'Challengepartners',
                        'Challengeviews',
                    ]
                ])
                ->toarray();
        $this->set(compact('results'));

        if ($this->request->is(['post','put','patch']) and isset($this->request->getParam('?')['getword']) ) {
            $export = new Export();
            $url = $export->getword($id,$this->Auth->user());
            $this->redirect($url);
        }
        ///----------------------------------------------------------------
        if ($this->request->is(['post','put','patch']) and isset($this->request->getParam('?')['getpdf']) ) {
            $this->autoRender = false;
            $export = new Export();
            $url = $export->getpdf($id,$this->Auth->user());
            //$this->redirect($url);
        }
    }
    //####################
    function _profile_default(){
        $user = $this->getTableLocator()->get('Challenge.Challengeuserprofiles')->find('all')
            ->where(['user_id'=> $this->request->getAttribute('identity')->get('id')])
            ->contain(['Users','Challengetopics'])
            ->first();
        $public = $this->Auth->user();
        $this->set(compact('user','public'));
    }
    //####################
    function _profile_edit(){
        $user = $this->getTableLocator()->get('Challenge.Challengeuserprofiles')->find('all')
            ->where(['user_id'=> $this->request->getAttribute('identity')->get('id')])
            ->contain(['Users','Challengetopics']);
        $this->userprofiles = $this->getTableLocator()->get('Challenge.Challengeuserprofiles');
        $tmp = null;
        if($user->first()){
            $userprofiles = $user->first();
            try {
                //echo $userprofiles['extra'];
                if($userprofiles['extra'] != '')
                    $userprofiles['extra'] = unserialize($userprofiles['extra']);
            } catch (\Throwable $th) {
                $userprofiles['extra'] = [];
            }
        }
        else
            $userprofiles = $tmp = $this->userprofiles->newEntity();

        if ($this->request->is(['post','put','patch'])) {
            if($user->first()){
                $this->request = $this->request->withData('id',$user->first()['id'] );
                //$this->request = $this->request->withData('single',1); //کاربر حقیقی ثبت شود همیش
            }

            if(!empty($this->request->getData()['file']['name'])) {		
                $fuConfig['upload_path']    = WWW_ROOT . 'profile/';	
                if (!file_exists($fuConfig['upload_path'])) {
                    mkdir($fuConfig['upload_path'], 0777, true);
                }		
                $fuConfig['allowed_types']  = 'jpg';
                $fuConfig['file_name']  = 'prf'.'_'.$this->request->getAttribute('identity')->get('id').'_'.date('m-d-h').'_'.rand(1000,9999);			
                $fuConfig['max_size'] = 20000;			
                $this->Fileupload->init($fuConfig);				
                if (!$this->Fileupload->upload('file')){
                    $fError = $this->Fileupload->errors();
                    if($fError[0] == 'upload_invalid_filetype'){
                        $this->request->getData()['file'] = ['_error'=>'ExtNotAllowed'];
                    } else {
                        $this->request->getData()['file'] = ['_error'=>'FileNotUpload'];
                    }					
                } else {
                    if($user->first()){
                        $this->request = $this->request->withData('id',$user->first()['id'] );
                        $file = new File(WWW_ROOT . 'profile/'.$user->first()['image'], false, 0777);
                        $file->delete();
                    }
                    $this->request = $this->request->withData('image',$this->Fileupload->output('file_name') );
                }
            } else {
                //$this->request = $this->request->withData('image',null );
            }

            $this->request = $this->request->withData('user_id',$this->request->getAttribute('identity')->get('id') );
            if(isset($this->request->getData()['extra'])){
                foreach($this->request->getData()['extra'] as $ext => $exv){
                    $this->request = $this->request->withData("extra.$ext",strip_tags($exv));
                }
                $this->request = $this->request->withData('extra',serialize($this->request->getData()['extra']));
            }
            $userp = $this->userprofiles->patchEntity($userprofiles, $this->request->getData());
            /* if(isset($this->request->getData()['single']) and $this->request->getData()['single'] == 1){
                $userp->center = null;
                $userp->center_name = null;
                $userp->semat = null;
            } */
            if ($this->userprofiles->save($userp)) {
                //update profile image of site header
                $this->request->getSession()->write('profile',
                    $this->getTableLocator()->get('Challenge.Challengeuserprofiles')->find('all')
                        ->where([ 'user_id'=> $this->request->getSession()->read('Auth.User.id') ])->first()
                );
                if($tmp == null){
                    $this->Flash->success(__('ثبت اطلاعات پروفایل شما با موفقیت انجام شد'));
                    return $this->redirect('/challenge/profile/index?saved');
                }
                else{
                    return $this->redirect($this->referer());
                }
            }
            else
                $this->Flash->error(__('متاسفانه بروز رسانی با موفقیت انجام نشد'));

        }
        $challengetopics = $this->userprofiles->Challengetopics->find('list', ['limit' => 200]);

        $this->set(compact('userprofiles','challengetopics'));

    }
    //####################
    public function api($ch_id = null){
        
    }
    //####################
    private function _challengequests($ch_id = null){
        
        $this->Challengequests = $this->getTableLocator()->get('Challenge.Challengequests');

        if(! $this->request->is('ajax')){
            $response = $this->response->withType('application/json')->withStringBody(json_encode('error07'));
            return $response;
        }

        if ($this->request->getQuery('ajax') and $this->request->getQuery('ajax') ==  1) {
            $lists = [];
            $pp = $this->Challengequests
                ->find('threaded')
                ->where([ 'challenge_id'=> $ch_id])
                ->select(['id','types','title','parent_id'])
                //->order(['id' =>'asc'])
                ->order(['priority' =>'asc'])
                ->enablehydration(false)
                ->toarray();

            if ($this->request->getQuery('parent') and $this->request->getQuery('parent') == "no" ) {
                foreach($pp as $k=> $pps){
                    if(isset($pps['children'])){
                        foreach($pps['children'] as $k2=> $pps2){
                            if(isset($pps2['children']))
                            unset($pp[$k]['children'][$k2]['children']);
                        }
                    }
                }
                $lists = $pp;
            }
            else{
                $lists = $this->Challengequests
                    ->find('children', ['for' => $this->request->getQuery('parent')  ])
                    ->find('threaded')
                    ->where(['challenge_id'=> $ch_id , ])
                    ->select(['id','types','title','parent_id'])
                    ->enablehydration(false)
                    ->toarray();
            }
            $response = $this->response->withType('application/json')->withStringBody(json_encode($lists));
            return $response;
        }
    }
    //####################
}
