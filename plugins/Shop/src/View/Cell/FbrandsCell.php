<?php
namespace Shop\View\Cell;

use Cake\ORM\TableRegistry;
use Cake\View\Cell;
class FbrandsCell extends Cell{
    protected $_validCellOptions = [];
    public function initialize(): void
    {}
    public function admin($field = null , $value = null){
        $this->set([
            'field' => $field ,
            'value' => $value ]);
    }
    public function display($value = null){
        global $list_id;
        $p = $this->getTableLocator()->get('Shop.ShopProductMetas')
                ->find('list',['keyField'=>'meta_value','valueField'=>'meta_value'])
                ->where([ 
                    "meta_key"=>'brands',
                    'meta_value !=' => '']);
        if($list_id != null and count($list_id))
            $p->where(['post_id IN '=> $list_id]);
        $p->toarray();
        $this->set([ 
            'value' => $value ,
            'brand_list' => $p
        ]);
    }
}