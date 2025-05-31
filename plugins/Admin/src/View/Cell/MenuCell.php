<?php
namespace Admin\View\Cell;

use Cake\View\Cell;
use Cake\ORM\TableRegistry;
use Cake\ORM\Behavior;
//use Admin\Core\Func;
use Cake\I18n\I18n;

class MenuCell extends Cell
{

    protected $_validCellOptions = [];
    public function initialize(): void
    {
        parent::initialize();
        global $current_lang;
        I18n::setLocale($current_lang);
    }

    public function post($post_type = 'post', $menu = []){
        $data = $this->getTableLocator()->get('Admin.Posts')->find('list')
            ->contain(['PostsI18n'])
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

    public function category($post_type = null,  $menu = []){
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