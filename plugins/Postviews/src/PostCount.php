<?php
namespace Postviews;
use Cake\ORM\TableRegistry;
use Exception;
class PostCount
{
    public $post_id;
    public $PostMetas;
    public function __construct(){}
    public function visit_save($options = []){

        $this->PostMetas = TableRegistry::getTableLocator()->get('Admin.PostMetas');
        $temp = $this->PostMetas->find('all')
            ->where(['meta_key' => 'post_views','post_id' => $this->post_id])
            ->first();

        if( $temp ){
            $tmp = $this->PostMetas->get($temp['id']);
            $tmp->meta_value = $temp['meta_value'] + 1;
            $this->PostMetas->save($tmp);
        }
        else{
            $result = $this->PostMetas->newEmptyEntity();
            $result = $this->PostMetas->patchEntity($result,[
                'post_id' => $this->post_id ,
                'meta_value'=> 1,
                'meta_type'=>'meta',
                "meta_key"=>  "post_views" ]);
            $this->PostMetas->save($result);
        }
    }
}