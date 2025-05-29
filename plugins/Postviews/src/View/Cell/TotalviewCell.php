<?php
namespace Postviews\View\Cell;
use Cake\View\Cell;

class TotalviewCell extends Cell
{
    public function display($setting = null)
    {
        $this->set([
            'setting' => $setting
        ]);
    }
}