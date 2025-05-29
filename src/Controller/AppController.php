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

class AppController extends Controller
{
    use CellTrait;
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
        //$this->loadComponent('Captcha.Captcha'); //load on the fly!
        
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
        $this->Nonce();
        $this->Lang();
        $this->Run();
        $this->Security();
    }
    //----------------------------------------------------
    public function isAuthorized($user){
        $plg = strtolower($this->request->getParam('plugin'));
        $cont = strtolower($this->request->getParam('controller'));
        $act = strtolower($this->request->getParam('action'));
        $role = $this->request->getAttribute('identity')->get('role_list');
        if (isset($role[$plg])) {
            if (isset($role[$plg][$cont][$act]) and $role[$plg][$cont][$act] != "0")
                return true;
            else{
                Log::write('debug', ['plgin'=>$plg,'cont'=>$cont,'act'=>$act ]);
                return false;
            }
        }
        return true;
    }
    //----------------------------------------------------
    /* public function beforeFilter(Event $event){

        parent::beforeFilter($event);
        $this->Auth->allow(['Website.index']); // 'view', 'display'
    } */

    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);
        $this->Authentication->addUnauthenticatedActions([
            'login', 'register','Website.index']);
        //$this->Authentication->allowUnauthenticated([]);
    }
    //----------------------------------------------------
    private function Nonce(){
        if (isset($_SERVER['CSP_NONCE'] ) and $_SERVER['CSP_NONCE']!= '')
            define('get_nonce', $_SERVER['CSP_NONCE']);
        else
            define('get_nonce', rand(10000000,99999999)); //get form noncey(){
    }
    //----------------------------------------------------
    private function Security(){
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
    public function Lang(){
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
    public function Run(){
        if ($this->Query->info('maintenance_mode') == 1 and !in_array($this->plugin, ['Admin', ''])) {
            echo $this->cell('Comingsoon.View');
        }
        $this->Func->Run();
    }
    //----------------------------------------------------
    public function _activity($action = null) {
        $st = unserialize($this->Func->Optionget('session_template'));
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
    public function _currenturl() {
        return 
            strtolower($this->request->getParam('plugin')).
            '_'.
            strtolower($this->request->getParam('controller')).
            '_'.
            strtolower($this->request->getParam('action'));
    }
    //----------------------------------------------------
}