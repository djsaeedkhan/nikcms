<?php
namespace Sms\Controller;
use Sms\Controller\AppController;
use Cake\ORM\TableRegistry;
use \Sms\Sms;
use Cake\I18n\Time;
use Cake\Routing\Router;

class ViewController extends AppController
{
    public $setting;
    public $sms,$max_time, $max_count;
    public $token;
    //-----------------------------------------------------------------------------
    public function initialize(){
        parent::initialize();
        if($this->Func->OptionGet('template_layout') == 1)
            $this->viewBuilder()->setLayout('Template.login');
        else
            $this->viewBuilder()->setLayout('login');
        $this->Auth->allow();
        $result = TableRegistry::getTableLocator()->get('Admin.Options')->find('list',['keyField'=>'name','valueField'=>'value'])
            ->where(['name' => 'plugin_sms'])->toArray();
        $this->setting = unserialize($result['plugin_sms']);
        $this->sms = new Sms();
        $this->max_time = 1; //min
        $this->max_count = 6;
        $this->token = rand(100000,999999);
        $this->SmsValidations= TableRegistry::getTableLocator()->get('Sms.SmsValidations');
    }
    //-----------------------------------------------------------------------------
    public function autoactivate(){
        $this->set('user',$data = $this->request->getSession()->read('SmsActivations') );
        if($this->Func->OptionGet('register_type') == 'mobile'){

            //check session exists
            if(!isset($data['data']['username'])){
                if($this->request->is('ajax')){
                    return $this->response->withType('application/json')->withStringBody(json_encode([
                        'code'=>'AC1',
                        'type'=>'error',
                        'alert'=>__d('Sms','متاسفانه مشخصات فعال سازی پیدا نشد'),
                        'referer'=> Router::url($this->referer()),
                    ]));
                }
                else{
                    $this->Flash->error(__d('Sms','متاسفانه مشخصات فعال سازی پیدا نشد'));
                    return $this->redirect($this->referer()); 
                }
            }

            //check last send sms time
            $last = $this->SmsValidations->find('all')
                ->where(['mobile'=>$data['data']['username']])
                ->order(['id'=>'desc'])
                ->first();
            if($last){
                $time = new Time($last['created']);
                $time->setTimezone(new \DateTimeZone('Asia/Tehran'));
                $time->addMinutes($this->max_time);
                if(Time::now() < $time){
                    if($this->request->is('ajax')){
                        return $this->response->withType('application/json')->withStringBody(json_encode([
                            'code'=>'AC2',
                            'type'=>'error',
                            'alert'=>__d('Sms','برای ارسال مجدد پیامک تایید '.$this->max_time.' دقیقه صبر نمایید. '),
                            'referer'=> Router::url($this->referer()),
                        ]));
                    }
                    else{
                        $this->Flash->error(__d('Sms','برای ارسال مجدد پیامک تایید '.$this->max_time.' دقیقه صبر نمایید. '));
                        return $this->redirect($this->referer());
                    }
                }
            }

            //check max send validatin sms
            $count = $this->SmsValidations->find('all')
                ->where(['mobile' => $data['data']['username']])
                ->count();
            if($count > 10){
                if($this->request->is('ajax')){
                    return $this->response->withType('application/json')->withStringBody(json_encode([
                        'code'=>'AC3',
                        'type'=>'error',
                        'alert'=>__d('Sms','ارسال پیامک تایید از تعداد دفعات مجاز بیشتر شده است،
                        لطفا با پشتیبانی سایت ارتباط بگیرید'),
                        'referer'=> Router::url($this->referer()),
                    ]));
                }
                else{
                    $this->Flash->error(__d('Sms','ارسال پیامک تایید از تعداد دفعات مجاز بیشتر شده است، لطفا با پشتیبانی سایت ارتباط بگیرید'));
                    return $this->redirect($this->referer());
                }
            }

            if($this->setting['sendbysingle_sender'] == 'number'){
                // ارسال خط اختصاصی
                $this->sms->sendsingle([
                    'mobile' => $data['data']['username'],
                    'text' => $this->sms->create_text($this->setting['smstext_activate'],[
                        'username'=>$data['data']['username'],
                        'token'=>$this->token
                    ]),
                ]);
            }
            elseif($this->setting['sendbysingle_sender'] == 'pattern'){
                /* $this->sms->sendbypattern([
                    'mobile' => $data['data']['username'],
                    'text' => $this->token,
                ]); */
                $this->sms->sendbysingle([
                    'mobile' => $data['data']['username'],
                    //'text' => $this->sms->create_message('activate',$this->token),
                    'text' => $this->token,
                ]);
            }

            $this->request->getSession()->write('SmsActivations.activate', [
                'mobile' => $data['data']['username'],
                'code'=> $this->token,
                'date' => strtotime(date('ymdhis', strtotime('+3 minutes')))
            ]);
            
            $log = $this->SmsValidations->newEntity();
            $log = $this->SmsValidations->patchEntity($log,[
                'mobile'=>$data['data']['username'] ,
                'code' =>$this->token,
                'user_id' => isset($data['data']['user_id'])?$data['data']['user_id']:$data['user_id']
            ]);

            if($log = $this->SmsValidations->save($log)){
                if($this->request->is('ajax')){
                    return $this->response->withType('application/json')->withStringBody(json_encode([
                        'code'=>'AC4',
                        'type'=>'success',
                        'alert'=>__d('Sms','خوش آمدید به').' '.$this->Func->OptionGet('name').'<br>'.__d('Sms','ارسال پیامک کدتایید با موفقیت انجام شد.'),
                        'referer'=> Router::url('/sms/activation/activate'),
                    ]));
                }
                else{
                    $this->Flash->success('به '.$this->Func->OptionGet('name') .' خوش آمدید');
                    $this->Flash->success(__d('Sms','ارسال پیامک کدتایید با موفقیت انجام شد.'));
                    return $this->redirect('/sms/activation/activate');
                }
            }
            else{
                if($this->request->is('ajax')){
                    return $this->response->withType('application/json')->withStringBody(json_encode([
                        'code'=>'AC5',
                        'type'=>'success',
                        'alert'=>__d('Sms','متاسفانه ارسال پیامک تایید انجام نشد'),
                        'referer'=> Router::url($this->referer()),
                    ]));
                }
                else{
                    $this->Flash->error(__d('Sms','متاسفانه ارسال پیامک تایید انجام نشد'));
                    return $this->redirect($this->referer());
                }
            }
        }
        else{
            if($this->request->is('ajax')){
                return $this->response->withType('application/json')->withStringBody(json_encode([
                    'code'=>'AC6',
                    'type'=>'error',
                    'alert'=>__d('Sms','دسترسی به این بخش امکان پذیر نمی باشد'),
                    'referer'=> Router::url('/'),
                ]));
            }
            else{
                return $this->redirect('/');
            }
        }
    }
    //-----------------------------------------------------------------------------
    public function index(){
        $setting = $this->sms->setting;
        $this->set('user',$data = $this->request->getSession()->read('SmsActivations') );

        if( !isset($data['data']['SmsValidations']['mobile'])){
            return $this->redirect(['plugin'=>false , 'controller'=>'Users','action'=>'register']);
        }

        if(isset($data['activate']['date']) and ($data['activate']['date'] - strtotime(date('ymdhis'))) > 0 ){
            $this->Flash->error(
                __d('Sms',"لطفا تا 3 دقیقه  صبرکنید و سپس دوباره ارسال کدتایید رادرخواست نمایید ")
            );
            return;
        }
        
        if ($this->request->is(['post', 'put']) and isset($this->request->getdata()['mobile']) ) {
            $mobile = $this->request->getdata()['mobile'];

            if(! preg_match("/^09[0-9]{9}$/", $mobile)) {
                $this->Flash->error(
                    __d('Sms','شماره موبایل وارد شده اشتباه است.').
                    __d('Sms','لطفا به صورت 09123456789 شماره موبایل را وارد کنید')
                );
                return;
            }
           
            $test = TableRegistry::getTableLocator()->get('UserMetas')
                ->find('all')
                ->where([
                    'meta_key'=>'mobile',
                    'meta_value LIKE '=> '%'.$mobile.'%']);
            if ( !$test->count() ) {
                $this->request->getSession()->write('SmsActivations.activate', [
                    'mobile' => $mobile,
                    'code'=> $this->token,
                    'user_id'=> $data['user_id'],
                    'date' => strtotime(date('ymdhis', strtotime('+3 minutes')))
                ]);
                $this->request->getSession()->write('SmsActivations.data.SmsValidations.mobile', $mobile);
                TableRegistry::getTableLocator()->get('Users')->query()->update()
                    ->set(['token' => $this->token  ])
                    ->where(['id' =>$data['user_id'] ])
                    ->execute();

                if($this->setting['sendbysingle_sender'] == 'number'){
                    // ارسال خط اختصاصی
                    $this->sms->sendsingle([
                        'mobile' =>  $mobile,
                        'text' => $this->sms->create_text($setting['smstext_activate'],[
                                    'username'=>$mobile,
                                    'token'=>$this->token
                                ]),
                    ]);
                }
                elseif($this->setting['sendbysingle_sender'] == 'pattern'){
                    // ارسال خط خدماتی
                    $this->sms->sendbysingle([
                        'mobile' => $mobile,
                        //'text' => $this->sms->create_message('activate',$this->token),
                        'text' => $this->token,
                    ]);
                }
                
                $this->Flash->success(
                    __d('Sms','خوش آمدید به') .' '.$this->Func->OptionGet('name')
                );
                $this->Flash->success(__d('Sms','ارسال پیامک کدتایید با موفقیت انجام شد.'));
                return $this->redirect('/sms/activation/activate');
            }
            else{
                $this->Flash->error(__d('Sms','شماره تلفن وارد شده قبلا در سامانه ثبت شده است.'));
                return $this->redirect($this->referer());
            }
        }
    }
    //-----------------------------------------------------------------------------
    public function active(){
        $setting = $this->setting;
        $setting = $this->sms->setting;

        if($this->Func->OptionGet('template_layout') == 1)
            $this->viewBuilder()->setLayout('Template.login');
        else
            $this->viewBuilder()->setLayout('Admin.login');

        $data = $this->request->getSession()->read('SmsActivations');
        if(! isset($data['activate']) or $data['activate'] == ''){

            if($this->request->is('ajax')){
                return $this->response->withType('application/json')->withStringBody(json_encode([
                    'code'=>'AT1',
                    'type'=>'error',
                    'alert'=>__d('Sms','دسترسی به این بخش امکان پذیر نمی باشد'),
                    'referer'=> Router::url(['plugin'=>false , 'controller'=>'Users','action'=>'register']),
                ]));
            }
            else{
                return $this->redirect(['plugin'=>false , 'controller'=>'Users','action'=>'register']);
            }
        }

        if ($this->request->is(['post', 'put']) and isset($this->request->getData()['mobile'])) {
            if(intval($this->request->getData()['mobile']) == $data['activate']['code'] ){

                $temp = $this->SmsValidations->newEntity();
                $temp = $this->SmsValidations->patchEntity($temp,[
                    'status' => 1 ,
                    'mobile' => $data['activate']['mobile'],
                    'code'=> $data['activate']['code'],
                    'user_id'=> isset($data['user_id'])?$data['user_id']:false
                ]);
                $mobile = $data['activate']['mobile'];

                if($this->SmsValidations->save($temp)){
                    $this->request->getSession()->delete('SmsActivations');

                    if($this->Func->OptionGet('register_type') == 'mobile'){
                        TableRegistry::getTableLocator()->get('Users')->query()->update()
                            ->set(['enable'=>1])
                            ->where(['username'=>$mobile ])
                            ->execute();
                    }
                    else{
                        $this->Func->PostMetaSave( $data['activate']['user_id'],[
                            'source' =>'users',
                            'type' => 'meta',
                            'name' => 'mobile',
                            'value' => $mobile,
                            'action' => 'create']);
                    }

                    $this->SmsValidations->deleteAll(['mobile' => $mobile]);
                    /* $text = $this->sms->create_message('register_success');
                    if($text != ''){
                        $this->sms->sendsingle([
                            'mobile' => $mobile,
                            'text' => $this->sms->create_message('register_success'),
                        ]);
                    } */

                    //$this->sms = new Sms();
                    
                    if(isset($setting['smstext_regsucc']) and $setting['smstext_regsucc'] != ''){
                        $this->sms->sendsingle([
                            'mobile' =>  $mobile,
                            'text' => $this->sms->create_text($setting['smstext_regsucc'],[
                                        'username'=>$mobile,
                                    ]),
                        ]);
                    }

                    $user = TableRegistry::getTableLocator()->get('Users')->find('all')
                        ->contain(['Roles'])
                        ->where(['username'=> $mobile ])
                        ->first();
                    if($user){
                        $this->Auth->setUser($user);
                        $user['role_list'] = unserialize($user['role']['data']);
                        $ulog = new \Userslogs\UserLogg();
                        $ulog->login_savelog(['user_id' => $user['id']], 1); //1:succ 2:faild
                    }
                    
                    if(isset($this->setting['redirect_alert']) and $this->setting['redirect_alert']!=''){
                        if($this->request->is('ajax')){
                            return $this->response->withType('application/json')->withStringBody(json_encode([
                                'code'=>'AT2',
                                'type'=>'success',
                                'alert'=>  $this->setting['redirect_alert'],
                                'referer'=> ((isset($this->setting['redirect']) and $this->setting['redirect']!='')?
                                    $this->setting['redirect']:
                                    Router::url(['plugin'=>false , 'controller'=>'Users','action'=>'login'])),
                            ]));
                        }
                        else{
                           $this->Flash->success($this->setting['redirect_alert']); 
                        }
                    }
                    else{
                        if($this->request->is('ajax')){
                            return $this->response->withType('application/json')->withStringBody(json_encode([
                                'code'=>'AT3',
                                'type'=>'success',
                                'alert'=>__d('Sms','تایید شماره موبایل شما با موفقیت انجام شد.'),
                                'referer'=> ((isset($this->setting['redirect']) and $this->setting['redirect']!='')?
                                    $this->setting['redirect']:
                                    Router::url(['plugin'=>false , 'controller'=>'Users','action'=>'login'])),
                            ]));
                        }
                        else{
                            //$this->Flash->success(__d('تایید شماره موبایل شما با موفقیت انجام شد.'));
                            $this->Flash->success($this->setting['redirect_alert']);
                            
                        }
                    }
                        
                    if(isset($this->setting['redirect']) and $this->setting['redirect']!='')
                        return $this->redirect($this->setting['redirect']);
                    else
                        return $this->redirect(['plugin'=>false , 'controller'=>'Users','action'=>'login']);
                }
                else{
                    if($this->request->is('ajax')){
                        return $this->response->withType('application/json')->withStringBody(json_encode([
                            'code'=>'AT4',
                            'type'=>'error',
                            'alert'=>__d('Sms','متاسفانه تایید شماره موبایل انجام نشد'),
                            'referer'=> Router::url('/'),
                        ]));
                    }
                    else{
                       $this->Flash->error(__d('Sms','متاسفانه تایید شماره موبایل انجام نشد')); 
                    }
                }
            }
            else{
                if($this->request->is('ajax')){
                    return $this->response->withType('application/json')->withStringBody(json_encode([
                        'code'=>'AT5',
                        'type'=>'error',
                        'alert'=>__d('Sms','رمز وارد شده اشتباه می باشد.'),
                        'referer'=> Router::url('/'),
                    ]));
                }
                else{
                    $this->Flash->error(__d('Sms','رمز وارد شده اشتباه می باشد.'));
                }
            }
        }
        if($this->request->is('ajax')){
            return $this->response->withType('application/json')->withStringBody(json_encode([
                'code'=>'AT6',
                'type'=>'error',
                'alert'=>__d('Sms','پاسخی دریافت نشد'),
                'referer'=> Router::url('/'),
            ]));
        }
    }
    //-----------------------------------------------------------------------------
}