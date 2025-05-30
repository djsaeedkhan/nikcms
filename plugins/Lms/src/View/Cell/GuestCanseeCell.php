<?php
namespace Lms\View\Cell;

use Cake\ORM\TableRegistry;
use Cake\View\Cell;
use Admin\View\Helper\FuncHelper;
use Cake\I18n\Time;
use DateTime;
use Lms\Checker;
class GuestCanseeCell extends Cell
{
    protected $_validCellOptions = [];
    public function initialize(): void
    {
    }

    public function display($id = null, $result = null){
        //$next = new Checker();
        //$status = $next->checkcurrent($id , $result['id'] , $this->user_id() , $this->request->getQuery());

        $this->set([
            'id'=> $id , 
            'result'=> $result,
           // 'status' => $status
        ]);
    }


    public function checkfilecan($course_id = null, $file_id = null){
        $current = new Checker();
        $current->checkcurrent($course_id, $file_id, $this->user_id(), $this->request->getQuery()) ;
    }
    public function user_id(){
        return $this->request->getAttribute('identity')->get('id');
    }
}
