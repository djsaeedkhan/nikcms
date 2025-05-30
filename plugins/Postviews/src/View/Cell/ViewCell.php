<?php
namespace Postviews\View\Cell;
use Cake\View\Cell;
use Cake\ORM\TableRegistry;

class ViewCell extends Cell
{
    public function add($post_id = null, $action = null)
    {}
    public function view($post_id = null)
    {
		$temp = TableRegistry::getTableLocator()->get('Admin.PostMetas')->find('all')
            ->where(['meta_key'=>'post_views','post_id'=>$post_id])
            ->first();
        $this->set('views',isset($temp->meta_value)?$temp->meta_value:'');
    }
}
