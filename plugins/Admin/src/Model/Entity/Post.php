<?php
namespace Admin\Model\Entity;

use Admin\View\Helper\FuncHelper;
use Cake\ORM\Entity;

class Post extends Entity
{
    protected $_accessible = [
        'title' => true,
        'slug' => true,
        'summary' => true,
        'content' => true,
        'image' => true,
        'published' => true,
        'post_status' => true,
        'in_rss' => true,
        'meta_title' => true,
        'meta_description' => true,
        'meta_keywords' => true,
        'user_id' => true,
        'post_type' => true,
        'created' => true,
        'modified' => true,
        'user' => true,
        'comments' => true,
        'post_metas' => true,
        'shop_favorites' => true,
        'shop_orderproducts' => true,
        'shop_product_metas' => true,
        'shop_product_params' => true,
        'shop_productdetails' => true,
        'shop_productmajors' => true,
        'shop_productprices' => true,
        'shop_productstocks' => true,
        'tickets' => true,
        'categories' => true,
        'i18n' => true,
        'tags' => true,
    ];

    protected $_virtual = ['meta_list'];
    protected function _getmetaList()
    {
        if($this->get('post_metas')):
            $this->Func = new FuncHelper(new \Cake\View\View());
            $tmp = [];

            foreach($this->get('post_metas') as $d){
                if(isset($d['meta_key'])):
                    $tmp[$d['meta_key']] = $this->Func->is_serial($d['meta_value'])?unserialize($d['meta_value']):$d['meta_value'];
                endif;
            }

            return $tmp;
        endif;
    }
}