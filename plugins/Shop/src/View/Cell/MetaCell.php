<?php
namespace Shop\View\Cell;

use Cake\Log\Log;
use Cake\ORM\TableRegistry;
use Cake\View\Cell;
class MetaCell extends Cell{
    protected $_validCellOptions = [];
    public function initialize(): void
    {}
    public function save(){
        //$this->loadComponent('Shop.Product');
        //$this->Product->Save();
    }
    public function product($posttype = null, $post_meta_list = null){
        $param = $this->getTableLocator()->get('Shop.ShopParams')->find('list',['keyfield'=>'id','keyValue'=>'title'])->toarray();
        $this->set([
            'params'=> $param,
            'post_meta_list' =>$post_meta_list,
            'posttype'=>$posttype,
        ]);
    }
}