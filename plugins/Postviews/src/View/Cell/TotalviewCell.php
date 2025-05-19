<?php
namespace Postviews\View\Cell;
use Cake\View\Cell;

class TotalviewCell extends Cell
{
    protected $_validCellOptions = [];
    public function initialize()
    {
    }
    public function display($setting = null)
    {
        $this->set([
            'setting' => $setting
        ]);
    }
}