<?php
namespace Scheduler\Controller;
use Scheduler\Controller\AppController;
use Cake\ORM\TableRegistry;
class HomeController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $this->ViewBuilder()->setLayout('Admin.default');
    }
    public function index(){
        $result = $this->Func->OptionGet('plugin_scheduler');
        $this->set('result', $result);
    }
}