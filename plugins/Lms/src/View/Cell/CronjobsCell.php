<?php
namespace Lms\View\Cell;

use Cake\ORM\TableRegistry;
use Cake\View\Cell;
use Cake\I18n\Time;
use \Sms\Sms;

/**
 * Cronjobs cell
 */
class CronjobsCell extends Cell
{
    protected $_validCellOptions = [];
    public $setting = [];
    public function initialize(){
        $result = TableRegistry::getTableLocator()->get('Admin.Options')
            ->find('list',['keyField'=>'name','valueField'=>'value'])
            ->where(['name' => 'plugin_lms'])
            ->toArray();
        if(isset($result['plugin_lms'])){
            $this->setting = unserialize($result['plugin_lms']);
        }
    }
    public function display(){}
    //----------------------------------------------------------------------------
    public function user_alert_30day()
    {
        try {
            if(isset($this->setting['smstext_30dayexpire']) and $this->setting['smstext_30dayexpire'] != ''):
                $this->sms = new Sms();
                $users = TableRegistry::getTableLocator()->get('Lms.Users')->find('all')
                    ->contain(['LmsCourseusers'=>['LmsCourses']])
                    ->where([
                        'Users.expired IS NOT NULL',
                        'Users.expired > ' => date('Y-m-d'),
                        'Users.enable'=>1,
                        ])
                    ->toarray();
                foreach($users as $user){
                    if(isset($user['lms_courseusers']) and is_array($user['lms_courseusers']) and count($user['lms_courseusers'])> 0){
                        foreach($user['lms_courseusers'] as $lmsCourses){
                            if( $lmsCourses['lms_course']['date_type'] == 2 ){ //تاریخ شروع مشخص شده برای دوره
                                $time = new Time( $lmsCourses['lms_course']['date_end']->format('Y-m-d') );
                            }
                            else{ //تاریخ ثبت دوره برای کاربر
                                //https://www.php.net/manual/en/dateinterval.format.php
                                $interval = date_diff(
                                    date_create($lmsCourses['lms_course']['date_start']->format('Y-m-d')),
                                    date_create($lmsCourses['lms_course']['date_end']->format('Y-m-d')) );
                                $origin = $interval->format('%R%a');
                                $day = (intval($origin));
                                $time = new Time($lmsCourses['created']);
                                if($day > 0){
                                    $time->setTimezone(new \DateTimeZone('Asia/Tehran'));
                                    $day -= 2;
                                    $time->addDays($day);
                                }
                            }
                            $time->addDays("-30");
                            if(Time::now()->format('Y-m-d') == $time->format('Y-m-d')){
                                //pr('ارسال پیامک اطلاع رسانی 30 روز مانده به انقضا دوره به شماره ');
                                if(is_numeric($user['username'])){
                                    $p = $this->sms->sendsingle([
                                        'mobile' => $user['username'],
                                        'text' => $this->sms->create_text($this->setting['smstext_30dayexpire'],[
                                                'username'=>$user['username'],
                                                'family'=> $user['family'],
                                                'course_title'=> $lmsCourses['lms_course']['title'],
                                            ]),
                                    ]);
                                    if($p != null){
                                        echo "ارسال پیامک اطلاع رسانی 30 روز مانده به انقضا دوره به شماره ".$user['username']."ارسال گردید<br>";
                                    }
                                }
                                else
                                    echo $user['username']. ' شماره موبایل پیدا نشد.';
                            }
                            //-//pr("<hr>");
                        }
                    }
                }
            endif;
        } catch (\Throwable $th) {
            echo "<br>user_alert_30day Error<br>";
        }
    }
    //----------------------------------------------------------------------------

