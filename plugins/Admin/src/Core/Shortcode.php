<?php
namespace Admin\Core;

use Cake\Datasource\ConnectionManager;
use Cake\ORM\TableRegistry;
use Cake\Utility\Hash;
use Cake\Core\Plugin;
use Cake\Utility\Inflector;
use Cake\Utility\Text;
use Admin\Model\Table\Users;
//use CellTrait;
use Cake\View\CellTrait;

class Shortcode
{
    use CellTrait;
    public function initialize(): void
    {
        //$this->loadComponent('Auth');
    }
    public function work_on_shortcode($data){
        $shortcode = preg_match_all('/\[code (.*?) (.*?) (.*?)\](.*?)\[\/code\]/s', $data, $matches);
        $sentence = array_values($matches[0]);
        $plugins = array_values($matches[1]);
        $action = array_values($matches[2]);
        $param = array_values($matches[3]);
        $value = array_values($matches[4]);

        $site_plugins = Plugin::getCollection();
        foreach($site_plugins as $app){
            if(in_array(strtolower($app->getName()),$plugins)){
                $key = array_search(strtolower($app->getName()), $plugins);
                $sen = $sentence[$key];
                $plg = $plugins[$key];
                $act = $action[$key];
                $prm = $param[$key];
                $vlu = $value[$key];
                $data = str_replace($sen,$app->do_shortcode($plg , $act , $prm , $vlu),$data);
            }
        }
        return $data;
    }
    public function member_func($act = null, $prm = null, $vlu = null){
        
        $data = '';
        if($act == 'member'){
            if ($vlu != "saeed") {
               $data="متاسفانه نمایش این بخش برای شما مقدور نمی باشد"; 
            }
            else $data=$vlu;
        }
        return $data;
    }
}