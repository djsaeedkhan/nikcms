<?php
namespace Widget\Controller;
use App\Controller\AppController as BaseController;
use Cake\Event\Event;

class AppController extends BaseController
{
    public function initialize(){
        parent::initialize();
        $this->ViewBuilder()->setLayout('Admin.default');
    }

    public function beforeFilter(Event $event){
        parent::beforeFilter($event);
    }
}