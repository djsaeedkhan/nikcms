<?php
namespace Predata\Controller;

use Predata\Controller\AppController;
use Cake\ORM\TableRegistry;
class HomeController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $this->ViewBuilder()->setLayout('Admin.default');
    }
    
    public function index($id = null){
        
    }
}