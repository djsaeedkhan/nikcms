<?php
namespace Comingsoon\Controller;

use Comingsoon\Controller\AppController;
use Cake\ORM\TableRegistry;
class HomeController extends AppController
{
    public function initialize(){
        parent::initialize();
        $this->ViewBuilder()->setLayout('Admin.default');
    }
    public function index()
    {
        $result = $this->Func->OptionGet('coming_plugin');
        $this->set('result', $result);
    }
}