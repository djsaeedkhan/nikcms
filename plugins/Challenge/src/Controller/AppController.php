<?php
namespace Challenge\Controller;
use App\Controller\AppController as BaseController;
use Cake\ORM\TableRegistry;
use Challenge\Predata;

class AppController extends BaseController
{
    public $setting_challenge = [];
    public function initialize(): void
    {
        parent::initialize();
        $this->viewBuilder()->setLayout('Admin.default');

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

        $predata = new Predata();
        $this->set([
            'eductions' => $predata->gettype('eductions'),
            'group' => $predata->gettype('group'),
            'gender' => $predata->gettype('gender'),
            'center' => $predata->gettype('center'),
            //'user_ids'=> $this->request->getAttribute('identity')->get('id')
        ]);
        
    }
}
