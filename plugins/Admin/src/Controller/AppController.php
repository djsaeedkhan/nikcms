<?php
namespace Admin\Controller;
use App\Controller\AppController as BaseController;
use Cake\Event\EventInterface;

class AppController extends BaseController
{
    public $post_type;
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Authentication.Authentication');
        $this->loadComponent('FormProtection', [
            'unlockedFields' => ['nav','tokn_id']
        ]);
        $this->post_type = $this->request->getQuery('post_type')?
            $this->request->getQuery('post_type'):'post';
        
        $this->set(['post_types'=>$this->post_type,]);
       // $this->_activity();//save user activity
    }

    

    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);
        //$this->Authentication->addUnauthenticatedActions();
    }

    public function isAuthorized($user){
        return parent::isAuthorized($user);
    }
}