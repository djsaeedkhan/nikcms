<?php
namespace Seo\View\Cell;
use Cake\View\Cell;
use Admin\View\Helper\FuncHelper;
use Cake\View\View;

class DisplayCell extends Cell
{
    protected $_validCellOptions = [];
    public $FuncHelper;  
    public function initialize(): void
    {
        $view = new View();
        $this->FuncHelper = new FuncHelper($view);
        $options = [];
        $result = $this->FuncHelper->OptionGet('seo_plugin');
        if(isset($result['seo_plugin']))
            $options = unserialize($result['seo_plugin']);
        if(isset($options['setting']))
            $options = $options['setting'];

        $this->set(['opt' =>$options ]);
    }
    public function display(){
    }
    public function display2(){
    }
}
