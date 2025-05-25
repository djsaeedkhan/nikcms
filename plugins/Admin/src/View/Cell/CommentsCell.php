<?php
namespace Admin\View\Cell;

use Cake\ORM\TableRegistry;
use Cake\View\Cell;
class CommentsCell extends Cell
{
    protected $_validCellOptions = [];
    public function initialize(): void
    {}
    public function display($ids = null, $attr = []){
        global $result;
        $id = null;
        $form = false;
        $viewlist = false;
        
        if(isset($result['id']) and $ids == null) 
            $id = $result['id'];
        if($ids != null) 
            $id = $ids;

        if(in_array('form',$attr) and $id != null):
            $form = true;
        endif;

        if(in_array('viewlist',$attr) and $id != null):
            $viewlist = true;
            $this->set([
                'comments'=> $this->getTableLocator()->get('Admin.Comments')->find('all')
                    ->where(['approved' => 1 , 'post_id' => $id])
                    ->order(['Comments.id' => 'desc'])
                    ->contain(['Users',])
                    ->toarray()
                ]);
        endif;

        $this->set([
            'user'=> $this->request->getSession()->read('Auth.User'),
            'form' => $form,
            'viewlist' => $viewlist,
            'id'=> $id
        ]);
    }
}