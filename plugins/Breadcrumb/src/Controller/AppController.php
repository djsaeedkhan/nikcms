<?php
namespace Breadcrumb\Controller;
use App\Controller\AppController as BaseController;

class AppController extends BaseController
{
    public function initialize(){
        parent::initialize();
        $this->loadComponent('Flash');
   }

}
