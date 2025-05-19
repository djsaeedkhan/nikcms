<?php
namespace Seo\View\Cell;
use Cake\View\Cell;
use Cake\ORM\TableRegistry;

class DisplayCell extends Cell
{
    protected $_validCellOptions = [];
    public function initialize(){
        global $Func;
        $options = [];
        $result = $Func->OptionGet('seo_plugin');
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
