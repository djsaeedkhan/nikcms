<?php
namespace Comingsoon\View\Cell;

use Cake\View\Cell;
use Admin\View\Helper\FuncHelper;
use Cake\View\View;

class ViewCell extends Cell
{
    protected $_validCellOptions = [];
    public $FuncHelper;
    public function display()
    {
        $view = new View();
        $this->FuncHelper = new FuncHelper($view);
        try {
            $result =$this->FuncHelper->OptionGet('coming_plugin');
        } catch (\Throwable $th) {
            $result = false;
        }
        
        if($result){
            $result = unserialize($result);
            $this->set('result', $result['setting']);
        }
        else{
            $this->set('result', []);
        }
            
    }
}
