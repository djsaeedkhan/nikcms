<?php
namespace Ticketing\Controller;
use Ticketing\Controller\AppController;
use Cake\ORM\TableRegistry;

class SettingController extends AppController
{
    public function initialize(){
        parent::initialize();
        $this->viewBuilder()->setLayout('Admin.default');
    }
    public function index(){
        $result = TableRegistry::getTableLocator()->get('Admin.Options')
            ->find('list',['keyField'=>'name','valueField'=>'value'])
            ->where(['name' => 'plugin_ticket'])
            ->toArray();
        $this->set('result', $result);
    }
}