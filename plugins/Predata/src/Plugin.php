<?php
namespace Predata;
use Cake\Core\BasePlugin;
use Admin\View\Helper\FuncHelper;
use Cake\Console\CommandCollection;
use Cake\Core\ContainerInterface;
use Cake\Core\PluginApplicationInterface;
use Cake\Http\MiddlewareQueue;
use Cake\Routing\Route\DashedRoute;
use Cake\Routing\RouteBuilder;

class Plugin extends BasePlugin
{
    public $name= 'Predata';
    public function options($type){
        switch ($type) {
            case 'public':
                return [
                    'name' => [
                        'name'=>'name',
                        'title' =>__d('Predata', 'عنوان سایت')
                    ],
                    'description' => [
                        'name'=>'description',
                        'title' => __d('Predata', 'معرفی کوتاه')
                    ],
                    'siteurl' => [
                        'name'=>'siteurl',
                        'title' => __d('Predata', 'نشانی سایت (URL)'),
                        'class'=>'ltr',
                        'pholder'=>'http://'
                    ],
                    'sitetoken' => [
                        'name'=>'sitetoken',
                        'title' => __d('Predata', 'کد توکن'),
                        'class'=>'ltr',
                        'pholder'=>'x x x x x x x x'
                    ], 
                    'admin_email' => [
                        'name'=>'admin_email',
                        'title' => __d('Predata', 'ایمیل مدیریت'),
                        'class' =>'ltr',
                        'pholder'=>'email@domain.ir'
                    ],
                    'site_favicon' => [
                        'name'=>'site_favicon',
                        'title' => __d('Predata', 'عکس FavIcon'),
                        'class'=>'ltr',
                        'id'=>'site_favicon',
                        'select_img'=>true
                    ],
                    'dashboard_logo' => [
                        'name'=>'dashboard_logo',
                        'title' => __d('Predata', 'لوگو پیشخوان'),
                        'class'=>'ltr',
                        'id'=>'dashboard_logo',
                        'select_img'=>true
                    ]
                ]; break;
            
            case 'register':
                return [
                    'register_status' => [
                        'name'=>'register_status',
                        'type'=>'select',
                        'options'=>[
                            1 => __d('Predata', 'فعال - امکان ثبت نام'), 
                            0 => __d('Predata', 'غیرفعال - عدم امکان ثبت نام')
                        ],
                        'title' => __d('Predata', 'وضعیت ثبت نام')
                    ],
                    'register_title' =>[
                        'name'=>'register_title',
                        'title' =>__d('Predata', 'عنوان صفحه ثبت نام'),
                        'type'=>'text',
                    ],
                    'register_toptext' =>[
                        'name'=>'register_toptext',
                        'title' =>__d('Predata', 'پیغام ثابت بالای ثبت نام'),
                        'type'=>'textarea',
                    ],
                    'register_alert' =>[
                        'name'=>'register_alert',
                        'title' =>__d('Predata', 'پیغام عدم امکان ثبت نام'),
                        'type'=>'textarea',
                    ],
                    'register_footertext' =>[
                        'name'=>'register_footertext',
                        'title' =>__d('Predata', 'متن پایین صفحه'),
                        'type'=>'textarea',
                    ],
                    'register_username_text' =>[
                        'name'=>'register_username_text',
                        'title' =>__d('Predata', 'متن توضیحات زیر نام کاربری'),
                        'type'=>'text',
                    ],
                    'register_password_text' =>[
                        'name'=>'register_password_text',
                        'title' =>__d('Predata', 'متن توضیحات زیر رمز عبور'),
                        'type'=>'text',
                    ],
                    'st__register_info' =>[
                        'name'=>'st__register_info',
                        'title' => __d('Predata', 'توضیحات ستون چپ'),
                        'type'=>'textarea',
                    ],
                    'register_style' =>[
                        'name'=>'register_style',
                        'title' =>__d('Predata', 'استایل اختصاصی ثبت نام') .' (CSS)',
                        'class'=>'ltr',
                        'type'=>'textarea',
                    ],
                    'register_linkurl' =>[
                        'name'=>'register_linkurl',
                        'title' => __d('Predata', 'لینک ثبت نام'),
                        'type'=>'text',
                        'class'=>'ltr',
                        'pholder'=>'https://',
                    ],
                    'register_legallink' =>[
                        'name'=>'register_legallink',
                        'title' => __d('Predata', 'لینک متن قوانین و مقررات'),
                        'type'=>'text',
                        'class'=>'ltr',
                        'pholder'=>'https://',
                    ],
                    'register_backimg' =>[
                        'name'=>'register_backimg',
                        'title' => __d('Predata', 'تصویر پس زمینه صفحه ثبت نام'),
                        'type'=>'text',
                        'class'=>'ltr',
                        'pholder'=>'https://',
                    ],
                    'register_type' => [
                        'name'=>'register_type', //register_codemeli
                        'type'=>'select',
                        'options'=>[
                            'default' => __d('Predata', 'نام کاربری '), 
                            'codemeli' =>__d('Predata', 'کدملی'),
                            'mobile'=> __d('Predata', 'شماره موبایل')
                        ],
                        'title' => __d('Predata', 'نوع نام کاربری ثبت نام')
                    ],
                    'register_activation' => [
                        'name'=>'register_activation',
                        'type'=>'select',
                        'options'=>[
                            'none' => __d('Predata', 'پیش فرض تایید شود'),
                            'email' =>__d('Predata', 'ارسال ایمیل'),
                            'admin' =>__d('Predata', ' توسط مدیریت')
                        ],
                        'title' => 'تایید ثبت نام'
                    ],
                    'field_family' => [
                        'name'=>'field_family',
                        'type'=>'select',
                        'options'=>[
                            0 => __d('Predata', 'نمایش ندهد'), 
                            1 => __d('Predata', 'نمایش بدهد')
                        ],
                        'title' => __d('Predata', 'نمایش فیلد فامیلی در ثبت نام')
                    ],
                    'reg_expired_month' => [
                        'name'=>'login_expired_month',
                        'type'=>'number',
                        'title' => __d('Predata', 'تعداد روز انقضا پس از ثبت نام'). '( 0 = '.__d('Predata', 'نامحدود') .' )'
                    ],
                ];break;
            case 'user_field':
                return [
                    'UserMetas.phone' => [
                        'name'=>'phone',
                        'title' => __d('Predata', 'شماره تلفن'),
                        'type'=>'text',
                        'in_profile'=> false
                    ],
                ];break;
        }
    }
    public function preload(){
        FuncHelper::do_action('options_public', self::options('public'));
        FuncHelper::do_action('options_register', self::options('register'));
        //FuncHelper::do_action('options_registerform', self::options('register_form'));
        FuncHelper::do_action('options_userfield', self::options('user_field'));
    }
    public function routes(RouteBuilder $routes): void
    {
        $routes->plugin(
            'Predata',
            ['path' => '/admin/Predata/'],
            function (RouteBuilder $routes) {
                $routes->connect('/', ['controller' => 'Home']);
                $routes->fallbacks(DashedRoute::class);
            }
        );
        parent::routes($routes);
    }
    public function bootstrap(PluginApplicationInterface $app): void
    {
    }
    public function middleware(MiddlewareQueue $middlewareQueue): MiddlewareQueue
    {
        // Add your middlewares here
        return $middlewareQueue;
    }

    public function console(CommandCollection $commands): CommandCollection
    {
        // Add your commands here
        $commands = parent::console($commands);
        return $commands;
    }
    public function services(ContainerInterface $container): void
    {
    }

    public function activation(){}
    public function deactivation( $drop = false){}
    public function config(){
        return [
            'name'=>'Predata',
            //'show' => true,
            'title'=> __d('Predata', 'اطلاعات پیش فرض'),
            'icon'=>'fa fa-item',
            'description'=> __d('Predata', 'مدیریت اطلاعات پیش فرض سامانه'),
            'author'=>'Mahan',
            'version'=>'1.0',
            //'sys'=> true, 
            //system plugin
            'path' =>[
                'index' =>'',
                'admin' =>'',
                'setting' =>'',
            ]
        ];
    }
}
