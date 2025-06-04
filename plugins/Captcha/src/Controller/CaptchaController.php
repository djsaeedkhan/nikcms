<?php
namespace Captcha\Controller;
use Captcha\Controller\AppController;

class CaptchaController extends AppController
{
    public function initialize(): void
    {
      parent::initialize();
      //$this->loadComponent('Captcha.Captcha');
    }
    public function beforeFilter(\Cake\Event\Event $event)
    {
        if(isset($this->Auth) && is_object($this->Auth)) $this->Auth->allow(['create']);
    }
    function create()	{
        $this->autoRender = false;
        $this->loadComponent('Captcha.Captcha'); //or load on the fly!
        $this->viewBuilder()->setLayout('ajax');
        $this->Captcha->create();
    }
}
