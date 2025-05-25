<?php
namespace Widget\Controller;
use Widget\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Auth\BaseAuthenticate;

class HomeController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
    }
    
    public function index(){
    }
}