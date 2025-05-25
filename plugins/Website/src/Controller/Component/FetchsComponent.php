<?php
namespace Website\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\Http\Exception\NotFoundException;
use Cake\ORM\TableRegistry;
use Admin\View\Helper\FuncHelper;

class FetchsComponent extends Component {
    protected $_defaultConfig = [];
    public $components = ['Paginator','Session'];
    public function initialize(array $config): void{}
    public function home($id = null){}
    public function index() {
        
        global $is_status;
        global $id ;
        global $category;
        global $post_type;
        global $cond;
        global $results;
        global $index_posttype;
        global $model;
        global $limit;

        $param = $this->request->getQuery();

        $is_status = 'index';
        $id = ($this->request->getParam('catid'))?strip_tags($this->request->getParam('catid')):null;
        $post_type = ($this->request->getParam('posttype'))?strip_tags($this->request->getParam('posttype')):
            ($post_type != '' ? $post_type: null);

        $cond = [
            'limit'=> intval($limit) != 0?$limit:20,
            'paramType' => 'querystring'
        ];

        $category = null;
        if( $id != null):
            $category = TableRegistry::getTableLocator()->get('Admin.Categories')
                ->find('all')
                ->contain(['CategorieMetas'])
                ->where(['Categories.id'=> $id])
                ->first();
        endif;

        if(isset($this->request->getParam('?')['count']) and
            $this->request->getParam('?')['count'] and 
            intval($this->request->getQuery('count')) != 0 and 
            intval($this->request->getParam('?')['count']) < 100 and 
            intval($this->request->getParam('?')['count']) > 0){
            $cond['limit'] = intval($this->request->getParam('?')['count']);
        }
        if($post_type == '')
            $post_type = unserialize($index_posttype);
            

        //$param = $this->request->getparam('?');
        $model = TableRegistry::getTableLocator()->get('Admin.Posts');
        $results = $model
            ->find('all')
            ->where([
                $this->request->getSession()->read('Auth.User.id') != NULL?[]:['Posts.post_status !=' => 2],
                'Posts.published' => 1,
                'Posts.created <=' => date('Y-m-d H:i:s')
                ])
            ->contain(['Categories'=>['CategorieMetas'],'Tags','PostMetas','PostsI18n'])
            ->group(['Posts.id'])
            ->enableAutoFields(true)
            ->order(['Posts.created'=>'desc'])
            ;
        //--
        if(is_array($post_type)){
            $results->where(['Posts.post_type IN' => $post_type]);
        }
        elseif($post_type != null){
            $results->where(['Posts.post_type' => $post_type]);
        }
        //--
        if($id != null ){
            $catlist = TableRegistry::getTableLocator()->get('Admin.Categories')
                ->find('children', ['for' => $id])
                ->find('list',['keyField'=>'id','valueField'=>'id'])
                ->toarray();
            $catlist[$id] = $id;
            $results->matching('Categories',
                function ($q) use ($catlist){
                    return $q->where(['Categories.id IN ' => $catlist ]);
                });
        }
        
        if(isset($param['s']) and $param['s'] != ''){
            
            if($post_type == 'product'){
                $param['s'] = preg_replace('/(?<=[a-z])(?=\d)|(?<=\d)(?=[a-z])/i', ' ', $param['s']);
                $ls = explode(' ',$param['s']);
                if(count($ls) > 1){ foreach($ls as $l){
                    $results->where([ 
                        'AND'=>[
                            $model->translationField("title").' LIKE' => "%".strip_tags($l)."%",
                        ]
                    ]);
                }}
                else{
                    $results->where([
                        $model->translationField('title').' LIKE' => "%".strip_tags($param['s'])."%",
                    ]);
                }
            }else{
                $results->where([
                    $model->translationField('title').' LIKE ' => "%".strip_tags($param['s'])."%"
                ]);
            }
        }
    }
    public function archive($id = null){}
    public function category($id = null , $post_type = []){
        global $is_status;
        global $id ;
        global $category;
        global $post_type;
        global $cond;
        global $results;
        global $index_posttype ;
        global $model;

        //$id = $this->request->getParam('catid')?$this->request->getParam('catid'):$id;
        $slug = $this->request->getParam('catslug')?strip_tags($this->request->getParam('catslug')):'';
        //$post_type = $this->request->getParam('posttype')?$this->request->getParam('posttype'):'post';
        $param = $this->request->getParam('?');

        $model = TableRegistry::getTableLocator()->get('Admin.Categories');
        $results = $model
            ->find('all')
            ->order(['Categories.created'=>'desc'])
            //->enablehydration(false)
            ->contain(['CategorieMetas']);
        //--
        if(is_array($post_type)){
            $results->where(['Categories.post_type IN' => $post_type]);
        }
        elseif($post_type != null){
            $results->where(['Categories.post_type' => $post_type]);
        }
        //--
        if($id != null){
            /*$results->matching('Categories',
                function ($q) use ($id){
                return $q->where(['Categories.id' => $id]);
            });*/
        }
        //--
        //return $results;
    }
    public function category_single($id = null , $post_type = [])
    {
        $id = $this->request->getParam('catid')?strip_tags($this->request->getParam('catid')):$id;
        $slug = $this->request->getParam('catslug')?strip_tags($this->request->getParam('catslug')):'';
        $post_type = $this->request->getParam('posttype')?strip_tags($this->request->getParam('posttype')):'post';
        $param = $this->request->getParam('?');

        $model = TableRegistry::getTableLocator()->get('Admin.Categories');
        $result = $model
            ->find('all')
            ->order(['Categories.created'=>'desc'])
            //->enablehydration(false)
            ->contain(['CategorieMetas']);
        //--
        if(is_array($post_type)){
            $result->where(['Categories.post_type IN' => $post_type]);
        }
        elseif($post_type != null){
            $result->where(['Categories.post_type' => $post_type]);
        }
        //--
        if($id != null){
            $result->where(['Categories.id' => $id]);
        }
        //--
        return $result;
    }

