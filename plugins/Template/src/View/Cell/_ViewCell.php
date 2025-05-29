<?php
namespace Template\View\Cell;
use Cake\View\Cell;
use Cake\ORM\TableRegistry;
use Admin\View\Helper\QueryHelper;

class ViewCell extends Cell
{
    public function display( $id = null){
        if($id == null){
            $this->viewBuilder()->setTemplate(false);
            return false;
        }
        $this->Query = new QueryHelper(new \Cake\View\View());
        $result = $this->Query->post("",['id'=>$id,'get_type'=>'first', ]);
        $this->set('result',$result);
    }
}