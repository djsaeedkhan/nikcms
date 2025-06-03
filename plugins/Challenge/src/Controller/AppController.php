<?php
namespace Challenge\Controller;
use App\Controller\AppController as BaseController;
use Cake\ORM\TableRegistry;
use Challenge\Predata;
use Cake\Event\EventInterface;

class AppController extends BaseController
{
    public $setting_challenge = [];
    public function initialize(): void
    {
        parent::initialize();
        $this->viewBuilder()->setLayout('Admin.default');
        $this->loadComponent('Authentication.Authentication');

        $setting = TableRegistry::getTableLocator()->get('Admin.Options')
            ->find('list',['keyField'=>'name','valueField'=>'value'])
            ->where(['name' => 'plugin_challenge'])
            ->toarray();
        if(isset($setting['plugin_challenge'])){
            $this->setting_challenge = unserialize($setting['plugin_challenge']);
            $this->set([
                'setting_challenge'=> $this->setting_challenge,
            ]);
        }

        $user_ids = [];
        $identity = $this->request->getAttribute('identity');
        if ($identity) {
            $user_ids = $identity->get('id');
        }

        $predata = new Predata();
        $this->set([
            'eductions' => $predata->gettype('eductions'),
            'group' => $predata->gettype('group'),
            'gender' => $predata->gettype('gender'),
            'center' => $predata->gettype('center'),
            'user_ids'=> $user_ids
        ]);
    }

    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);
        //$this->Authentication->addUnauthenticatedActions();
    }

}
