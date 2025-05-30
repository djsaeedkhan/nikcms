<?php
namespace Admin\View\Cell;
use CellTrait;

use Cake\View\Cell;

class FavoriteCell extends Cell
{
    public function display($id = null)
    {
		$total_posts = TableRegistry::getTableLocator()->get('Admin.Posts')->find()->count();
		$recent_posts = TableRegistry::getTableLocator()->get('Admin.Posts')->find()
            ->select('title')
            ->order(['created' => 'DESC'])
            ->limit(3)
            ->toArray();
            
		$this->set([
            'total_posts' => $total_posts,
            'recent_posts' => $recent_posts
        ]);
    }
    public function upload(){
        
    }
}