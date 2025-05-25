<?php
namespace Formbuilder\View\Cell;
use Cake\View\Cell;
use Cake\ORM\TableRegistry;

class ViewCell extends Cell
{
    protected $_validCellOptions = [];
    public function initialize(): void
    {
    }
    public function display( $id = null){
        if($id == null){
            $this->viewBuilder()->setTemplate(false);
            return false;
        }
        
        $this->Formbuilders = TableRegistry::getTableLocator()->get('Formbuilder.Formbuilders');
        $result = null;
        if(is_numeric($id))
            $result = $this->Formbuilders->find('all')->contain(['FormbuilderItems'])->where(['id' => $id , 'enable' => 1])->first();
        else
            $result = $this->Formbuilders->find('all')->contain(['FormbuilderItems'])->where(['title' => $id, 'enable' => 1])->first();
        
        if( !$result ){
            $this->viewBuilder()->setTemplate(false);
            return false;
        }
        $this->set('result',$result);
        $this->set('item', $result->toarray()['formbuilder_items'][0]);
    }
}
