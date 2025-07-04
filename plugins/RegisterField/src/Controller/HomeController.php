<?php
namespace RegisterField\Controller;
use RegisterField\Controller\AppController;
use Cake\ORM\TableRegistry;
class HomeController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->viewBuilder()->setLayout('Admin.default');
    }
    public function index(){
        $result = TableRegistry::getTableLocator()->get('Admin.Options')
            ->find('list',['keyField'=>'name','valueField'=>'value'])
            ->where(['name' => 'plugin_registerfield'])
            ->toArray();
        $this->set('result', $result);
    }
}