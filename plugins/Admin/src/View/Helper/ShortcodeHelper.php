<?php
namespace Admin\View\Helper;

use Cake\View\Helper;
use Cake\View\View;

class ShortcodeHelper extends Helper
{
    protected $_defaultConfig = [];
    public function makeEdit($data)
    {
       return $data;
    }
}
