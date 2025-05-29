<?php
namespace Admin\View\Cell;

use Cake\View\Cell;
use Cake\ORM\TableRegistry;

class WgtMenuCell extends Cell
{
    /**
     * List of valid options that can be passed into this
     * cell's constructor.
     *
     * @var array
     */
    public function admin($field = null , $value = null){
        $this->set([
            'field' => $field ,
            'value' => $value,
            'AllMenu' => $this->getTableLocator()->get('Admin.Options')->find('list')
                ->select(['id','name'])
                ->contain(false)
                ->where(['types' => 'nav_menu'])
                ->order(['id' => 'desc'])
                ->toarray()
            ]);
    }
    public function display($value = null , $sidebar = null){
        $this->set([
            'value' => $value,
            'sidebar' => $sidebar,
        ]);
    }
}
