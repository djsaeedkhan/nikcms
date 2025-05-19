<?php
namespace Seo;
use Cake\Core\BasePlugin;
use Admin\View\Helper\FuncHelper;

class Plugin extends BasePlugin
{
    public $name= 'Seo';
    function options_role(){
        return [
            'plugin' => self::config()['name'] ,
            'title' => self::config()['title'],
            'role'=> [
                'Home' => [
                    'title' => __d('Seo','تنظیمات'),
                    'action' => [
                        'index'=>__d('Seo','صفحه اصلی'),
                    ]
                ],
            ]
        ];
    }
    function post_widget( $menu_type = 'post'){
        switch ($menu_type) {
            case 'dashboard':
                return [
                    [
                        'name'=>'ga_amar',
                        'title' =>__d('Seo','آمار گوگل آنالایتیک'),
                        'widget' =>'Seo.Googlea',
                        'order'=>'hight2'
                    ],
                ];
                break;
            
        }
    }
    public function preload(){
        FuncHelper::do_action('admin_dashboard', self::post_widget('dashboard'));
        FuncHelper::do_action('site_header', ['Seo.Display']);
        FuncHelper::do_action('site_footer', ['Seo.Display::display2']);
        FuncHelper::do_action('options_role', self::options_role());
    }
    public function activation(){}
    public function deactivation( $drop = false){}
    public function config(){
        return [
            'name'=>'Seo',
            'title'=>__d('Seo','سئو'),
            'icon'=>'fa fa-item',
            'description'=>__d('Seo','مدیریت سئو و تنظیمات صفحات'),
            'author'=>'Mahan',
            'version'=>'1.0',
            'path' =>[
                'index' =>'',
                'admin' =>'/admin/seo/',
                'setting' =>'',
                ]
        ];
    }
}
