<?php
namespace Breadcrumb\Controller;
use Breadcrumb\Controller\AppController;
use Cake\ORM\TableRegistry;
class HomeController extends AppController
{
    public function initialize(){
        parent::initialize();
        $this->viewBuilder()->setLayout('Admin.default');
    }
    public function index()
    {
        $result = $this->Func->OptionGet('brcrumb_plugin');
        $this->set('result', $result);
    }
}