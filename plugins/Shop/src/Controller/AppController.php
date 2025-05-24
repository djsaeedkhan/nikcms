<?php
namespace Shop\Controller;
use App\Controller\AppController as BaseController;
use Cake\Event\EventInterface;
use Cake\ORM\TableRegistry;
use Shop\View\Helper\CartHelper;

class AppController extends BaseController
{
    public $setting;
    public function initialize(){
        parent::initialize();
        $this->loadComponent('Auth');
        $result = TableRegistry::getTableLocator()->get('Admin.Options')
            ->find('list',['keyField'=>'name','valueField'=>'value'])
            ->where(['name' => 'plugin_shop'])
            ->toArray();
        $this->setting = isset($result['plugin_shop'])? unserialize($result['plugin_shop']) :[];
        $this->set([
            'shop_setting' => $this->setting 
            ]);
            define("shop_currency",  isset($this->setting['currency'])?CartHelper::Predata('currency',$this->setting['currency']) : '');
        define("shop_currency_name", isset($this->setting['currency'])?$this->setting['currency']:'');

        /* if (!$this->isLocalhost() and empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] === "off") {
            $location = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
            header('HTTP/1.1 301 Moved Permanently');
            header('Location: ' . $location);
            exit;
        } */
    }

    public function beforeFilter(Event $event){
        parent::beforeFilter($event);
    }

    function isLocalhost($whitelist = ['127.0.0.1', '::1']) {
        return in_array($_SERVER['REMOTE_ADDR'], $whitelist);
    }
}