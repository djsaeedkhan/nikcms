<?php
namespace Shop\View\Cell;

use Cake\View\Cell;
use Cake\ORM\TableRegistry;
use Cake\I18n\I18n;

class MenuCell extends Cell
{
    protected $_validCellOptions = [];
    public function initialize(){
        I18n::setLocale('fa');
    }

    public function post($post_type = 'post', $menu = [])
    {
        $data = $this->getTableLocator()->get('Admin.Posts')->find('list')
            ->select(['id','title'])
            ->order(['Posts.id'=>'desc'])
            ->where(['post_type'=>$post_type,'published'=> 1])
            ->toarray();
        $this->set([
            'data'=>$data,
            'title' => (isset($menu[$post_type]['name']['index_header'])?$menu[$post_type]['name']['index_header']:''),
            'post_type' => $post_type
        ]);
    }

    public function category($post_type = null,  $menu = [])
    {
        $data = $this->getTableLocator()->get('Admin.Categories')
            ->find('list',['keyField'=>'id','valueField'=>'title'])
            ->where(['post_type'=>$post_type])
            ->order(['lft'=>'asc'])
            ->toarray();
        $this->set([
            'data'=>$data,
            'title' => (isset($menu[$post_type]['name']['cat_header'])?$menu[$post_type]['name']['cat_header']:''),
            'post_type' => $post_type
        ]);
    }
}