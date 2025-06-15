<?php
namespace Captcha\Controller;
use Captcha\Controller\AppController;
use Cake\Event\EventInterface;

class CaptchaController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Authentication.Authentication');
    }
    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);
        //if(isset($this->Auth) && is_object($this->Auth)) $this->Auth->allow(['create']);
        $this->Authentication->allowUnauthenticated(['create']);
    }
    function create()	{
        $this->autoRender = false;
        $this->loadComponent('Captcha.Captcha'); //or load on the fly!
        $this->viewBuilder()->setLayout('ajax');
        $this->Captcha->create();
    }
}
