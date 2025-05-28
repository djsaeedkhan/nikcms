<?php
namespace Seo\View\Cell;
use Cake\View\Cell;
use Cake\View\View;
use Admin\View\Helper\FuncHelper;

class GoogleaCell extends Cell{
    protected $_validCellOptions = [];
    public $FuncHelper;  
    public function initialize(): void
    {
        $view = new View();
        $this->FuncHelper = new FuncHelper($view);
        $options = [];
        try {
            $options = $this->FuncHelper->OptionGet('seo_plugin');
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