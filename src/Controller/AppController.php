<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Http\BaseApplication;
use Cake\Core\Plugin;
use Cake\I18n\I18n;
use Admin\View\Helper\FuncHelper;
use Admin\View\Helper\QueryHelper;
use Admin\View\Helper\ModuleHelper;
use Admin\View\Helper\FormCspHelper;
use Cake\Core\Configure;
use Cake\View\Cell;
use Cake\View\CellTrait;
use Cake\View\View;
use Cake\Log\Log;
use Cake\Routing\Router;
use Cake\Event\EventInterface;
//use Authorization\AuthorizationAwareTrait; // برای استفاده از authorize()
use Authentication\AuthenticationAwareTrait; // برای دسترسی به هویت کاربر لاگین کرده

class AppController extends Controller
{
    use CellTrait;
    ///use AuthorizationAwareTrait;
    //use AuthenticationAwareTrait;
    
    public $Func;
    public $Query;
    public $upload_path = 'uploads/';
    public function initialize(): void
    {
        parent::initialize();
		define('inter_mode', true); //get resource from inside project

        /*
         * Enable the following component for recommended CakePHP form protection settings.
         * see https://book.cakephp.org/4/en/controllers/components/form-protection.html
         */
        //$this->loadComponent('FormProtection');
        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
        $this->loadComponent('Authentication.Authentication');
        //$this->loadComponent('Authorization.Authorization');
        $this->loadComponent('Captcha.Captcha'); //load on the fly!
        
        $view = new View();
        global $upload_path;
        $upload_path = $this->upload_path;

        $this->Query = new QueryHelper($view);
        $this->Func = new FuncHelper($view);
        //$this->FormCsp = new FormHelper(new \Cake\View\View());
        if ($this->request->getQuery('dibug')) {
            Configure::write('debug', 1);
        }
        $this->set([
            'upload_path'=>$this->upload_path,
            ]);
        $this->_preloader();
        
    }
    //----------------------------------------------------
    public function _preloader(){
        $this->_preSetting();
        $this->_nonce();
        $this->_lang();
        $this->_run();
        $this->_security();
    }
    //----------------------------------------------------
    /* public function iisAuthorized(){
        $plg = strtolower( (string) $this->request->getParam('plugin'));
        $cont = strtolower( (string) $this->request->getParam('controller'));
        $act = strtolower( (string) $this->request->getParam('action'));
        $role = $this->request->getAttribute('identity')->get('role_list');
        if (isset($role[$plg])) {
            if (isset($role[$plg][$cont][$act]) and $role[$plg][$cont][$act] != "0"){
                $this->Flash->error("{$plg}__{$cont}__{$act}");
                return true;
            }else{
                $this->Flash->error("{$plg}__{$cont}__{$act}");
                //Log::write('debug', ['plgin'=>$plg,'cont'=>$cont,'act'=>$act ]);
                return false;
            }
        }
        return true;
    } */
    //----------------------------------------------------
    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);
        // این خط، دسترسی کاربر را در هر درخواست چک می‌کند.
        //$this->Authorization->authorize($this->getRequest(), 'access');


        /* if(!$this->iisAuthorized()){
            $this->Flash->error(__('دسترسی شما به این صفحه محدود شده است'));
            //return $this->redirect($this->referer());
        } */
        /* $this->Authentication->addUnauthenticatedActions([
            'login', 'registers','Website.home']); */
        //$this->Authentication->allowUnauthenticated([]);
    }
    //----------------------------------------------------
    private function _nonce(){
        if (isset($_SERVER['CSP_NONCE'] ) and $_SERVER['CSP_NONCE']!= '')
            define('get_nonce', $_SERVER['CSP_NONCE']);
        else
            define('get_nonce', rand(10000000,99999999)); //get form noncey(){
    }
    //----------------------------------------------------
    private function _security(){
        $redi = false;
        $temp = $this->request->getQuery();
        foreach($temp as $k=>$s){
            $en = false;
            if(h($k) !=  $k){
                $en = true;
                $k = h($k);
            }
            if(h($s) != $s){
                $en = true;
                $s = h($s);
            }
            if($en == true){
                unset($temp[$k]);
                $temp[$k] = $s;
                $redi = true;
            }
        }
        $link = explode('?', Router::url(null, true));
        if (is_array($link) and isset($link[0])) {
            if (h($link[0]) != $link[0]) {
                $link[0] = h($link[0]);
                $redi = true;
            }
        }
        if ($redi == true) {
            die(header('location:'.$link[0] . ((is_array($temp) and count($temp)>0)?'?'.implode('&', $temp):'') ));
        }
    }
    //----------------------------------------------------
    private function _lang(){
        if(($lang = $this->Func->OptionGet('lang_name'))) 
            I18n::setLocale($lang);
        else 
            I18n::setLocale('fa');

        if ($this->request->getQuery('lang') and $this->request->getQuery('lang') != '') {
            $langs = $this->Func->language_list();
            $q = $this->request->getQuery('lang');
            if (isset($langs[$q])) {
                $this->request->getSession()->write('lang', h($q));
                $this->redirect($this->referer());
            }
        }

        if ($this->request->getSession()->read('lang') and 
            $this->request->getSession()->read('lang') != '') {

            if (strtolower($this->request->getParam('plugin')) == 'admin') {
                $this->request->getSession()->delete('lang');
            } else {
                I18n::setLocale($this->request->getSession()->read('lang'));
                $lang = $this->request->getSession()->read('lang'); 
            }
        }
        global $current_lang;
        $current_lang = $lang;
        $this->set('current_lang', $lang);

        global $lang_alt; // alternative language
        if( ($tlang_alt = $this->Func->OptionGet('lang_alt')) != '')
            $lang_alt = $tlang_alt;
    }
    //----------------------------------------------------
    private function _run(){
        if ($this->Query->info('maintenance_mode') == 1 and !in_array($this->plugin, ['Admin', ''])) {
            echo $this->cell('Comingsoon.View');
        }
        $this->Func->Run();
    }
    //----------------------------------------------------
    public function _activity($action = null) {
        try {
           $st = unserialize($this->Func->Optionget('session_template'));
        } catch (\Throwable $th) {
            return null;
        }
        
        if($action == 'getlist')
            return $st;

        $st[$this->request->getAttribute('identity')->get('session_hash')] = [
            'id' => $this->request->getAttribute('identity')->get('id'), 
            'username' => $this->request->getAttribute('identity')->get('username'), 
            'date' => date('Y-m-d H:i:s'),
            'url' => $this->_currenturl()
        ];
        if ($action =='delete') {
            unset($st[$this->request->getAttribute('identity')->get('session_hash')]);
        }

        foreach ($st as $stk => $stv) {
            $tmp = date_diff(
                date_create_from_format('Y-m-d H:i:s', date('Y-m-d H:i:s')), 
                date_create_from_format('Y-m-d H:i:s', $stv['date']) 
            );
            if(intval($tmp->format('%i')) > 10)
                unset($st[$stk]);
            if($stk == null)
                unset($st[$stk]);
        }
        $this->Func->OptionSave('session_template', serialize($st), 'create');
        return $st;
    }
    //----------------------------------------------------
    private function _currenturl() {
        return 
            strtolower($this->request->getParam('plugin')).
            '_'.
            strtolower($this->request->getParam('controller')).
            '_'.
            strtolower($this->request->getParam('action'));
    }
    //----------------------------------------------------
    private function _preSetting(){
        if($this->Func->OptionGet('install') == false && $this->Func->OptionGet('name') == false ){
            $arr = json_decode('[
                {"name":"name","value":"سامانه ماهان"},
                {"name":"description","value":""},
                {"name":"siteurl","value":""},
                {"name":"admin_email","value":""},
                {"name":"site_favicon","value":""},
                {"name":"keywords","value":""},
                {"name":"plugin_available_list","value":"a:35:{i:2;s:7:\"Website\";i:5;s:7:\"Contact\";i:6;s:7:\"Predata\";i:7;s:5:\"Admin\";i:8;s:8:\"Template\";i:9;s:11:\"Formbuilder\";i:10;s:4:\"Poll\";i:11;s:7:\"Captcha\";i:12;s:10:\"Breadcrumb\";i:13;s:6:\"Slider\";i:14;s:10:\"Newsletter\";i:15;s:7:\"Tinyurl\";i:16;s:9:\"Postviews\";i:19;s:10:\"Comingsoon\";i:20;s:6:\"Backup\";i:21;s:8:\"StopSpam\";i:22;s:3:\"Sms\";i:23;s:13:\"RegisterField\";i:24;s:4:\"Role\";i:25;s:8:\"Userlogs\";i:26;s:8:\"Security\";i:27;s:6:\"Widget\";i:28;s:10:\"OnlineChat\";i:29;s:4:\"Help\";i:30;s:6:\"Prints\";i:31;s:6:\"Rating\";i:33;s:3:\"Rss\";i:37;s:3:\"Seo\";i:38;s:4:\"Mpdf\";i:39;s:5:\"Mpdfs\";i:43;s:9:\"Scheduler\";i:46;s:9:\"Userslogs\";i:47;s:9:\"Challenge\";i:48;s:3:\"Lms\";i:49;s:4:\"Shop\";}"},
                {"name":"lang_name","value":"fa"},
                {"name":"register_status","value":"1"},
                {"name":"register_alert","value":""},
                {"name":"login_status","value":"1"},
                {"name":"login_alert","value":"در حال حاضر امکان ورود به سایت وجود ندارد. باتشکر"},
                {"name":"login_key","value":"i_am_admin"},
                {"name":"website_template","value":"Template"},
                {"name":"login_background","value":null},
                {"name":"register_info","value":""},
                {"name":"st__login_background","value":null},
                {"name":"st__register_info","value":"<h2>توضیحات<\/h2>\r\n<p>برای استفاده از همه امکانات سایت میبایست ثبت نام کنید<br><p>"},
                {"name":"st__plugin_avlist","value":"Template,Poll,Newsletter,Tinyurl,Contact,Postviews,Widget,Admin,Website,Breadcrumb,Captcha,DatabaseBackup,Role,StopSpam,Formbuilder,Predata,Seo,Userlogs,Comingsoon"},
                {"name":"index_posttype","value":"a:2:{i:0;s:4:\"post\";i:1;s:4:\"page\";}"},
                {"name":"maintenance_mode","value":"0"},
                {"name":"coming_plugin","value":""},
                {"name":"register_activation","value":"none"},
                {"name":"register_default_role","value":"3"},
                {"name":"login_linkurl","value":"","types":null},
                {"name":"login_backimg","value":"","types":null},
                {"name":"login_style","value":".col-lg-8{\r\n    background: #181b20;\r\n}","types":null},
                {"name":"register_linkurl","value":"","types":null},
                {"name":"register_backimg","value":"","types":null},
                {"name":"postviews_plugin","value":"a:0:{}","types":null},
                {"name":"brcrumb_plugin","value":"a:5:{s:10:\"title_home\";s:17:\"صفحه نخست\";s:12:\"title_single\";s:19:\"ادامه مطلب\";s:12:\"title_search\";s:10:\"جستجو\";s:9:\"title_tag\";s:10:\"برچسب\";s:14:\"title_category\";s:17:\"دسته بندی\";}","types":null},
                {"name":"register_with_sms","value":"1","types":null},
                {"name":"فهرست جدید","value":"","types":"nav_menu"},
                {"name":"register_title","value":"","types":null},
                {"name":"register_style","value":".col-lg-7{\r\n   \/* background: #181b20;*\/\r\n}\r\n.secimg img {\r\n    margin-bottom: -120px !important;\r\n}\r\n.clabel{\r\nmargin-bottom: 15px !important;\r\n}\r\n#forms .mt-0{display:none;}","types":null},
                {"name":"register_codemeli","value":"0","types":null},
                {"name":"login_redirecturl","value":"","types":null},
                {"name":"register_legallink","value":"","types":null},
                {"name":"register_type","value":"mobile","types":null},
                {"name":"template_viewin","value":"0","types":null},
                {"name":"template_style","value":"","types":null},
                {"name":"remember_status","value":"1","types":null},
                {"name":"remember_alert","value":"","types":null},
                {"name":"admin_hdr_showsitetitle","value":"","types":null},
                {"name":"admin_hdr_showsitelink","value":"","types":null},
                {"name":"dashboard_logo","value":"","types":null},
                {"name":"admin_extrastyle","value":"","types":null},
                {"name":"posttype_title","value":"a:0:{}","types":null},
                {"name":"complete_profile","value":"0","types":null},
                {"name":"lang_enable","value":"0","types":null},
                {"name":"session_template","value":"a:0:{}","types":null},
                {"name":"login_expired_check","value":"0","types":null},
                {"name":"login_expired_alarm","value":"","types":null},
                {"name":"reg_expired_month","value":"365","types":null},
                {"name":"template_layout","value":"0","types":null},
                {"name":"template_logint","value":"0","types":null},
                {"name":"template_regt","value":"0","types":null},
                {"name":"template_script","value":"","types":null},
                {"name":"admin_calender","value":"0","types":null},
                {"name":"plugin_favorite_list","value":"a:0:{}","types":null},
                {"name":"فهرست 1","value":"a:0:{}","types":"nav_menu"},
                {"name":"field_family","value":"1","types":null},
                {"name":"remember_backimg","value":"","types":null},
                {"name":"remember_style","value":"","types":null},
                {"name":"posts_per_page","value":"2","types":null},
                {"name":"hide_posttype","value":"","types":null},
                {"name":"register_toptext","value":"","types":null},
                {"name":"register_username_text","value":"","types":null},
                {"name":"register_password_text","value":"","types":null},
                {"name":"security_scp_view","value":"0","types":null},
                {"name":"logout_url","value":"","types":null},
                {"name":"logout_alert","value":"","types":null},
                {"name":"sitetoken","value":"booksoc","types":null},
                {"name":"excerpt_from_content","value":"1","types":null},
                {"name":"sidemenu","value":"a:0:{}","types":"nav_menu"},
                {"name":"site_widgetdata","value":"[\r\n [\r\n  {\r\n   \"sidebars\": \"sidebar_home\"\r\n  },\r\n  {\r\n   \"widget\": \"Template.post_list\",\r\n   \"widgetname\": \"post_list\",\r\n   \"name\": \"wigt81677\",\r\n   \"id\": \"wigt81677\"\r\n  },\r\n  {\r\n   \"widget\": \"Template.post_calendar\",\r\n   \"widgetname\": \"post_calendar\",\r\n   \"name\": \"wigt77186\",\r\n   \"id\": \"wigt77186\"\r\n  },\r\n  {\r\n   \"widget\": \"Template.post_bigimg\",\r\n   \"widgetname\": \"post_bigimg\",\r\n   \"name\": \"wigt98219\",\r\n   \"id\": \"wigt98219\"\r\n  }\r\n ],\r\n [\r\n  {\r\n   \"sidebars\": \"sidebar_index\"\r\n  }\r\n ],\r\n [\r\n  {\r\n   \"sidebars\": \"sidebar_single\"\r\n  }\r\n ]\r\n]","types":null},
                {"name":"lang_alt","value":"","types":null},
                {"name":"lang_redirect","value":"0","types":null},
                {"name":"posttype_paginate","value":"a:10:{s:4:\"post\";s:0:\"\";s:4:\"page\";s:0:\"\";s:5:\"media\";s:0:\"\";s:6:\"chnews\";s:0:\"\";s:10:\"chresource\";s:0:\"\";s:9:\"chupdates\";s:0:\"\";s:10:\"challenges\";s:0:\"\";s:9:\"knowledge\";s:0:\"\";s:10:\"multimedia\";s:0:\"\";s:6:\"topics\";s:0:\"\";}","types":null},
                {"name":"uploads_folders","value":"0","types":null},
                {"name":"media_renamefile","value":"0","types":null},
                {"name":"gallery_size","value":"a:1:{s:9:\"thumbnail\";s:1:\"1\";}","types":null},
                {"name":"media_zone","value":"3","types":null},
                {"name":"posts_order","value":"priority","types":null},
                {"name":"watermark_url","value":"","types":null},
                {"name":"marge_right","value":"","types":null},
                {"name":"marge_bottom","value":"","types":null},
                {"name":"watermark_enable","value":"0","types":null},
                {"name":"white_png_background","value":"1","types":null},
                {"name":"plugin_registerfield","value":"a:0:{}","types":null},
                {"name":"install","value":"1"}
            ]',true);
            foreach($arr as $value){
                $p = $this->Func->OptionSave($value['name'], $value['value'], 'create');
            }
            $this->Flash->success(__d('Admin', 'ایجاد دیتا اولیه بخش تنظیمات قالب با موفقیت انجام شد'));
            return $this->redirect($this->referer());
        }
    }
}