    public function single(){
        global $is_status;
        global $id;
        global $result;
        $result = TableRegistry::getTableLocator()->get('Admin.Posts')
            ->find('all')
            ->where([
                $this->request->getSession()->read('Auth.User.id') != NULL?[]:['Posts.post_status !=' => 2],
                'Posts.published' => 1,
                'Posts.created <=' => date('Y-m-d H:i:s')
            ])
            ->contain(['Categories','PostsI18n','PostMetas','Users','Tags']);

        if($this->request->getParam('slug')){
            $result = $result->where([
                'slug' => strip_tags($this->request->getParam('slug')),
                'Posts.published' => 1 ,
                $this->request->getSession()->read('Auth.User.id') != 'NULL'?[]:['Posts.post_status !=' => 2],
            ]);
        }
        elseif($id != null){
            $result = $result->where([
                'Posts.id' => intval($id),
                'Posts.published' => 1 ,
                $this->request->getSession()->read('Auth.User.id') != 'NULL'?[]:['Posts.post_status !=' => 2],
            ]);
        }else{
            $result = false;
        }

        if($result)
            $result = $result->first();

        if(isset($result['id'])){
            $id = $result['id'];
            $this->request = $this->request->withParam('id',$id);
        }

        if($this->request->getParam('id'))
            $id = strip_tags($this->request->getParam('id'));

        if (empty($id)) {
            //throw new NotFoundException(__d('Website', 'Page not found11'));
        }
        
        try{
            if(! $this->request->getSession()->read('postviews.'.$id)){
                $temp = new \Postviews\PostCount();
                $temp->post_id = $id;
                $temp->visit_save();
                $this->request->getSession()->write('postviews.'.$id, $id);
            }
        }
        catch (\Exception $e){}
    }

    public function tag($slug = null){
        global $is_status;
        global $id ;
        global $category;
        global $post_type;
        global $cond;
        global $results;
        global $index_posttype ;
        global $model;

        $model = TableRegistry::getTableLocator()->get('Admin.Posts');
        $results = $model->find('all')
            ->contain(['Categories','Tags','PostMetas','PostsI18n'])//,'Users'
            ->where([
                $this->request->getSession()->read('Auth.User.id') != NULL?[]:['Posts.post_status !=' => 2],
                'Posts.published' => 1,
                'Posts.created <=' => date('Y-m-d H:i:s')
                ])
            ->order(['Posts.created'=>'desc'])
            ->matching('Tags',
                function ($q) use ($slug){
                return $q->where(['Tags.slug' => strip_tags($slug)]);
            });
    }

    public function search($slug = null){
        $slug = strip_tags($slug);
        global $is_status;
        global $id ;
        global $category;
        global $post_type;
        global $cond;
        global $results;
        global $index_posttype ;
        global $model;
        
        $model = TableRegistry::getTableLocator()->get('Admin.Posts');
        $results = $model->find('all')
            ->order(['Posts.created'=>'desc'])
            ->contain(['Categories','Tags','PostMetas','PostsI18n'])//,'Users'
            ->where([
                $this->request->getSession()->read('Auth.User.id') != NULL?[]:['Posts.post_status !=' => 2],
                'Posts.published' => 1,
                'Posts.created <=' => date('Y-m-d H:i:s'),
                'Posts.post_type !=' => 'media',
            ]);
        if($this->request->getQuery('type')){
            switch ($this->request->getQuery('type')) {
                case 'descr':
                    $results->where([
                        $model->translationField('content').' LIKE' => "%".strip_tags($slug)."%"
                    ]);
                    # code...
                    break;
                
                case 'title':
                    $results->where([
                        $model->translationField('title').' LIKE' => "%".strip_tags($slug)."%"
                    ]);
                    break;

                default:
                    # code...
                    break;
            }
        }
        else{
            $results->where([
                'OR' => [
                    $model->translationField('title').' LIKE' => "%".strip_tags($slug)."%",
                    $model->translationField('content').' LIKE' => "%".strip_tags($slug)."%"
                ],
            ]);
        }

        if($this->request->getQuery('post_type') and $this->request->getQuery('post_type') != ''){
            $list_type = explode(',',$this->request->getQuery('post_type'));
            $results->where(['AND'=>['post_type IN '=> $list_type ]]);
        }
    }
}