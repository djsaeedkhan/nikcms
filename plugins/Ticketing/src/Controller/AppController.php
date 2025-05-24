<?php
namespace Ticketing\Controller;
use App\Controller\AppController as BaseController;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;

class AppController extends BaseController
{
    public $setting = [];
    public function initialize(){
        parent::initialize();
        $this->viewBuilder()->setLayout('Admin.default');
        $this->loadComponent('Admin.Fileupload');
        $this->set(['code' => 1]);

        $setting = TableRegistry::getTableLocator()->get('Admin.Options')
            ->find('list',['keyField'=>'name','valueField'=>'value'])
            ->where(['name' => 'plugin_ticket'])
            ->toarray();
        if(isset($setting['plugin_ticket'])){
            $this->setting = unserialize($setting['plugin_ticket']);
            $this->set([
                'setting_ticket'=> $this->setting,
            ]);
        }
            
        if($this->request->getQuery('read')){
            $this->Func->OptionSave('alert_ticketing',null,'create');
            $this->redirect(str_replace('?read=true','',Router::url(false,true)));
        }
        

    }
}
