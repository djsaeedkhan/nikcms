<?php
namespace Seo\View\Cell;
use Cake\View\Cell;
use Cake\ORM\TableRegistry;

class GoogleaCell extends Cell{
    protected $_validCellOptions = [];
    public function initialize(): void
    {
        global $Func;
        $options = [];
        try {
            $options = $Func->OptionGet('seo_plugin');
        } catch (\Throwable $th) {
            $options = [];
        }

        $this->set(['options' => isset($options['seo_plugin'])?unserialize($options['seo_plugin']):[] ]);
    }
    public function display(){
    }
    public function display2(){
    }
}