<?php
namespace Ticketing;
use Cake\Core\BasePlugin;
use Admin\View\Helper\FuncHelper;
use Cake\Console\CommandCollection;
use Cake\Core\ContainerInterface;
use Cake\Http\MiddlewareQueue;
use Cake\Routing\RouteBuilder;

class Plugin extends BasePlugin {
    public $name= 'Ticketing';
    public function options($type = null){
        switch ($type) {
            case 'register':
            case 'register_form':
        }
    }
    public function sidemenu(){
        return [
            [
                'title'=>'سامانه تیکت',
                'link'=>[
                    'plugin'=>'ticketing',
                    'controller'=>'tickets',
                    'action'=>'index'],
                'has_sub'=>true, 
                'icon'=> 'message-circle', 
                'show_in_menu'=>true,
                'sub_menu'=>[
                    [
                        'title'=>'لیست تیکت ها',
                        'link'=>'/admin/ticketing/tickets/index/',
                        'has_sub'=>false, 'icon'=>true, 'show_in_menu'=>true,
                    ],[
                        'title'=>'افزودن تیکت',
                        'link'=>'/admin/ticketing/tickets/add/',
                        'has_sub'=>false, 'icon'=>true, 'show_in_menu'=>true,
                    ],
                    [
                        'title'=>'لیست پاسخ ها',
                        'link'=>'/admin/ticketing/ticketcomments/index/',
                        'has_sub'=>false, 'icon'=>true, 'show_in_menu'=>true,
                    ],[
                        'title'=>'تنظیمات',
                        'link'=>'/admin/ticketing/setting/index/',
                        'has_sub'=>false, 'icon'=>true, 'show_in_menu'=>true,
                    ],
                ],
            ],
            [
            'title'=>'پیام های من',
            'link'=>[
                'plugin'=>'ticketing',
                'controller'=>'my',
                'action'=>'index'],
            'has_sub'=>true, 
            'icon'=> 'chevron-right', 
            'show_in_menu'=>true,
            'sub_menu'=>[
                [
                    'title'=>'پیام جدید',
                    'link'=>'/tickets/new',
                    'has_sub'=>false, 'icon'=>true, 'show_in_menu'=>true,
                ],

                [
                    'title'=>'پیام های من',
                    'link'=>'/tickets/index',
                    'has_sub'=>false, 'icon'=>true, 'show_in_menu'=>true,
                ],

                [
                    'title'=>'پیام های بسته شده',
                    'link'=>'/tickets/closed',
                    'has_sub'=>false, 'icon'=>true, 'show_in_menu'=>true,
                ],
            ],
        ],
        ];
    }
    function options_role(){
        return [
            'plugin' => self::config()['name'] ,
            'title' => self::config()['title'],
            'role'=> [
                'Tickets' => [
                    'title' => 'مدیریت تیکت',
                    'action' => [
                        'index'=>'لیست تیکت ها',
                        'comment'=>'پاسخ',
                        'add'=>'افزودن',
                        'delete'=>'حذف',
                    ]
                ],
                'Ticketstatuses' => [
                    'title' => 'مدیریت وضعیت تیکت',
                    'action' => [
                        'index'=>'لیست ',
                        'add'=>'افزودن',
                        'view'=>'مشاهده',
                        'edit'=>'ویرایش',
                        'delete'=>'حذف',
                    ]
                ],
                'Ticketpriorities' => [
                    'title' => 'اولویت تیکت',
                    'action' => [
                        'index'=>'صفحه اصلی',
                        'view'=>'مشاهده جزئیات',
                        'edit'=>'ویرایش',
                        'add'=>'افزودن',
                        'delete'=>'حذف',
                    ]
                ],
                'Ticketcomments' => [
                    'title' => 'پاسخ تیکت',
                    'action' => [
                        'index'=>'صفحه اصلی',
                        'view'=>'مشاهده جزئیات',
                        'edit'=>'ویرایش',
                        'add'=>'افزودن',
                        'delete'=>'حذف',
                        'close'=>'بستن تیکت',
                    ]
                ],
                'Ticketcategories' => [
                    'title' => 'دسته بندی تیکت',
                    'action' => [
                        'index'=>'صفحه اصلی',
                        'view'=>'مشاهده جزئیات',
                        'edit'=>'ویرایش',
                        'add'=>'افزودن',
                        'delete'=>'حذف',
                    ]
                ],
                'Setting' => [
                    'title' => 'تنظیمات تیکت',
                    'action' => [
                        'index'=>'صفحه اصلی',
                    ]
                ],
                'My' => [
                    'title' => 'تیکت های من',
                    'action' => [
                        'index'=>'صفحه اصلی',
                        'query' =>'استعلام',
                        'submit'=>'ثبت / پاسخ ',
                    ]
                ],
            ]
        ];
    }
    public function preload(){
        FuncHelper::do_action('admin_sidemenu', self::sidemenu());
        FuncHelper::do_action('options_role', self::options_role());
        //FuncHelper::do_action('options_register', self::options('register'));
        //FuncHelper::do_action('options_registerform', self::options('register_form'));
    }
    public function activation(){}
    public function deactivation($drop = false){}
    public function config(){
        return [
            'name'=>'Ticketing',
            'title'=>'مدیریت تیکت',
            'icon'=>'fa fa-item',
            'description'=>'',
            'author'=>'Mahan',
            'version'=>'1.0',
            'path' =>[
                'index' =>'',
                'admin' =>'',
                'setting' =>'/admin/ticketing/setting/index/',
                ]
        ];
    }
    public function routes(RouteBuilder $routes): void
    {
        $routes->plugin(
            'Admin',
            ['path' => '/admin'],
            function (RouteBuilder $routes) {
                $routes->connect('/', ['controller' => 'Dashboard', 'action' => 'index', 'home']);
                $routes->fallbacks(DashedRoute::class);
            }
        )
        ->plugin(
            'Admin',
            ['path' => '/savecomments'],
            function (RouteBuilder $routes) {
                $routes->connect('/', ['controller' => 'Comments', 'action' => 'save'])->setMethods(['POST']);
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
}
