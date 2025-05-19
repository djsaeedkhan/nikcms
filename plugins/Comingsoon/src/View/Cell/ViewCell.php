<?php
namespace Comingsoon\View\Cell;

use Cake\View\Cell;

class ViewCell extends Cell
{
    protected $_validCellOptions = [];
    public function initialize()
    {
    }
    public function display()
    {
        global $Func;
        try {
            $result = $Func->OptionGet('coming_plugin');
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
