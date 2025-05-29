<?php
namespace Admin\View\Cell;

use Cake\ORM\TableRegistry;
use Cake\View\Cell;
use Cake\I18n\Time;
use \Sms\Sms;
/**
 * Cronjobs cell
 */
class CronjobsCell extends Cell
{
    public function display(){}
    public function user_alert_10day(){

        $this->sms = new Sms();
        $text = $this->sms->setting;
        if($text['smstext_10dayexpire'] != ''){
            $users =  TableRegistry::getTableLocator()->get('Users')
                ->find('all')
                ->where(['expired IS NOT NULL'])
                ->toarray();

            foreach($users  as $user){
                $time = new Time( $user['expired']);
                $time->setTimezone(new \DateTimeZone('Asia/Tehran'));
                $time = $time->addDays('-10');

                /* pr($time->format('Y-m-d') );
                pr(Time::now()->format('Y-m-d'));
                pr("<hr>"); */
                
                if(Time::now()->format('Y-m-d') == $time->format('Y-m-d')){
                    $p = $this->sms->sendsingle([
                        'mobile' =>  $user['username'],
                        'text' => $this->sms->create_text($text['smstext_10dayexpire'],[
                                'username'=>$user['username'],
                                'family'=> $user['family']
                            ]),
                    ]);
                    if($p != null){
                        echo "ارسال پیامک اطلاع رسانی 10 روز مانده به انقضا کاربر به شماره ".
                        $user['username']."ارسال گردید<br>";
                    }
                }
            }
        }
    }

    public function user_alert_0day(){
        $this->sms = new Sms();
        $text = $this->sms->setting;
        if($text['smstext_expire'] != ''){
            $users =  TableRegistry::getTableLocator()->get('Users')
                ->find('all')
                ->where(['expired IS NOT NULL'])
                ->toarray();
            foreach($users  as $user){
                $time = new Time( $user['expired']);
                $time->setTimezone(new \DateTimeZone('Asia/Tehran'));
                $time = $time->addDays('+1');

                /* pr($time->format('Y-m-d') );
                pr(Time::now()->format('Y-m-d'));
                pr("<hr>"); */
                
                if(Time::now()->format('Y-m-d') == $time->format('Y-m-d')){
                    $p = $this->sms->sendsingle([
                        'mobile' =>  $user['username'],
                        'text' => $this->sms->create_text($text['smstext_expire'],[
                                'username'=>$user['username'],
                                'family'=> $user['family']
                            ]),
                    ]);
                    if($p != null){
                        echo "ارسال پیامک اطلاع رسانی انقضا پنل کاربر به شماره ".$user['username']."ارسال گردید<br>";
                    }
                }
            }
        }
    }
}
