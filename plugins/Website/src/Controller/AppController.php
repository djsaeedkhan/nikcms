<?php
namespace Website\Controller;

use App\Controller\AppController as BaseController;
use Cake\Event\Event;

class AppController extends BaseController
{
    public function initialize(){
        parent::initialize();
    }

    public function beforeFilter(Event $event){
        $this->Auth->allow();
    }
}
