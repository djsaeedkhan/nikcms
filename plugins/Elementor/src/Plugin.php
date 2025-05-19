<?php
namespace Elementor;

use Cake\Core\BasePlugin;
use Admin\View\Helper\FuncHelper;
class Plugin extends BasePlugin{
    public $name= 'Elementor';
    public function options($type = null){
        switch ($type) {
            case 'register':
            case 'register_form':
                /* $temp = new RField();
                return $temp->create_RegisterField($_GET); */
        }
    }
    function options_role(){
        return [
            'plugin' => self::config()['name'] ,
            'title' => self::config()['title'],
            'role'=> [
                'Home' => [
                    'title' => 'تنظیمات',
                    'action' => [
                        'index'=>'صفحه نخست',
                        'savesetting'=>'ثبت تنظیمات',
                    ]
                ],
            ]
        ];
    }
    public function preload(){
        FuncHelper::do_action('options_role', self::options_role());
    }
    public function activation(){}
    public function deactivation($drop = false){}
    public function config(){
        return [
            'name'=>'Elementor',
            'title'=>'المنتور (مدیریت بلاک ها)',
            'icon'=>'fa fa-item',
            'description'=>'',
            'author'=>'Mahan',
            'version'=>'1.0',
            'path' =>[
                'index' =>'',
                'admin' =>'',
                'setting' =>'',
                ]
        ];
    }
}
