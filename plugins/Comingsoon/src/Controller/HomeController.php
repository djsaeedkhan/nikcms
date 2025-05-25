<?php
namespace Comingsoon\Controller;

use Comingsoon\Controller\AppController;
use Cake\ORM\TableRegistry;
class HomeController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->viewBuilder()->setLayout('Admin.default');
    }
    public function index()
    {
        $result = $this->Func->OptionGet('coming_plugin');
        $this->set('result', $result);
    }
}