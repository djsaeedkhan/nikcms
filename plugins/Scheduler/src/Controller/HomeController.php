<?php
namespace Scheduler\Controller;
use Scheduler\Controller\AppController;
use Cake\ORM\TableRegistry;
class HomeController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->viewBuilder()->setLayout('Admin.default');
    }
    public function index(){
        $result = $this->Func->OptionGet('plugin_scheduler');
        $this->set('result', $result);
    }
}