<?php
namespace Challenge\Controller;
use Challenge\Controller\AppController;
use Cake\ORM\TableRegistry;
class SettingController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->viewBuilder()->setLayout('Admin.default');
    }
    public function index(){
        $result = TableRegistry::getTableLocator()->get('Admin.Options')
            ->find('list',['keyField'=>'name','valueField'=>'value'])
            ->where(['name' => 'plugin_challenge'])
            ->toArray();
        $this->set('result', $result);
    }
}