    public function user_alert_60day()
    {
        try {
            if(isset($this->setting['smstext_60dayexpire']) and $this->setting['smstext_60dayexpire'] != ''):
                $this->sms = new Sms();
                $users = TableRegistry::getTableLocator()->get('Lms.Users')->find('all')
                    ->contain(['LmsCourseusers'=>['LmsCourses']])
                    ->where([
                        'Users.expired IS NOT NULL',
                        'Users.expired > ' => date('Y-m-d'),
                        'Users.enable'=>1,
                        ])
                    ->toarray();
                foreach($users as $user){
                    if(isset($user['lms_courseusers']) and is_array($user['lms_courseusers']) and count($user['lms_courseusers'])> 0){
                        foreach($user['lms_courseusers'] as $lmsCourses){
                            if( $lmsCourses['lms_course']['date_type'] == 2 ){ //تاریخ شروع مشخص شده برای دوره
                                $time = new Time( $lmsCourses['lms_course']['date_end']->format('Y-m-d') );
                            }
                            else{ //تاریخ ثبت دوره برای کاربر
                                //https://www.php.net/manual/en/dateinterval.format.php
                                $interval = date_diff(
                                    date_create($lmsCourses['lms_course']['date_start']->format('Y-m-d')),
                                    date_create($lmsCourses['lms_course']['date_end']->format('Y-m-d')) );
                                $origin = $interval->format('%R%a');
                                $day = (intval($origin));
                                $time = new Time($lmsCourses['created']);
                                if($day > 0){
                                    $time->setTimezone(new \DateTimeZone('Asia/Tehran'));
                                    $day -= 2;
                                    $time->addDays($day);
                                }
                            }
                            $time->addDays("-60");
                            if(Time::now()->format('Y-m-d') == $time->format('Y-m-d')){
                                //pr('ارسال پیامک اطلاع رسانی 60 روز مانده به انقضا دوره به شماره ');
                                if(is_numeric($user['username'])){
                                    $p = $this->sms->sendsingle([
                                        'mobile' => $user['username'],
                                        'text' => $this->sms->create_text($this->setting['smstext_60dayexpire'],[
                                                'username'=>$user['username'],
                                                'family'=> $user['family'],
                                                'course_title'=> $lmsCourses['lms_course']['title'],
                                            ]),
                                    ]);
                                    if($p != null){
                                        echo "ارسال پیامک اطلاع رسانی 60 روز مانده به انقضا دوره به شماره ".$user['username']."ارسال گردید<br>";
                                    }
                                }
                                else
                                    echo $user['username']. ' شماره موبایل پیدا نشد.';
                            }
                            //-//pr("<hr>");
                        }
                    }
                }
            endif;
        } catch (\Throwable $th) {
            echo "<br>user_alert_60day  Error<br>";
        }
    }
    //----------------------------------------------------------------------------

    public function nofactor_newuser() // در صورتی که کاربر جدید فاکتور ثبت نکرده باشد
    {
        try {
            if(isset($this->setting['smstext_nofactor_newuser']) and $this->setting['smstext_nofactor_newuser'] != ""):
                $this->sms = new Sms();
                $time = Time::now();
                $day = 10;
                if(isset($this->setting['smstext_nofactor_newuser_day']) and intval($this->setting['smstext_nofactor_newuser_day']) > 0)
                    $day = $this->setting['smstext_nofactor_newuser_day'];
                $time->addDays("-". $day);
    
                $factors = TableRegistry::getTableLocator()
                    ->get('Lms.Users')
                    ->find('all')
                    ->enablehydration(false)
                    ->where([
                        'Users.created LIKE ' => "%".$time->format('Y-m-d')."%",
                        'Users.enable'=> 1,
                        ])
                    ->contain(['LmsFactors'])
                    ->toarray();
    
                foreach($factors as $factor){
                    if(isset($factor['lms_factors']) and is_array($factor['lms_factors']) and count($factor['lms_factors']) == 0){
                        if(is_numeric($factor['username'])){
                            $p = $this->sms->sendsingle([
                                'mobile' => $factor['username'],
                                'text' => $this->sms->create_text($this->setting['smstext_nofactor_newuser'],[
                                    'username'=>$factor['username'],
                                    'family'=> $factor['family'],
                                ]),
                            ]);
                            if($p != null){
                                echo "ارسال پیامک عدم ثبت فاکتور در مدت مشخص پس از ثبت نام کاربر: ".$factor['username']."ارسال گردید<br>";
                            }
                        }
                        else
                        echo "شماره موبایل کاربر پیدا نشد / ".$factor['username']."<br>";
                    }
                }
            endif;
        } catch (\Throwable $th) {
           echo "<br>nofactor_newuser  Error<br>";
        }
        
    }//----------------------------------------------------------------------------

