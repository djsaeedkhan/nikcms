<?php
namespace Widget\Controller;
use App\Controller\AppController as BaseController;
use Cake\Event\EventInterface;

class AppController extends BaseController
{
    public function initialize(){
        parent::initialize();
        $this->viewBuilder()->setLayout('Admin.default');
    }

    public function beforeFilter(Event $event){
        parent::beforeFilter($event);
    }
}