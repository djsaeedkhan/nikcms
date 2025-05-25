<?php
namespace Formbuilder\Controller;
use App\Controller\AppController as BaseController;
use Cake\Routing\Router;

class AppController extends BaseController{
    public function initialize(): void
    {
        parent::initialize();
        if($this->request->getQuery('read')){
            $this->Func->OptionSave('alert_formbuilder',null,'create');
            $this->redirect(str_replace('?read=true','',Router::url(false,true)));
        }
    }
}
