<?php
namespace Widget\View\Cell;
use Cake\View\Cell;
class ManageCell extends Cell
{
    protected $_validCellOptions = [];
    public function initialize()
    {
    }
    public function display($name = null , $sidebar = null)
    {
        echo $this->_View->cell('Widget.Manage',["s" , $name]);
    }
}