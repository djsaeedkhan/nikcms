<?php
namespace Template\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\ORM\TableRegistry;

class FetchComponent extends Component {
    protected $_defaultConfig = [];
    public $components = ['Paginator'];
    public function home($id = null){
    }
    
    public function index() {
        global $is_status;
        global $id ;
        global $category;
        global $post_type;
        global $cond;
        global $results;
        global $model;
        $param = $this->_registry->getController()->getRequest()->getQuery();
        //$param = $this->request->getQuery();

        $this->request = $this->_registry->getController()->getRequest();
        $j = 1;
        
        if(isset($param['search']) and $param['search'] != ''){
            $results->where([
                $model->translationField('title').' LIKE' => "%". $param['search']."%"
            ]);
        }

        if(isset($param['cattype']) and $param['cattype'] != ''){
            if(!is_array($param['cattype']))
                $ids = array($param['cattype']);
            else
                $ids = ($param['cattype']);
           
            $results->matching('Categories',
                function ($q) use ($ids){
                return $q->where(['Categories.id IN' => $ids ]);
            });
        }
        ++$j;

        if (isset($param['publisher']) and $param['publisher'] != '') {
            $results->join([
                'table' => 'post_metas','alias' => "pm{$j}",'type' => 'LEFT',
                'conditions' => ["pm{$j}.post_id = Posts.id"] ]);
            $results->where([
                "pm{$j}.meta_key"=>'publisher', 
                "pm{$j}.meta_value LIKE "=> '%'. $param['publisher'].'%']);
            ++$j;
        }
        
        if (isset($param['year']) and $param['year'] != '') {
            $results->join([
                'table' => 'post_metas','alias' => "pm{$j}",'type' => 'LEFT',
                'conditions' => ["pm{$j}.post_id = Posts.id"] ]);
            $results->where([
                "pm{$j}.meta_key"=>'year', 
                "pm{$j}.meta_value LIKE "=> '%'. $param['year']. '%']);
            ++$j;
        }

        if (isset($param['field']) and $param['field'] != '') {
            $results->join([
                'table' => 'post_metas','alias' => "pm{$j}",'type' => 'LEFT',
                'conditions' => ["pm{$j}.post_id = Posts.id"] ]);
            $results->where([
                "pm{$j}.meta_key"=>'field', 
                "pm{$j}.meta_value"=>  $param['field'] ]);
            ++$j;
        }

        if (isset($param['authors']) and $param['authors'] != '') {
            $results->join([
                'table' => 'post_metas','alias' => "pm{$j}",'type' => 'LEFT',
                'conditions' => ["pm{$j}.post_id = Posts.id"] ]);
            $results->where([
                "pm{$j}.meta_key"=>'authors', 
                "pm{$j}.meta_value LIKE "=> '%'. $param['authors'] . '%' ]);
            ++$j;    
        }
       
    
        /* if(isset($param['country']) and $param['country'] != ''){
            $results->join([
                'table' => 'post_metas','alias' => "pm{$j}",'type' => 'LEFT',
                'conditions' => ["pm{$j}.post_id = Posts.id"] ]);
            $results->where([
                "pm{$j}.meta_key"=>'country', 
                "pm{$j}.meta_value"=>$param['country']
            ]);
            ++$j;
        }
        if(isset($param['disciplines']) and $param['disciplines'] != ''){
            $results->join([
                'table' => 'post_metas','alias' => "pm{$j}",'type' => 'LEFT',
                'conditions' => ["pm{$j}.post_id = Posts.id"] ]);
            $results->where([
                "pm{$j}.meta_key"=>'disciplines', 
                "pm{$j}.meta_value LIKE "=>  '%"'.$param['disciplines'].'"%' ]);
            ++$j;
        }
            
        if(isset($param['topics']) and $param['topics'] != ''){
            $results->join([
                'table' => 'post_metas','alias' => "pm{$j}",'type' => 'LEFT',
                'conditions' => ["pm{$j}.post_id = Posts.id"] ]);
            $results->where([
                "pm{$j}.meta_key"=>'topics', 
                "pm{$j}.meta_value LIKE "=>  '%"'. $param['topics'].'"%' ]);
            ++$j;
        }

        
        /* ++$j;
        if(isset($param['center_name']) and $param['center_name'] != ''){
            $results->join([
                'table' => 'post_metas','alias' => "pm{$j}",'type' => 'LEFT',
                'conditions' => ["pm{$j}.post_id = Posts.id"] ]);
            $results->where([
                "pm{$j}.meta_key"=>'workplace', 
                "pm{$j}.meta_value LIKE "=> "%".$param['center_name']."%" ]);
        } */
        
        
        
        

        $results->order(['Posts.created'=>'desc']);
    }

    public function archive($id = null){
    }

    public function category($id = null , $post_type = []){
    }

    public function category_single($id = null , $post_type = []){
    }

    public function single($id = null)
    {
        $result = TableRegistry::get('Admin.Posts')->get($id,[
            'contain'=>['Categories','Tags','Users','PostMetas']]);
        return $result;
    }

    public function tag($slug = null)
    {
        global $is_status;
        global $id ;
        global $category;
        global $post_type;
        global $cond;
        global $results;
        global $index_posttype ;
        global $model;
    }

    public function search($slug = null)
    {
        global $is_status;
        global $id ;
        global $category;
        global $post_type;
        global $cond;
        global $results;
        global $index_posttype ;
        global $model;
    }
}