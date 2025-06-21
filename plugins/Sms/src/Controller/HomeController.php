<?php
namespace Sms\Controller;
use \Sms\Sms;

use Sms\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\I18n\Time;

class HomeController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->viewBuilder()->setLayout('Admin.default');
    }
    public function index(){

        $date = jdate('d','','','','en');
        $time = new Time('now');
        $time = $time->addDays("-{$date}");

        $this->set([
            'total_sms' => TableRegistry::getTableLocator()->get('Sms.SmsLogs')->find('all')
                ->count(),

            'today_sms' => TableRegistry::getTableLocator()->get('Sms.SmsLogs')->find('all')
                ->where([
                    'DATE(created)' => date('Y-m-d')
                ])
                ->count(),

            'month_sms' => TableRegistry::getTableLocator()->get('Sms.SmsLogs')->find('all')
                ->where([
                    'DATE(created) >= ' => $time->format('Y-m-d'),
                ])
                ->count(),

            'today_smslist' => TableRegistry::getTableLocator()->get('Sms.SmsLogs')->find('all')
                ->limit(25)
                ->order(['id'=>'desc'])
                ->toArray()
        ]);
    }

    public function setting(){
        $result = TableRegistry::getTableLocator()->get('Admin.Options')
            ->find('list',['keyField'=>'name','valueField'=>'value'])
            ->where(['name' => 'plugin_sms'])
            ->toArray();
        $this->set('result', $result);
    }

    public function logs(){
        $result = TableRegistry::getTableLocator()->get('Sms.SmsLogs')
            ->find('all')
            ->order(['id'=>'desc'])
            ->toArray();
        $this->set('results', $result);
    }
    public function sendsms(){
        $this->viewBuilder()->setLayout(false);
        $this->render(false);
        if($this->request->is(['post'])){
            $sms = new Sms();
            if( isset($this->request->getdata()['plugin_sms']) )
                echo json_encode($sms->sendsingle($this->request->getdata()['plugin_sms']));
            else
                echo json_encode(['error']);
        }
        else
            $this->redirect($this->referer());
    }
}