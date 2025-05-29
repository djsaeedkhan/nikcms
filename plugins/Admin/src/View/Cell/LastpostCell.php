<?php
namespace Admin\View\Cell;

use Cake\View\Cell;
use Cake\ORM\TableRegistry;

class LastpostCell extends Cell
{
    public function display($setting = null)
    {
        $this->set([
            'setting' => $setting,
            'last_post'=>
                $this->getTableLocator()->get('Admin.Posts')->find('all')
                    ->contain(['PostsI18n'])
                    ->where(['post_type !='=>'media'])
                    ->order('Posts.id desc')->limit(8)->toarray()]);
    }
}
