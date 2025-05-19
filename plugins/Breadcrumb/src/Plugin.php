<?php
namespace Breadcrumb;
use Cake\Core\BasePlugin;

class Plugin extends BasePlugin
{
    public $name= 'Breadcrumb';
    function options_role(){
        return [
            'plugin' => self::config()['name'] ,
            'title' => self::config()['title'],
            'role'=> [
                'Home' => [
                    'title' => __d('Breadcrumb','تنظیمات'),
                    'action' => [
                        'index'=> __d('Breadcrumb','صفحه اصلی'),
                    ]
                ],
            ]
        ];
    }
    public function preload(){
        \Admin\View\Helper\FuncHelper::do_action('options_role', self::options_role());
    }
    public function activation(){}
    public function deactivation( $drop = false){}
    public function config(){
        return [
            'name'=>'Breadcrumb',
            'title'=>__d('Breadcrumb','مکان نما'),
            'icon'=>'fa fa-item',
            'description'=>__d('Breadcrumb','مدیریت مکان نما'),
            'author'=>'Mahan',
            'version'=>'1.0',
            'path' =>[
                'index' =>'',
                'admin' =>'',
                'setting' =>'/admin/breadcrumb/',
                ]
        ];
    }
}
