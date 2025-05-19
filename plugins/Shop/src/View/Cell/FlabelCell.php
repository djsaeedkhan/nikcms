<?php
namespace Shop\View\Cell;
use Cake\View\Cell;

class FlabelCell extends Cell
{
    protected $_validCellOptions = [];
    public function initialize()
    {
    }
    public function admin($field = null , $value = null){
        $this->set([
            'field' => $field ,
            'value' => $value ]);
    }
    public function display($value = null){
        $this->set([
            'value' => $value ]);
    }
}
