<?php
namespace Admin\View\Cell;

use Cake\View\Cell;

/**
 * Published cell
 */
class PublishedCell extends Cell
{
    protected $_validCellOptions = [];
    public function display($setting = null)
    {
        $this->set([
            'setting' => $setting
        ]);
    }
}