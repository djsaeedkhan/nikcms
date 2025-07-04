<?php
declare(strict_types=1);

namespace App\Controller;
use Cake\Auth\DefaultPasswordHasher;
use App\Controller\AppController;
use Cake\Mailer\Email;
use Cake\ORM\TableRegistry;
use Cake\I18n\FrozenTime;
use Cake\Routing\Router;
use \Sms\Sms;
use \RegisterField\RField;
use Cake\Utility\Security;
use Cake\Http\Cookie\Cookie;
use Cake\I18n\DateTime;
use Cake\Event\EventInterface;
use Cake\Log\Log;

class UsersController extends AppController{

    public function initialize(): void
    {
        parent::initialize();
    }
    //----------------------------------------------------------
    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);
        //$this->Authentication->addUnauthenticatedActions([]);
        $this->Authentication->allowUnauthenticated(['login', 'register','Website.index','logout','remember','rememberToken','thumbnail']);

        // Check for remember me cookie
        $token = $this->request->getCookie('remember_me');
        if ($token && !$this->Authentication->getIdentity()) {
            $usersTable = $this->fetchTable('Users');
            $user = $usersTable->find()
                ->where([
                    'remember_token' => $token,
                    'remember_token_expiry >' => new FrozenTime(),
                ])
                ->first();

            if ($user) {

                $role_list = [];
                try {
                    $role_array = $user->get('role');
                    if(isset($role_array['data']))
                        $role_list = unserialize($role_array['data']);
                } catch (\Throwable $th) {}
                $this->Authentication->getResult()->getData()->offsetSet('role_list', $role_list);
                $this->Authentication->getResult()->getData()->offsetSet('session_hash', $this->_hashGenerator() );
                
                // Log the user in
                $this->Authentication->setIdentity($user);


            } else {
                // Clear invalid/expired cookie
                $this->response = $this->response->withExpiredCookie(new Cookie('remember_me'));
            }
        }
    }
    //----------------------------------------------------------
    public function isAuthorized($user){
        return parent::isAuthorized($user);
    }
    //----------------------------------------------------------
    public function profile(){
        $this->viewBuilder()->setLayout('Admin.default');
        $id = $this->request->getAttribute('identity')->get('id');
        $user = $this->Users->get($id, ['contain' => ['UserMetas']]);
        $this->set(['user'=>$user]);
        if ($this->request->is(['patch', 'put'])) {
            if($this->request->getAttribute('identity')->get('role_id') != 1) {
                $data = $this->request->getData();
                unset($data['username']);
                unset($data['token']);
                unset($data['enable']);
                unset($data['role_id']);
                $this->request = $this->request->withParsedBody($data);
            }

            if($this->request->getData('old_password') != ''){
                if( (new DefaultPasswordHasher)->check($this->request->getData('old_password'),$user->password) ){
                    $this->request = $this->request->withData('password',$this->request->getData('new_password'));
                }
                else{
                    $data = $this->request->getData();
                    unset($data['password']);
                    $this->request = $this->request->withParsedBody($data);
                    $this->Flash->error(__('رمز قبلی وارد شده اشتباه می باشد.'));
                }
            }

            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($result = $this->Users->save($user)) {
                if($this->request->getData('UserMetas') and count($this->request->getData('UserMetas'))):
                    foreach($this->request->getData('UserMetas') as $key => $val){
                        $this->Func->PostMetaSave($result->id,[
                            'source' =>'users',
                            'type' => 'meta',
                            'name' => $key,
                            'value' => $val,
                            'action' => 'create']);
                    }
                endif;
                
                $user = $this->Users->get($this->request->getAttribute('identity')->get('id'));
                //$this->Authentication->getResult()->getData()->offsetSet('role_list', $role_list);
                $this->Authentication->setIdentity($user);

                $this->Flash->success(__('بروز رسانی مشخصات با موفقیت انجام شد'));
            }
            else
                $this->Flash->error(__('متاسفانه ثبت اطلاعات با موفقیت انجام نشد.'));

            return $this->redirect($this->referer());
        }
        $meta_list = array();
        if(isset($user->user_metas))
            $meta_list = $this->Func->MetaList($user,'users');
        $this->set([
            'user' => $user,
            'meta_list' => $meta_list,
        ]);
    }
    //----------------------------------------------------------
    public function login(){
        
        try{
            if($this->Func->OptionGet('template_layout') == 1)
                $this->viewBuilder()->setLayout('Template.login');
            else
                $this->viewBuilder()->setLayout('login');
        }
        catch (\Exception $e){
            $this->viewBuilder()->setLayout('login');
        }

        //$this->_autoLogin();

        if($this->request->getQuery('reset')){
            print_r ((new DefaultPasswordHasher)->hash("123456"));
        }

        if(!$this->request->is(['ajax','post'])){
            $result = $this->Authentication->getResult();
            if ($result->isValid()) {
                return $this->redirect('/admin/');
            }
        }

        if ($this->request->is(['ajax','post'])) {
            $session = $this->getRequest()->getSession();
            if ($this->request->is('ajax')) {
                $this->autoRender = false;
            }
            /* if($session->read('show_recaptcha') == 1 and  !in_array($_SERVER['REMOTE_ADDR'], ['127.0.0.1','::1'])){
                $SpamDetector = new SpamDetector();
                $SpamDetector->ip($_SERVER['REMOTE_ADDR']);
                if(isset($this->request->getData()['username']) and $this->request->getData()['username'] != '')
                    $SpamDetector->username($this->request->getData()['username']);

                $result = $SpamDetector->verify();
                if(! $result){
                    $this->Flash->error(__('You called as Spammer'));
                    return;
                }
            } */

            if ( $session->read('show_recaptcha') == 1  and 
                !isset($this->request->getData()['securitycode']) and
                empty($this->request->getData()['securitycode'])
            ){
                if ($this->request->is('ajax')) {
                    return $this->response->withType('application/json')->withStringBody(json_encode([
                        'code'=>'F1',
                        'type'=>'error',
                        'alert'=>__('کد امنیتی به درستی وارد نشده است'),
                        'referer' => null,
                    ]));
                }
                else{
                    $this->Flash->error(__('کد امنیتی به درستی وارد نشده است'));
                    return $this->redirect($this->referer());
                }
            }

            if (
                $session->read('show_recaptcha') == 1 
                and
                $this->Captcha->getCode('securitycode') != $this->request->getData()['securitycode'])
                {
                    if ($this->request->is('ajax')) {
                        return $this->response->withType('application/json')->withStringBody(json_encode([
                            'code'=>'F2',
                            'type'=>'error',
                            'alert'=>__('کدامنیتی اشتباه هست، لطفا دوباره وارد کنید'),
                            'referer'=>null,
                        ]));
                    }
                    else {
                        return $this->Flash->error(__('کدامنیتی اشتباه هست، لطفا دوباره وارد کنید'));
                    }    
            }
            if (!isset($this->request->getData()['username']) or !isset($this->request->getData()['password'])) {
                if ($this->request->is('ajax')) {
                    return $this->response->withType('application/json')->withStringBody(json_encode([
                        'code'=>'F3',
                        'type'=>'error',
                        'alert'=>__('فیلدهای نام کاربری و پسورد پیدا نشد'),
                        'referer'=>null,
                    ]));
                }
                else{
                    return $this->Flash->error(__('فیلدهای نام کاربری و پسورد پیدا نشد'));
                } 
            }

            try {
                $ulog = new \Userslogs\UserLogg();
                if($ulog->login_check_failed([
                    'username' => $this->request->getData()['username'], [
                        'limit' => 3,
                        'time'=> 30
                    ] ]) == false){
                    if ($this->request->is('ajax')) {
                        return $this->response->withType('application/json')->withStringBody(json_encode([
                            'code' => 'F11',
                            'type' => 'error',
                            'alert' => __('تعداد دفعات ورود شما از حد مجاز گذشته است.') . __('امکان ورود تا 30 دقیقه دیگر محدود می باشد'),
                            'referer' => null,
                        ]));
                    }
                    else{
                        $this->Flash->error(__('تعداد دفعات ورود شما از حد مجاز گذشته است.') . __('امکان ورود تا 30دقیقه دیگر محدود میباشد'));
                        return $this->redirect($this->referer());
                    }
                }
            } catch (\Throwable $th) {
                //throw $th;
            }
            
            $result = $this->Authentication->getResult();
            if ($result && $result->isValid()) {
                $user = $this->request->getAttribute('identity');

                //1404/04/04 // Handle "Remember Me" functionality
                if ( $this->request->getData('remember') ) {
                    if(isset($user['remember_token'])){
                        // Generate a secure token
                        $token = Security::hash(uniqid() . time(), 'sha256');
                        
                        // Save token to user record
                        $usersTable = $this->fetchTable('Users');
                        $userEntity = $usersTable->get($user->id);
                        $userEntity->remember_token = $token;
                        $userEntity->remember_token_expiry = new FrozenTime('+30 days');
                        $usersTable->save($userEntity);

                        // Set secure cookie
                        $cookie = (new Cookie('remember_me'))
                            ->withValue($token)
                            ->withExpiry(new FrozenTime('+30 days'))
                            ->withSecure(true) // Only send over HTTPS
                            ->withHttpOnly(true); // Prevent JavaScript access
                        
                        $this->response = $this->response->withCookie($cookie);
                    }
                    else{
                        $this->Flash->error(__('امکان "مرا به خاطر بسپار" در حال حاضر مقدور نمیباشد'));
                    }
                }
                
                //فعلا غیرفعال شد 1404.03.07
                /* if ($this->Func->OptionGet('login_expired_check') == 1 and $user->get('expired') != null ) {
                    $time = new Time($user->get('expired'));
                    $time->setTimezone(new \DateTimeZone('Asia/Tehran'));
                    if (Time::now() > $time) {
                        $this->request->getSession()->destroy();
                        $this->Cookie->delete('connects');
                        $this->Flash->error(
                            ($alrm = $this->Func->OptionGet('login_expired_alarm'))!= ''?
                            $alrm:
                                __('مدت زمان دسترسی شما به سامانه پایان یافته است') .'.<br>'.
                                __('شما اجازه ورود به سامانه را ندارید')
                            );
                        return $this->redirect($this->referer());
                    }
                } */
                    
                //فعلا غیرفعال شد 1404.03.07
                /* if(isset($this->request->getData()['remember']) and $this->request->getData()['remember'] == 1)
                    $this->_setAutoLogin($user->get('id')); */

                $session->delete('show_recaptcha');
                if ($this->request->is('ajax')) {
                    $this->response->withType('application/json')->withStringBody(json_encode([
                        'code'=>'F4',
                        'type'=>'success',
                        'alert'=>__('ورود شما به پنل کاربری با موفقیت انجام شد'),
                        'referer'=>null,
                    ]));
                } else {
                    $this->Flash->success(__('ورود شما به پنل کاربری با موفقیت انجام شد'));
                }

                $role_list = [];
                try {
                    $role_array = $user->get('role');
                    if(isset($role_array['data']))
                        $role_list = unserialize($role_array['data']);
                } catch (\Throwable $th) {
                }
                $this->Authentication->getResult()->getData()->offsetSet('role_list', $role_list);
                $this->Authentication->getResult()->getData()->offsetSet('session_hash', $this->_hashGenerator() );

                try {
                    $ulog = new \Userslogs\UserLogg();
                    $p = $ulog->login_savelog([
                        'username'=>$user->get('username'),
                        'id' => $user->get('id')
                    ], 1); //1:succ 2:faild
                } catch (\Throwable $th) {
                    //throw $th;
                }

                //if redirect pass in url
                if($this->request->getQuery('redirect')){
                    return $this->redirect($this->request->getQuery('redirect'));
                }
                    
                //check for first visit to complete profile
                if( $this->Func->OptionGet('complete_profile') == 1 
                    and 
                    $ulog->login_firstvisit(['id' => $user->get('id'),'username'=>$user->get('username')]) == false 
                    ){
                        /* if($this->request->is('ajax')){
                            $this->response->withType('application/json')->withStringBody(json_encode([
                                'code'=>'F6',
                                'type'=>'info',
                                'alert'=>__('ورود انجام شد. لطفا مشخصات کاربری اکانت خود را تکمیل فرمایید'),
                                'referer'=> null,
                            ]));
                        }
                        else
                            $this->Flash->success(__('لطفا مشخصات کاربری اکانت خود را تکمیل فرمایید')); */
                    
                        if($this->request->is('ajax')){
                            return $this->response->withType('application/json')->withStringBody(json_encode([
                                'code'=>'F7',
                                'type'=>'success',
                                'alert'=>'ورود انجام شد، لطفا مشخصات کاربری اکانت خود را تکمیل فرمایید',
                                'referer'=> Router::url(['plugin'=>'Admin','controller'=>'Users','action'=>'profile']),
                            ]));
                        }
                        else{
                            return $this->redirect(['plugin'=>'Admin','controller'=>'Users','action'=>'profile']);
                        }
                }
                
                if( $user->get('role_id') == 1 ){
                    $redirect = '/admin/';
                }
                else{
                    if($this->Func->OptionGet('login_redirecturl') != "")
                        $redirect = $this->Func->OptionGet('login_redirecturl');
                    else
                        $redirect = [
                            'controller' => 'Users',
                            'action' => 'index',
                        ];
                }
                
                if($this->Func->OptionGet('login_redirecturl') != ''){
                    if($this->request->is('ajax')){
                        return $this->response->withType('application/json')->withStringBody(json_encode([
                            'code'=>'F5',
                            'type'=>'success',
                            'alert'=>__('ورود انجام شد، لطفا منتظر بمانید'),
                            'referer'=> $this->Func->OptionGet('login_redirecturl'),
                        ]));
                    }
                    else{
                        return $this->redirect($this->Func->OptionGet('login_redirecturl'));
                    }
                }
                
                if($this->request->is('ajax')){
                    return $this->response->withType('application/json')->withStringBody(json_encode([
                        'code'=>'F8',
                        'type'=>'success',
                        'alert'=>__('ورود شما به پنل کاربری با موفقیت انجام شد'),
                        'referer'=> Router::url($redirect),
                    ]));
                }
                else{
                    return $this->redirect($redirect);
                }
                
            }
            else{
                if($this->Func->OptionGet('register_type') == 'mobile'){
                    $temp = TableRegistry::getTableLocator()->get('Admin.Users')->find('all')
                        ->where(['username'=>$this->request->getData()['username'],'enable' => 0])
                        ->first();
                    if($temp){
                        $checker = new DefaultPasswordHasher;
                        if($checker->check($this->request->getData()['password'], $temp['password'])){
                            $this->request->getSession()->write('SmsActivations.data',$temp);
                            $this->request->getSession()->write('SmsActivations.user_id', $temp['id']);

                            if($this->request->is('ajax')){
                                return $this->response->withType('application/json')->withStringBody(json_encode([
                                    'code'=>'F10',
                                    'type'=>'success',
                                    'alert'=>__('جهت فعال سازی لطفا منتظر بمانید'),
                                    'referer'=> Router::url('/sms/autoactivate'),
                                ]));
                            }
                            else{
                                return $this->redirect('/sms/autoactivate');
                            }
                        }
                    }
                }

                try {
                    $ulog = new \Userslogs\UserLogg();
                    $ulog->login_savelog([
                        'username' => $this->request->getData()['username']
                    ], 2); //1:succ 2:faild
                } catch (\Throwable $th) {
                    //throw $th;
                }

                // if user-pass was incorrect, show recaptcha for new login
                $session->write('show_recaptcha', 1 );

                if($this->request->is('ajax')){
                    return $this->response->withType('application/json')->withStringBody(json_encode([
                        'code'=>'F9',
                        'type'=>'error',
                        'alert'=>__('نام کاربری یا پسورد اشتباه هست. لطفا دوباره تلاش کنید'),
                        'referer'=>null,
                    ]));
                }
                else{
                    $this->Flash->error(__('نام کاربری یا پسورد اشتباه هست. لطفا دوباره تلاش کنید'));
                }
            }
        }
        if($this->Func->OptionGet('template_logint') == 1){
            try{
                $this->render('Template.Admin'.DS.'login');
            }
            catch (\Exception $e){
                try {
                    $this->render('login');
                } catch (\Throwable $th) {
                    echo __('قالب ورود پیدا نشد');
                } 
            }
        }
    }
    //----------------------------------------------------------
    public function rememberToken($token = null){
        if($this->Func->OptionGet('remember_status') == 0){
            $this->Flash->error(__('دسترسی به این بخش امکان پذیر نیست'));
            return $this->redirect(['action'=>'remember']);
        }
        if(!$this->request->getSession()->read('remember.username')){
            $this->Flash->error(__('دسترسی به این بخش برای شما محدود شده است'));
            return $this->redirect(['action'=>'remember']);
        }

        if($this->Func->OptionGet('template_layout') == 1)
            $this->viewBuilder()->setLayout('Template.login');
        else
            $this->viewBuilder()->setLayout('login');

        if ($this->request->is(['post', 'put'])) {
            if($this->request->getData()['token'] == null or
                $this->request->getData()['password'] == null){

                    $this->Flash->error(__('دسترسی به این بخش امکان پذیر نیست'));
                    return $this->redirect(['action'=>'remember']);  
            }

            $user = $this->Users->find('all')
                ->where(['token' => $this->request->getData()['token'] ])
                ->first();

            if(! $user){
                $this->Flash->error(__('متاسفانه چنین کاربری پیدا نشد'));
                return $this->redirect($this->referer());
            }
            
            if ($this->request->is(['post'])) {
                $user = $this->Users->patchEntity($user,[
                    'password'=> $this->request->getData()['password'],
                    'token'=> null
                ]);
                if ($this->Users->save($user)){
                    $this->request->getSession()->delete('remember');
                    $this->Flash->success(__('رمز عبور باموفقیت بروز رسانی شد'));
                    return $this->redirect(['action'=>'login']);
                }
                else
                    $this->Flash->error(__('متاسفانه رمز عبور بروز رسانی نشد'));
            }
        }
        $this->set([
            'token'=> $token,
        ]);
    }
    //----------------------------------------------------------
    public function remember(){

        /* $email = new Email();
        TransportFactory::setConfig('site', [
            'host' => 'najm.cfss.ir',
            'port' => 465,
            'username' => 'test@najm.cfss.ir',
            'password' => 'lesWd.$4;D?L',
            'className' => 'Smtp',
            'tls' => true
        ]);
        $email->setTransport('site');
        $email->setFrom([ "sorushsa@gmail.com" => "saeed" ])
            ->setTo("sorushsa@gmail.com")
            ->setSubject('یادآوری رمز عبور')
            ->send('<a href="##">برای تغییر رمز اکانت کاربری کلیک کنید</a>'); */
            
        if($this->Func->OptionGet('template_layout') == 1)
            $this->viewBuilder()->setLayout('Template.login');
        else
            $this->viewBuilder()->setLayout('login');

        if ($user = $this->request->getAttribute('identity'))
            $this->redirect(['action'=>'index']);
            
        if ($this->request->is('post')) {

            if (!isset($this->request->getData()['securitycode']) or 
                $this->Captcha->getCode('securitycode') != $this->request->getData()['securitycode']) {
                    return $this->Flash->error(__('کد امنیتی وارد شده اشتباه است، لطفا دوباره وارد نمایید'));
            }

            $user = $this->Users->find('all')->where([
                'username'=>$this->request->getData()['username'],
                'enable'=> 1,
                ])->first();
            if (! $user) {
                $this->Flash->error(__('متاسفانه چنین کاربری پیدا نشد. ممکن است کاربر غیرفعال شده باشد. از طریق پشتیبانی پیگیری نمایید'));
                return $this->redirect($this->referer());
            }

            $token = null;
            switch ($this->Func->OptionGet('register_type')) {
                case 'mobile':
                    $token = strtolower($this->generateRandomString(8));
                    break;

                default:
                    $token = $this->generateRandomString(20);
                    if ($user['email'] == '') {
                        $this->Flash->error(__('متاسفانه آدرس ایمیلی برای اکانتتان ثبت نکرده اید، از طریق پشتیبانی پیگیری نمایید'));
                        return $this->redirect($this->referer());
                    }
                break;
            }
   
            $this->request = $this->request->withData('token', $token);
            $users = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($users)) {
                $this->request->getSession()->write('remember.username', $users['username']);
                switch ($this->Func->OptionGet('register_type')) {
                    case 'mobile':
                        // Send Remember Sms
                        $this->sms = new Sms();
                        $text = $this->sms->setting;
                        if(
                            isset($text['smstext_remember']) 
                            and 
                            $text['smstext_remember'] != '')
                        {
                            $this->sms->sendsingle([
                                'mobile' =>  $user['username'],
                                'text' => $this->sms->create_text($text['smstext_remember'], [
                                        'username'=>$user['username'],
                                        'token'=>$token,
                                        'family'=> $user['family']
                                    ]),
                            ]);
                        }
                        $this->Flash->success(__d('Template', 'اگر مشخصات شما پیدا شده باشد، پیامک تایید برای شما ارسال خواهد شد'));
                        break;

                    default:
                        $temp_email = $this->Func->OptionGet('admin_email');
                        $temp_name = $this->Func->OptionGet('name');
                        $temp_url = Router::url('/', true). 'users/remember/token/'. $token;
                        
                        /*$ email = new Email();
                        $email->setTransport('default');
                        $email->setFrom([ ($temp_email!=''?$temp_email:'default@yahoo.com') => $temp_name!=''?$temp_name:'default name' ])
                            ->setTo($user['email'])
                            ->setSubject('یادآوری رمز عبور')
                            ->send('<a href="'.$temp_url.'">برای تغییر رمز اکانت کاربری کلیک کنید</a>'); */
                    $this->Flash->success(__('در صورتی که چنین اکانتی وجود داشته باشد،
                     مشخصات فراموشی پسورد به ایمیل شما ارسال خواهد گردید'));
                }

                return $this->redirect(Router::url('/', true).'users/remember/token/');
            }
            else{
                $this->Flash->error(__('متاسفانه امکان استفاده از سرویس فراموشی پسورد وجود ندارد'));
            }
        }
    }
    //----------------------------------------------------------
    public function register($type = null) {
        if($this->Func->OptionGet('template_layout') == 1)
            $this->viewBuilder()->setLayout('Template.login');
        else
            $this->viewBuilder()->setLayout('login');

        global $register_users;
        $this->request->getSession()->delete('SmsActivations');
        if ($user = $this->request->getAttribute('identity'))
            $this->redirect(['action'=>'index']);

        $user = $this->Users->newEntity($this->request->getData());
        if ($this->request->is(['post', 'put'])) {
            //sms setting
            $this->sms = new Sms();
            $setting_sms = $this->sms->setting;

            $session = $this->getRequest()->getSession();
            if ($this->request->is('ajax')) {
                $this->autoRender = false;
            }

            $this->request->getSession()->delete('SmsActivations');
            /* if ($session->read('show_recaptcha') == 1 and !isset($this->request->getData()['securitycode'])) {
                if ($this->request->is('ajax')) {
                    return $this->response->withType('application/json')->withStringBody(json_encode([
                        'code'=>'R1',
                        'type'=>'error',
                        'alert'=>__('کد امنیتی به درستی ارسال نشده است'),
                        'referer'=>null 
                    ]));
                } else {
                    $this->Flash->error(__('کد امنیتی به درستی ارسال نشده است'));
                    if ($this->Func->OptionGet('template_regt') == 1) {
                        try {
                            $this->render('Template.Admin'.DS.'register');
                        } catch (\Throwable $th) {
                            $this->render('register');
                        } 
                    }
                    return $this->redirect($this->referer());
                }
            } */

            if (!isset($this->request->getData()['securitycode']) or 
                $this->Captcha->getCode('securitycode') != $this->request->getData()['securitycode']) {
                    $this->set(compact('user'));
                    if ($this->request->is('ajax')) {
                        return $this->response->withType('application/json')->withStringBody(json_encode([
                            'code'=>'R2',
                            'type'=>'error',
                            'alert'=>__('کد امنیتی وارد شده اشتباه است، لطفا دوباره وارد نمایید'),
                            'referer'=>null,
                        ]));
                    } else {
                        if ($this->Func->OptionGet('template_regt') == 1) {
                            try {
                                $this->render('Template.Admin'.DS.'register');
                            } catch (\Throwable $th) {
                                $this->render('register');
                            } 
                        }
                        return $this->Flash->error(__('کد امنیتی وارد شده اشتباه است، لطفا دوباره وارد نمایید'));
                    }
            }

            if(!isset($this->request->getData()['username']) or !isset($this->request->getData()['password'])){
                if($this->request->is('ajax')){
                    return $this->response->withType('application/json')->withStringBody(json_encode([
                        'code'=>'R3',
                        'type'=>'error',
                        'alert'=>__('فیلدهای نام کاربری و پسورد پیدا نشد'),
                        'referer'=>null,
                    ]));
                }
                else{
                    if($this->Func->OptionGet('template_regt') == 1){
                        try {
                            $this->render('Template.Admin'.DS.'register');
                        } catch (\Throwable $th) {
                            $this->render('register');
                        } 
                    }
                    return $this->Flash->error(__('فیلدهای نام کاربری و پسورد پیدا نشد'));
                } 
            }
            if( $this->request->getData()['username'] =='' or $this->request->getData()['password']=='' ){
                if($this->request->is('ajax')){
                    return $this->response->withType('application/json')->withStringBody(json_encode([
                        'code'=>'R03',
                        'type'=>'error',
                        'alert'=>__('نام کاربری یا پسورد خالی است'),
                        'referer'=>null,
                    ]));
                }
                else{
                    if($this->Func->OptionGet('template_regt') == 1){
                        try {
                            $this->render('Template.Admin'.DS.'register');
                        } catch (\Throwable $th) {
                            $this->render('register');
                        } 
                    }
                    return $this->Flash->error(__('نام کاربری یا پسورد خالی است'));
                } 
            }

            $activate = $this->Func->OptionGet('register_activation');
            if( 
                ($month = $this->Func->OptionGet('reg_expired_month')) != null 
                and 
                $month!= 0)
            {
                $time = new FrozenTime('now');
                $time->addDays(intval($month));
                $this->request = $this->request->withData('expired', $time->format('Y-m-d'));
            }
            $this->request = $this->request->withData('role_id', intval($this->Func->OptionGet('register_default_role')));
            $this->request = $this->request->withData('enable', ($activate == 'none')? 1:0 );
            $this->request = $this->request->withData('token', ($token = rand(100000, 999999)) );

            switch ($this->Func->OptionGet('register_type')) {
                case 'codemeli':
                    $user = $this->Users->patchEntity($user, $this->request->getData(),['validate' =>'codemeli']);
                    break;

                case 'mobile':
                    $user = $this->Users->patchEntity($user, $this->request->getData(),['validate' =>'mobile']);
                    break;
                
                default:
                    $user = $this->Users->patchEntity($user, $this->request->getData());
                    break;
            }
            
            if ($this->Users->save($user)) {
                $register_users = $user;

                if(($this->request->getData('UserMetas'))):
                    foreach($this->request->getData('UserMetas') as $key => $val){
                        $this->Func->PostMetaSave($user->id,[
                            'source' =>'users',
                            'type' => 'meta',
                            'name' => $key,
                            'value' => $val,
                            'action' => 'create']);
                    }
                endif;

                if( $this->Func->OptionGet('register_with_sms') != 1 ){
                    /* 
                        در صورتی که تایید شماره موبایل قرار است انجام شو
                        د، پیامک تایید در این مرحله انجام نخواهد شد
                        Send Welcome Sms
                    */
                    
                    if (isset($setting_sms['smstext_regsucc']) and $setting_sms['smstext_regsucc'] != '') {
                        $this->sms->sendsingle([
                            'mobile' =>  $user['username'],
                            'text' => $this->sms->create_text($setting_sms['smstext_regsucc'], [
                                    'username'=>$user['username'],
                                    'family'=>$this->request->getdata()['family'],
                                ]),
                        ]);
                    }
                }
                
                //send username and password via sms
                if (isset($setting_sms['smstext_register']) and $setting_sms['smstext_register'] != '') {
                    $this->sms->sendsingle([
                        'mobile' =>  $user['username'],
                        'text' => $this->sms->create_text($setting_sms['smstext_register'], [
                                'password'=>isset($this->request->getData()['password'])?$this->request->getData()['password']:"",
                                'family'=>isset($this->request->getData()['family'])?$this->request->getData()['family']:"",
                                'username'=>isset($user['username'])?$user['username']:"",
                            ]),
                    ]);
                }

                    
                $rfield = new RField();
                $rfield->getSms($this->request->getQuery());

                if($this->Func->OptionGet('register_with_sms') == 1 and $this->Func->OptionGet('register_type') == 'mobile'){
                    $this->request->getSession()->write('SmsActivations.data', $this->request->getData());
                    $this->request->getSession()->write('SmsActivations.user_id', $user->id);
                    if($this->request->is('ajax')){
                        return $this->response->withType('application/json')->withStringBody(json_encode([
                            'code'=>'R4',
                            'type'=>'success',
                            'alert'=>__('ثبت نام با موفقیت انجام شد، درحال هدایت به صفحه فعال سازی، لطفا صبر کنید'),
                            'referer'=>Router::url('/sms/autoactivate'),
                        ]));
                    }
                    else{
                        return $this->redirect('/sms/autoactivate');
                    }
                }

                if ($activate == 'email') {
                    $email = new Email();
                    $email->setTransport('default');
                    $temp_email = $this->Func->OptionGet('admin_email');
                    $temp_name = $this->Func->OptionGet('name');
                    $email->setFrom([ ($temp_email!=''?$temp_email:'default@yahoo.com') => $temp_name!=''?$temp_name:'default name' ])
                            ->setTo($user['email'])
                        ->setSubject( __('تایید اکانت کاربری'))
                        ->send('<a href="/users/active/?token='.$token.'">'.__('برای تایید اکانت کاربری کلیک کنید') .'</a>');

                    if($this->request->is('ajax')){
                        return $this->response->withType('application/json')->withStringBody(json_encode([
                            'code'=>'R5',
                            'type'=>'success',
                            'alert'=>__('ایمیلی برای شما ارسال شد، با کلیک در لینک ارسال شده، حساب کاربری تان را تایید کنید'),
                            'referer'=> Router::url(['action' => 'index']),
                        ]));
                    }
                    else{
                        $this->Flash->success(__('ایمیلی برای شما ارسال شد، با کلیک در لینک ارسال شده، حساب کاربری تان را تایید کنید'));
                    }
                }
                elseif($activate == 'admin'){
                    if($this->request->is('ajax')){
                        return $this->response->withType('application/json')->withStringBody(json_encode([
                            'code'=>'R6',
                            'type'=>'success',
                            'alert'=>__('تایید پنل کاربری شما توسط مدیریت انجام خواهد شد'),
                            'referer'=> Router::url(['action' => 'index']),
                        ]));
                    }
                    else{
                        $this->Flash->success(__('تایید پنل کاربری شما توسط مدیریت انجام خواهد شد'));
                    }
                }
                else{
                    if($this->request->is('ajax')){
                        return $this->response->withType('application/json')->withStringBody(json_encode([
                            'code'=>'R7',
                            'type'=>'success',
                            'alert'=>__('ثبت مشخصات شما با موفقیت انجام شد.'),
                            'referer'=> Router::url(['action' => 'index']),
                        ]));
                    }
                    else{
                        $this->Flash->success(__('ثبت مشخصات شما با موفقیت انجام شد.'));
                    }
                }

                if( $this->Func->OptionGet('register_with_sms') == 1 ){
                    $this->request->getSession()->write('SmsActivations.data', $this->request->getData());
                    $this->request->getSession()->write('SmsActivations.user_id', $user->id);
                    if($this->request->is('ajax')){
                        return $this->response->withType('application/json')->withStringBody(json_encode([
                            'code'=>'R8',
                            'type'=>'success',
                            'alert'=>__('ثبت مشخصات شما با موفقیت انجام شد.'),
                            'referer'=> Router::url('/sms/activation'),
                        ]));
                    }
                    else{
                        return $this->redirect('/sms/activation');
                    }
                }

                if($this->request->is('ajax'))
                {}
                else{
                    if($this->Func->OptionGet('template_regt') == 1){
                        try {
                            $this->render('Template.Admin'.DS.'register');
                        } catch (\Throwable $th) {
                            $this->render('register');
                        } 
                    }
                    return $this->redirect(['action' => 'index']);
                }
            }
            else{
                //pr($user->geterrors());
                Log::error('Something horrible happened');

                if($this->request->is('ajax')){
                    $err = '';
                    foreach($user->geterrors() as $error){
                        $err .= '<br>'.array_shift($error);
                    }
                    return $this->response->withType('application/json')->withStringBody(json_encode([
                        'code'=>'R9',
                        'type'=>'error',
                        'alert'=>__('متاسفانه ثبت کاربر جدید انجام نشد') . $err,
                        'referer'=> null,
                    ]));
                }
                else{
                    $this->Flash->error(__('متاسفانه ثبت کاربر جدید انجام نشد'));
                }
            }
                
        }
        $this->set(compact('user'));

        if($this->Func->OptionGet('template_regt') == 1){
            try {
                $this->render('Template.Admin'.DS.'register');
            } catch (\Throwable $th) {
                $this->render('register');
            } 
        }
    }
    //----------------------------------------------------------
    public function index(){
        $this->viewBuilder()->setLayout('Admin.default');
    }
    //----------------------------------------------------------
    function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    //----------------------------------------------------------
    public function logout(){
        $result = $this->Authentication->getResult();
        if ($result->isValid()) {
            
            $user = $this->Authentication->getIdentity();
            //$this->_activity('delete');
            
            if ($this->request->getCookie('remember_me') and isset($user['remember_token'])) {
                if ($user) {
                    $usersTable = $this->fetchTable('Users');
                    $userEntity = $usersTable->get($user->id);
                    $userEntity->remember_token = null;
                    $userEntity->remember_token_expiry = null;
                    $usersTable->save($userEntity);
                }
                $this->response = $this->response->withExpiredCookie(new Cookie('remember_me'));
            }
            $this->Authentication->logout();
            $this->request->getSession()->destroy();
            $this->Func->OptionGet('logout_alert')!= ""?
                $this->Flash->success($this->Func->OptionGet('logout_alert')):
                $this->Flash->success(__('شما با موفقیت از سایت خارج شدید'));

            return $this->Func->OptionGet('logout_url')!= ""?
                $this->redirect($this->Func->OptionGet('logout_url')):
                $this->redirect($this->Authentication->logout());
        }
        return $this->redirect($this->referer());
    }
    //----------------------------------------------------------
    
    //----------------------------------------------------------
    //فعلا غیرفعال شد 1404.03.07
    function _autoLogin(){
        if ($this->Cookie->read('connects')) {
            /* $user = $this->Users->findByToken($this->Cookie->read('connects'))->first();
            if($user){
                $this->_setAutoLogin($user['id']);
                $user['session_hash'] = $this->_hashGenerator();
                
                $this->Auth->setUser($user);
                $ulog = new \Userslogs\UserLogg();
                return $this->redirect($this->Auth->redirectUrl());
            } */
            /* else 
                return false; */
        }
        /* else
            return false; */
    }
    //----------------------------------------------------------
    function _hashGenerator(){
        return Security::hash((string) rand(), 'sha1', true);
    }
    //----------------------------------------------------------
    function _setAutoLogin($id=null){
        $hash = $this->_hashGenerator();
        $this->Cookie->setConfig([
            'expires' => '+30 days',//'httpOnly' => true
        ]);
        $this->Cookie->write('connects', $hash);
        $user = $this->Users->get($id);
        if($user){
            $user->token = $hash;
            if ($this->Users->save($user))
                return true;
            else return false;
        }
        else
            return false;
    }
    //--------------------------------------------------------------------
    //1401-12-05
    public function thumbnail($filename = null,$max_width = 150, $max_height = 150){
        $this->autoRender = false;
        if($filename != null)
            $filename = WWW_ROOT.'uploads'.DS.$filename;
        else
            $filename = WWW_ROOT.'uploads'.DS.$this->request->getQuery('file');
    
        if (file_exists($filename) and $data = getimagesize($filename)) {
            list($orig_width, $orig_height) = getimagesize($filename);

            /* $max_width = $max_height = 150; */
            $width = $orig_width;
            $height = $orig_height;
            header('Content-type: image/png');
            # taller
            if ($height > $max_height) {
                $width = ($max_height / $height) * $width;
                $height = $max_height;
            }
            # wider
            if ($width > $max_width) {
                $height = ($max_width / $width) * $height;
                $width = $max_width;
            }
            $image_p = imagecreatetruecolor($width, $height);
            $image = imagecreatefromjpeg($filename);
            imagecopyresampled($image_p, $image, 0, 0, 0, 0,$width, $height, $orig_width, $orig_height);
            try {
                die(@imagejpeg($image_p, null, 100));
            } catch (\Throwable $th) {
                return null;
            }
        } else {
            return null;
        }
    }

}