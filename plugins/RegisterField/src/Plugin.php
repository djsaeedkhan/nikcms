<?php
namespace RegisterField;
use Cake\Core\BasePlugin;
use Admin\View\Helper\FuncHelper;
use \RegisterField\RField;

class Plugin extends BasePlugin {
    public $name= 'RegisterField';
    public function options($type = null){
        switch ($type) {
            case 'register':
            case 'register_form':
                $temp = new RField();
                return $temp->create_RegisterField($_GET);
                break;

            case 'registeration_after':
                $temp = new RField();
                return $temp->getSms($_GET);
                break;
        }
    }
    public function preload(){
        FuncHelper::do_action('options_registerform', self::options('register_form'));
        FuncHelper::do_action('registeration_after', self::options('registeration_after'));
    }

    public function activation(){}
    public function deactivation( $drop = false){}
    public function config(){
        return [
            'name'=>'RegisterField',
            'title'=>' فیلدهای ثبت نام',
            'icon'=>'fa fa-item',
            'description'=>'مدیریت فیلدهای مورد نیاز برای ثبت نام',
            'author'=>'Mahan',
            'version'=>'1.0',
            'path' =>[
                'index' =>'',
                'admin' =>'/admin/registerfield/',
                'setting' =>'',
                ]
        ];
    }
}
