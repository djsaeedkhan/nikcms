<?php
namespace Lms\Controller;
use Lms\Controller\AppController;
use Cake\ORM\TableRegistry;
class HomeController extends AppController
{
    public function initialize(){
        parent::initialize();
        $this->ViewBuilder()->setLayout('Admin.default');
    }
    public function index(){
        
    }
}