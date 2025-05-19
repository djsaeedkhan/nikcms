<?php
namespace Admin\Controller;
use App\Controller\AppController as BaseController;
use Cake\Event\Event;
use Cake\I18n\I18n;

class AppController extends BaseController
{
    public $post_type = 'post';
    public function initialize(){
        parent::initialize();
        $this->loadComponent('Flash');
        if(isset($this->request->getQuery()['post_type']))
            $this->post_type=$this->request->getQuery()['post_type'];
        
        $this->set(['post_types'=>$this->post_type,]);
        $this->_activity();//save user activity
    }

    public function beforeFilter(Event $event){
        parent::beforeFilter($event);
    }

    public function isAuthorized($user){
        return parent::isAuthorized($user);
    }
}