    public function delete_unpaid_factor()
    {
        /* try { */
            if(isset($this->setting['delete_unpaid_factor']) and $this->setting['delete_unpaid_factor'] == '1'):

                $time = Time::now();
                $day = 10;
                if(isset($this->setting['delete_unpaid_factor_day']) and $this->setting['delete_unpaid_factor_day'] > 0)
                    $day = $this->setting['delete_unpaid_factor_day'];
                $time->addDays("-". $day);
    
                $this->LmsFactors = TableRegistry::getTableLocator()->get('Lms.LmsFactors');

                $factors = $this->LmsFactors->find('all')
                    //->enablehydration(false)
                    ->where([
                        'LmsFactors.created < ' => $time->format('Y-m-d H:i:s'),
                        'LmsFactors.paid'=> 0,
                        ])
                    ->order(['LmsFactors.id'=>'desc'])
                    ->toarray();
    
                $result = "";
                foreach($factors as $factor){
                    if($this->LmsFactors->delete($this->LmsFactors->get($factor['id']))){
                        $result .= "فاکتور با شماره ". $factor['id'] ." حذف شد<br>";
                    }
                }
                if($result != "")
                    echo $result;
                else
                    echo "فاکتوری پرداخت نشده ای برای حذف پیدا نشد";
            endif;
        /* } catch (\Throwable $th) {
            echo "<br>delete_unpaid_factor Error<br>";
        } */
    }
    //----------------------------------------------------------------------------
    public function user_alert_10day()
    {
        try {
            
            //$this->setting['smstext_10dayexpire'] = "Saeed";
            if(isset($this->setting['smstext_10dayexpire']) and $this->setting['smstext_10dayexpire'] != ''):
                $this->sms = new Sms();

                $users = TableRegistry::getTableLocator()->get('Lms.Users')->find('all')
                    ->contain(['LmsCourseusers'=>['LmsCourses']])
                    ->where([
                        'Users.expired IS NOT NULL',
                        'Users.expired > ' => date('Y-m-d'),
                        'Users.enable'=>1,
                        ])
                    ->toarray();

                foreach($users as $user){
                    if(isset($user['lms_courseusers']) and is_array($user['lms_courseusers']) and count($user['lms_courseusers'])> 0){
                        foreach($user['lms_courseusers'] as $lmsCourses){

                            //-//pr("Userid: ".$lmsCourses['user_id'] .' / CourseID: '.$lmsCourses['lms_course']['id']);

                            /* 
                            pr($lmsCourses);
                            pr("UserID: ".$user['id']);
                            pr("Course ID: ".$lmsCourses['lms_course']['id']);
                            pr("Type: ".$lmsCourses['lms_course']['date_type']);
                            */

                            if( $lmsCourses['lms_course']['date_type'] == 2 ){ //تاریخ شروع مشخص شده برای دوره
                                /* pr("T2"); */
                                $time = new Time( $lmsCourses['lms_course']['date_end']->format('Y-m-d') );
                            }
                            else{ //تاریخ ثبت دوره برای کاربر
                                //-//pr("start: ".$lmsCourses['lms_course']['date_start']->format('Y-m-d'));
                                //-//pr("End: ".$lmsCourses['lms_course']['date_end']->format('Y-m-d'));
                                //-//pr("User: ".$lmsCourses['created']->format('Y-m-d'));

                                

                                /* pr("T1"); */
                                //https://www.php.net/manual/en/dateinterval.format.php
                                $interval = date_diff(
                                    date_create($lmsCourses['lms_course']['date_start']->format('Y-m-d')),
                                    date_create($lmsCourses['lms_course']['date_end']->format('Y-m-d')) );
                                $origin = $interval->format('%R%a');
                                $day = (intval($origin));

                                //-//pr( "Course Day: ".$day );
                                //-//pr("CourseUser Id: ".$lmsCourses['id']);
                                $time = new Time($lmsCourses['created']);
                                
                                if($day > 0){
                                    $time->setTimezone(new \DateTimeZone('Asia/Tehran'));
                                    $day -= 2;
                                    $time->addDays($day);
                                }
                            }

                            //-//pr("Expired Day: ". $time->format('Y-m-d'));
                            $time->addDays("-10");
                            //-//pr("Alert Day: ". $time->format('Y-m-d'));
                            //-//pr("Now: ".Time::now()->format('Y-m-d'));

                            /* pr($time->format('Y-m-d'));pr(Time::now()->format('Y-m-d'));pr("<hr>");  */

                            if(Time::now()->format('Y-m-d') == $time->format('Y-m-d')){
                                //pr('ارسال پیامک اطلاع رسانی 10 روز مانده به انقضا دوره به شماره ');
                                if(is_numeric($user['username'])){
                                    $p = $this->sms->sendsingle([
                                        'mobile' => $user['username'],
                                        'text' => $this->sms->create_text($this->setting['smstext_10dayexpire'],[
                                                'username'=>$user['username'],
                                                'family'=> $user['family'],
                                                'course_title'=> $lmsCourses['lms_course']['title'],
                                            ]),
                                    ]);
                                    if($p != null){
                                        echo "ارسال پیامک اطلاع رسانی 10 روز مانده به انقضا دوره به شماره ".$user['username']."ارسال گردید<br>";
                                    }
                                }
                                echo $user['username'].' شماره موبایل پیدا نشد.<br>';
                                
                            }
                        }
                    }
                }
            endif;
        } catch (\Throwable $th) {
           echo "<br>user_alert_10day  Error<br>";
        }
    }
    //----------------------------------------------------------------------------
    public function user_alert_0day()
    {
        try {
            
            if(isset($this->setting['smstext_expired']) and $this->setting['smstext_expired'] != ''):
                $this->sms = new Sms();
                $users = TableRegistry::getTableLocator()->get('Lms.Users')->find('all')
                    ->contain(['LmsCourseusers'=>['LmsCourses']])
                    ->where(['Users.expired IS NOT NULL'])
                    ->toarray();
                foreach($users as $user){
                    
                    if(isset($user['lms_courseusers']) and is_array($user['lms_courseusers']) and count($user['lms_courseusers'])> 0){
                        foreach($user['lms_courseusers'] as $lmsCourses){
                            if( $lmsCourses['lms_course']['date_type'] == 2 ){ //تاریخ شروع مشخص شده برای دوره
                                $time = new Time( $lmsCourses['lms_course']['date_end']->format('Y-m-d') );
                            }
                            else{ //تاریخ ثبت دوره برای کاربر
                                //https://www.php.net/manual/en/dateinterval.format.php
                                $interval = date_diff(
                                    date_create($lmsCourses['lms_course']['date_start']->format('Y-m-d')),
                                    date_create($lmsCourses['lms_course']['date_end']->format('Y-m-d')) );
                                $origin = $interval->format('%R%a');
                                $day = (intval($origin));
                                $time = new Time($lmsCourses['created']);
                                
                                if($day > 0){
                                    $time->setTimezone(new \DateTimeZone('Asia/Tehran'));
                                    $time->addDays($day);
                                }
                            }
                            $time->addDays("+1");
                            if(Time::now()->format('Y-m-d') == $time->format('Y-m-d')){
                                if(is_numeric($user['username'])){
                                    $p = $this->sms->sendsingle([
                                        'mobile' => $user['username'],
                                        'text' => $this->sms->create_text($this->setting['smstext_expired'],[
                                                'username'=>$user['username'],
                                                'family'=> $user['family'],
                                                'course_title'=> $lmsCourses['lms_course']['title'],
                                            ]),
                                    ]);
                                    if($p != null){
                                        echo "ارسال پیامک اطلاع رسانی انقضا دوره به شماره ".$user['username']."ارسال گردید<br>";
                                    }
                                }
                                else
                                    echo $user['username']. ' شماره موبایل پیدا نشد.';
                            }
                        }
                    }
                }
            endif;
        } catch (\Throwable $th) {
            echo "<br>user_alert_0day Error<br>";
        }
    }
    //----------------------------------------------------------------------------
}
