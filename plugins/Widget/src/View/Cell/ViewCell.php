<?php
namespace Widget\View\Cell;
use Cake\View\Cell;

class ViewCell extends Cell
{
    public function display($name = null){
        $this->set([
            'name' => $name ]);
    }

    public function admin($widget = null , $value = null){
        $this->set([
            'widget' => $widget,
            'value' => $value ]);
    }
}
