<?php
namespace Admin\View\Cell;
use CellTrait;

use Cake\View\Cell;

class FavoriteCell extends Cell
{
    protected $_validCellOptions = [];
    public function initialize()
    {
        
    }
    public function display($id = null)
    {
        $this->loadModel('Posts');
		$total_posts = $this->Posts->find()->count();
		$recent_posts = $this->Posts->find()
            ->select('title')
            ->order(['created' => 'DESC'])
            ->limit(3)
            ->toArray();
            
		$this->set(['total_posts' => $total_posts, 'recent_posts' => $recent_posts]);
    }
    public function upload(){
        
    }
}