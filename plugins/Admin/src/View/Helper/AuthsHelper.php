<?php
namespace Admin\View\Helper;
use Cake\View\Helper;
use Cake\Log\Log;
use Cake\Utility\Hash;
use Cake\View\Helper\FormHelper;

class AuthsHelper extends Helper
{
    public $helpers = ['Html','Form'];
    protected $_defaultConfig = [];
    const SECURE_SKIP = 'skip';

    function link($name = null , $url = [], $attrib = []){
        if( $this->check($url) == true ){
            return $this->Html->link($name,$url,$attrib);
        }
        return null;
    }
    function postlinks($name = null , $url = [], $attrib = []){
        if( $this->check($url) == true ){
            $this->Html->link($name,$url,$attrib);
            $this->Form->postlink($name,$url,$attrib);
        }
        return null;
    }

    function check($url = []){

        $role = [];
        $plg = null;
        if(is_array($url)){
            $plg = isset($url['plugin'])? strtolower($url['plugin']): strtolower($this->getView()->getRequest()->getParam('plugin'));
            $cont = isset($url['controller'])? strtolower($url['controller']): strtolower($this->getView()->getRequest()->getParam('controller'));
            $act = (isset($url['action']) and !in_array($url , ['/']))? strtolower($url['action']): strtolower($this->getView()->getRequest()->getParam('action'));
            $role = $this->get_session();
        }

        
        if(isset($role[$plg])){
            /* Log::write('debug',[
                'plgin'=>$plg,
                'cont'=>$cont,
                'act'=>$act,
            ]); */

            if(isset($role[$plg][$cont][$act]) and $role[$plg][$cont][$act] != "0")
                return true;
            else{
                /* Log::write('debug',[
                    'plgin11'=>$plg,
                    'cont'=>$cont,
                    'act'=>$act,
                ]); */
                return false;
            }
        }
        return true;
    }

    function get_session(){
        //$this->request->getAttribute('identity')->get('id')
        return $this->getView()->getRequest()->getSession()->read('Auth.User.role_list');
    }
}