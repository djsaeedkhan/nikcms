<?php
declare(strict_types=1);
namespace Admin;

use Cake\Core\BasePlugin;
use Cake\Core\PluginApplicationInterface;
use Admin\Core\Shortcode;
use Admin\View\Helper\FuncHelper;

use Cake\Console\CommandCollection;
use Cake\Core\ContainerInterface;
use Cake\Http\MiddlewareQueue;
use Cake\Routing\Route\DashedRoute;
use Cake\Routing\RouteBuilder;
use Cake\View\View;
use Exception;

class Plugin extends BasePlugin
{
    public $name= 'Admin';
    public $FuncHelper;  
    function post_type(){
        return [
            'post'=>array(
                'title'=>true,
                'name'=>array(
                    'title'=>__d('Admin', 'نوشته'),
                    'index_header'=>__d('Admin', 'مدیریت نوشته'),
                    'index_add'=>__d('Admin', 'ثبت جدید'),
                    'single_add'=>__d('Admin', 'ثبت نوشته جدید'),
                    'single_edit'=>__d('Admin', 'ویرایش نوشته'),
                    'cat_header'=>__d('Admin', 'دسته بندی'),
                    'cat_add'=>__d('Admin', 'ثبت دسته جدید'),
                    'tag_header'=>__d('Admin', 'برچسب'),
                ),
                'editor'=>true,
                'excerpt'=>true,
                'author'=>true,
                'thumbnail'=>true,
                'comments'=>true,
                'tag'=>true,
                'category'=>true,
                'show_in_menu'=>true,
                'position'=>97,
            ),
            'page'=>array(
                'title'=>true,
                'name'=>array(
                    'title'=>__d('Admin', 'برگه'),
                    'index_header'=>__d('Admin', 'مدیریت برگه'),
                    'index_add'=>__d('Admin', 'ثبت جدید'),
                    'single_add'=>__d('Admin', 'ثبت برگه جدید'),
                    'single_edit'=>__d('Admin', 'ویرایش برگه'),
                    'cat_header'=>__d('Admin', 'دسته بندی'),
                    'cat_add'=>__d('Admin', 'ثبت برگه جدید'),
                    'tag_header'=>__d('Admin', 'برچسب'),
                ),
                'editor'=>true,
                'excerpt'=>true,
                'author'=>true,
                'thumbnail'=>true,
                'comments'=>true,
                'tag'=>true,
                'category'=>true,
                'show_in_menu'=>true,
                'position' => 98,
            ),
            'media'=>array(
                'title'=>true,
                'name'=>array(
                    'title'=>__d('Admin', 'برگه'),
                    'index_header'=>false,
                    'index_add'=>false,
                    'single_add'=>false,
                    'single_edit'=>false,
                    'cat_header'=>__d('Admin', 'دسته بندی رسانه'),
                    'cat_add'=>__d('Admin', 'ثبت برگه جدید'),
                    'tag_header'=>false,
                ),
                'editor'=>false,
                'excerpt'=>false,
                'author'=>false,
                'thumbnail'=>false,
                'comments'=>false,
                'tag'=>false,
                'category'=>false,
                'show_in_menu'=>false,
                'position' => 99,
            )];
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
        $view = new View();
        $this->FuncHelper = new FuncHelper($view);
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

    function posttype_adminmenu(){
        $view = new View();
        $this->FuncHelper = new FuncHelper($view);
        if($this->FuncHelper->check_role(['plugin'=>'admin','controller'=>'posts','action'=>'index']) == false)
            return [];
        
        $menu = array();
        foreach(self::post_type() as $post_type => $value ){
            $data = [
                $value['position']=>[
                    'title'=>$value['name']['title'],
                    'post_type'=> $post_type,
                    'link'=>'#',
                    'has_sub'=>true,
                    'icon'=>'chevron-right',
                    'show_in_menu'=>$value['show_in_menu'],
                    'sub_menu'=>[
                        '0'=>[
                            'title'=>__d('Admin', 'صفحه نخست'),
                            'link'=>[
                                'plugin'=>'admin',
                                'controller'=>'dashboard',
                                'action'=>'index'],
                        ],
                    ],
                ],
            ];
            $data[$value['position']]['sub_menu'] = [
                '1'=>[
                    'title'=>$value['name']['title'],
                    'link'=>'/admin/Posts/index/?post_type='.$post_type,
                    'link'=>[
                        'plugin'=>'admin',
                        'controller'=>'Posts',
                        'action'=>'index',
                        '?'=>['post_type'=>$post_type]],
                ],
                '2'=>[
                    'title'=>$value['name']['single_add'],
                    'link'=>[
                        'plugin'=>'admin',
                        'controller'=>'Posts',
                        'action'=>'add',
                        '?'=>['post_type'=>$post_type]],
                ],
                '3'=>[
                    'title'=>$value['name']['cat_header'],
                    'link'=>[
                        'plugin'=>'admin',
                        'controller'=>'Categories',
                        'action'=>'index',
                        '?'=>['post_type'=>$post_type]],
                ],
                '4'=>[
                    'title'=>$value['name']['tag_header'],
                    'link'=>[
                        'plugin'=>'admin',
                        'controller'=>'Tags',
                        'action'=>'index',
                        '?'=>['post_type'=>$post_type]],
                ],
            ];
            $menu += $data;
        }
        return $menu;
    }
    function admin_navmenu(){
        return [
            ['Admin.Menu::post'=>'post'],
            ['Admin.Menu::post'=>'page'],
            ['Admin.Menu::category' => 'post']
        ];
    }
    function sidemenu(){
        $view = new View();
        $this->FuncHelper = new FuncHelper($view);

        $list = [
            '5'=> array(
                'title'=>__d('Admin', 'پیشخوان'),
                'link'=>[
                    'plugin'=>'admin',
                    'controller'=>'dashboard',
                    'action'=>'index'],
                'has_sub'=>true, 
                'icon'=> 'home', 
                'show_in_menu'=>true,
                'sub_menu'=>[
                    [
                        'title'=>__d('Admin', 'صفحه نخست'),
                        'link'=>[
                            'plugin'=>'admin',
                            'controller'=>'dashboard',
                            'action'=>'index'],
                        'has_sub'=>false, 'icon'=>true, 'show_in_menu'=>true,
                    ],

                    //removed 1404-06-03
                    /* [
                        'title'=>__d('Admin', 'بروز رسانی'),
                        'link'=>'/admin/dashboard/update/',
                        'has_sub'=>false, 'icon'=>true, 'show_in_menu'=>true,
                    ],*/
                    /*'2'=>[
                        'title'=>'راهنمای سامانه',
                        'link'=>'/admin/Dashboard/Help/',
                        'has_sub'=>false, 'icon'=>true, 'show_in_menu'=>false,
                    ], */
                    '3'=>[
                        'title'=>__d('Admin', 'درباره ما'),
                        'link'=>[
                            'plugin'=>'admin',
                            'controller'=>'dashboard',
                            'action'=>'about'],
                        'has_sub'=>false, 'icon'=>true, 'show_in_menu'=>true,
                    ],
                ],
            ),
            '25'=>array(
                'title'=>__d('Admin', 'رسانه ها'),
                'link'=>[
                    'plugin'=>'admin',
                    'controller'=>'medias',
                    'action'=>'index'],
                'has_sub'=>true, 
                'icon'=> 'upload',//'upload-cloud', 
                'show_in_menu'=>true,
                'sub_menu'=>[
                    [
                        'title'=>__d('Admin', 'همه رسانه ها'),
                        'link'=>[
                            'plugin'=>'admin',
                            'controller'=>'Medias',
                            'action'=>'index'],
                        'has_sub'=>false, 'icon'=>true, 'show_in_menu'=>true,
                    ],
                    [
                        'title'=>__d('Admin', 'افزودن رسانه'),
                        'link'=>[
                            'plugin'=>'admin',
                            'controller'=>'Medias',
                            'action'=>'add'],
                        'has_sub'=>false, 'icon'=>true, 'show_in_menu'=>true,
                    ],
                    [
                        'title'=>__d('Admin', 'دسته بندی'),
                        'link'=>[
                            'plugin'=>'admin',
                            'controller'=>'Categories',
                            'action'=>'index',
                            '?'=>['post_type'=>'media'] ],
                        'has_sub'=>false, 'icon'=>true, 'show_in_menu'=>true,
                    ],
                ],
            ),
            /* '30'=>array(
                'title'=>__d('Admin', 'دیدگاه ها'),
                'link'=>[
                    'plugin'=>'admin',
                    'controller'=>'comments',
                    'action'=>'index'],
                'has_sub'=>true, 
                'icon'=> 'message-square', 
                'show_in_menu'=>true,
                'sub_menu'=>[
                    '0'=>[
                        'title'=>__d('Admin', 'مدیریت دیدگاه ها'),
                        'link'=>[
                            'plugin'=>'admin',
                            'controller'=>'Comments',
                            'action'=>'index'],
                        'has_sub'=>false, 'icon'=>true, 'show_in_menu'=>true,
                    ],
                ],
            ), */
            '40'=>array(
                'title'=>__d('Admin', 'افزونه ها'),
                'link'=>[
                    'plugin'=>'admin',
                    'controller'=>'plugins',
                    'action'=>'index'],
                'has_sub'=>true, 
                'icon'=> 'package', 
                'show_in_menu'=>true,
                'sub_menu'=>[
                    [
                        'title'=>__d('Admin', 'مدیریت افزونه ها'),
                        'link'=>[
                            'plugin'=>'admin',
                            'controller'=>'Plugins',
                            'action'=>'index'],
                        'has_sub'=>false, 'icon'=>true, 'show_in_menu'=>true,
                    ],
                ],
            ),
            '50'=>array(
                'title'=>__d('Admin', 'نمایش'),
                'link'=>[
                    'plugin'=>'admin',
                    'controller'=>'themes',
                    'action'=>'index'],
                'has_sub'=>true,
                'icon'=> 'sliders', 
                'show_in_menu'=>true,
                'sub_menu'=>[
                    [
                        'title'=>__d('Admin', 'پوسته ها'),
                        'link'=>[
                            'plugin'=>'admin',
                            'controller'=>'themes',
                            'action'=>'index'],
                        'has_sub'=>false, 'icon'=>true, 'show_in_menu'=>true,
                    ],[
                        'title'=>__d('Admin', 'تنظیمات پوسته'),
                        'link'=>[
                            'plugin'=>'admin',
                            'controller'=>'themes',
                            'action'=>'template'],
                        'has_sub'=>false, 'icon'=>true, 'show_in_menu'=>true,
                    ],[
                        'title'=>__d('Admin', 'فهرست ها '),
                        'link'=>[
                            'plugin'=>'admin',
                            'controller'=>'themes',
                            'action'=>'menu'],
                        'has_sub'=>false, 'icon'=>true, 'show_in_menu'=>true,
                    ],[
                        'title'=>__d('Admin', 'ابزارک ها'),
                        'link'=>[
                            'plugin'=>'widget',
                            'controller'=>'home',
                            'action'=>'index' ],
                        'has_sub'=>false, 'icon'=>true, 'show_in_menu'=>true,
                    ],
                ],
            ),
            '60'=>array(
                'title'=>__d('Admin', 'کاربران'),
                'link'=>[
                    'plugin'=>'admin',
                    'controller'=>'users',
                    'action'=>'index'],
                'has_sub'=>true, 
                'icon'=> 'users', 
                'show_in_menu'=>true,
                'sub_menu'=>[
                    [
                        'title'=>__d('Admin', 'لیست کاربران'),
                        'link'=>[
                            'plugin'=>'admin',
                            'controller'=>'users',
                            'action'=>'index'],
                        'has_sub'=>false, 'icon'=>true, 'show_in_menu'=>true,
                    ],[
                        'title'=>__d('Admin', 'افزودن کاربر'),
                        'link'=>[
                            'plugin'=>'admin',
                            'controller'=>'users',
                            'action'=>'add'],
                        'has_sub'=>false,
                        'icon'=>true,
                        'show_in_menu'=>true,
                    ],[
                        'title'=>__d('Admin', 'مدیریت دسترسی'),
                        'link'=>[
                            'plugin'=>'role',
                            'controller'=>'home',
                            'action'=>'index'],
                        'has_sub'=>false,
                        'icon'=>true,
                        'show_in_menu'=>true,
                    ],[
                        'title'=>__d('Admin', 'پروفایل شما'),
                        'link'=>[
                            'plugin'=>'admin',
                            'controller'=>'users',
                            'action'=>'profile'],
                        'has_sub'=>false, 'icon'=>true, 'show_in_menu'=>true,
                    ],
                ],
            ),
            '70'=>array(
                'title'=>__d('Admin', 'تنظیمات'),
                'link'=>[
                    'plugin'=>'admin',
                    'controller'=>'options',
                    'action'=>'index'],
                'after'=>'<hr>',
                'has_sub'=>true, 
                'icon'=> 'settings', 
                'show_in_menu'=>true,
                'sub_menu'=>[
                    [
                        'title'=>__d('Admin', 'عمومی'),
                        'link'=>[
                            'plugin'=>'admin',
                            'controller'=>'Options',
                            'action'=>'index'],
                        'has_sub'=>false, 'icon'=>true, 'show_in_menu'=>true,
                    ],[
                        'title'=>__d('Admin', 'خواندن'),
                        'link'=>[
                            'plugin'=>'admin',
                            'controller'=>'Options',
                            'action'=>'reading'],
                        'has_sub'=>false, 'icon'=>true, 'show_in_menu'=>true,
                    ],
                    /* [
                        'title'=>'کاربران',
                        'link'=>[
                            'plugin'=>'admin',
                            'controller'=>'Options',
                            'action'=>'users'],
                        'has_sub'=>false, 'icon'=>true, 'show_in_menu'=>true,
                    ], */[
                        'title'=>__d('Admin', 'زبان'),
                        'link'=>[
                            'plugin'=>'admin',
                            'controller'=>'Options',
                            'action'=>'language'],
                        'has_sub'=>false, 'icon'=>true, 'show_in_menu'=>true,
                    ],[
                        'title'=>__d('Admin', 'رسانه'),
                        'link'=>[
                            'plugin'=>'admin',
                            'controller'=>'Options',
                            'action'=>'media'],
                        'has_sub'=>false, 'icon'=>true, 'show_in_menu'=>true,
                    ],[
                        'title'=>__d('Admin', 'ورود / ثبت نام'),
                        'link'=>[
                            'plugin'=>'admin',
                            'controller'=>'Options',
                            'action'=>'register'],
                        'has_sub'=>false, 'icon'=>true, 'show_in_menu'=>true,
                    ],
                ],
            )];

        if(($tmp = $this->FuncHelper->OptionGet('plugin_favorite_list')) != ''){
            $available = $this->FuncHelper->plugin_available();
            if(($tmp = unserialize($tmp))){
                $i=1;
                asort($tmp);
                foreach(($tmp) as $tp){
                    if(in_array($tp,$available)){
                        $list[40]['sub_menu'][$i] = [
                            'title'=>$tp,
                            'link'=>[
                                'plugin'=>'admin',
                                'controller'=>$tp,
                                'action'=>'index'
                            ],
                            'has_sub'=>false, 'icon'=>false, 'show_in_menu'=>true,
                        ];
                        $i++;
                    }
               }
           }
        }
        return $list;
    }
    function shortcode($do = null){
        return [
            'member'=>[
                'name'=>'show member data',
                'function'=>'member_func',
            ],
        ];
    }
    function post_widget( $menu_type = 'post'){
        switch ($menu_type) {
            case 'cronjobs':
                return [
                    [
                        'name'=>'user_alert_10day',
                        'title' =>'پیامک اطلاع رسانی به کاربر،10روز مانده تا انقضا',
                        'widget' =>'Admin.Cronjobs::user_alert_10day',
                        'plugin' =>'Admin',
                        'order'=>'hight2',
                        'every'=>'24 hours'
                    ],
                    [
                        'name'=>'user_alert_0day',
                        'title' =>'پیامک منقضی شدن پنل کاربر',
                        'widget' =>'Admin.Cronjobs::user_alert_0day',
                        'plugin' =>'Admin',
                        'order'=>'hight2',
                        'every'=>'24 hours'
                    ],
                ];
                break;
            case 'dashboard':
                return [
                    ['name'=>'ad_lastpost', 'title' =>'آخرین پست های منتشر شده', 'widget' =>'Admin.Lastpost','col'=> 6 ,'order'=>'hight'],
                    ['name'=>'ad_published', 'title' =>'پیش نویس سریع نوشته', 'widget' =>'Admin.Published','col'=> 6 ,'order'=>'hight']
                ];
                break;
            case 'sidebar':
                return [
                    //['name'=>'', 'title' =>''],
                ]; break;
            case 'widget':
                return [
                    ['name'=>'menusaz', 'title' =>'منو ساز', 'widget' =>'Admin.WgtMenu','desc'=>''],
                    ['name'=>'simpla_html', 'title' =>'HTML ساده', 'widget' =>'Admin.WgtHtml','desc'=>''],
                ]; break;
            case 'category':
                return []; break;
            default: //post
                return [
                    //['events' => 'Nokhbe.Meta::events' ],
                ]; break;
        }
    }
    function options_role(){
        return [
            'plugin' => self::config()['name'] ,
            'title' => self::config()['title'] ,
            'role'=> [
                'dashboard'=> [
                    'title'=>'پیشخوان',
                    'action'=> [
                            'index'=>'صفحه نخست',
                            //'update'=>'به روز رسانی', //removed 1404-06-03
                            'help'=>'راهنمای سایت',
                            'about'=>'درباره ما',
                        ]
                    ],
                'Posts'=> [
                    'title'=>'مدیریت مطالب',
                    'action'=> [
                            'index'=>'لیست مطالب',
                            'add'=>'جدید',
                            'view'=>'نمایش',
                            'edit'=>'ویرایش',
                            'delete'=>'حذف',
                        ]
                    ],
                'Categories'=> [
                    'title'=>'مدیریت دسته بندی',
                    'action'=> [
                            'index'=>'لیست دسته',
                            'add'=>'جدید',
                            'view'=>'نمایش',
                            'edit'=>'ویرایش',
                            'delete'=>'حذف',
                        ]
                    ],
                'Comments'=> [
                    'title'=>'مدیریت دیدگاه',
                    'action'=> [
                            'index'=>'لیست دیدگاه',
                            //'add'=>'جدید',
                            //'view'=>'نمایش',
                            'edit'=>'ویرایش',
                            'delete'=>'حذف',
                            'reply'=>'پاسخ',
                            'approve'=>'تایید',
                        ]
                    ],
                'Medias'=> [
                    'title'=>'مدیریت رسانه',
                    'action'=> [
                            'index'=>'لیست رسانه',
                            'category'=>'دسته بندی رسانه',
                            'add'=>'آپلودجدید',
                            'add2'=>'آپلود دستی',
                            'ajaxadd'=>'- آپلود آیجکسی',
                            'gallery'=>'- آپلود تصویر در نوشته',
                            'view'=>'نمایش',
                            'edit'=>'ویرایش',
                            'delete'=>'حذف',
                        ]
                    ],
                'Options'=> [
                    'title'=>'مدیریت تنظیمات',
                    'action'=> [
                            'index'=>'تنظیمات همگانی',
                            'language'=>'زبان',
                            'reading'=>'خواندن',
                            'media'=>'چندرسانه ای',
                            'users'=>'کاربران',
                            'register'=>'ثبت نام / ورود',
                            'savesetting'=>'- ذخیره تنظیمات',
                            'savesetting2'=>'- ذخیره تنظیمات2',
                            'deletesetting'=>'- حذف تنظیمات',
                        ]
                    ],
                'Plugins'=> [
                    'title'=>'مدیریت افزونه',
                    'action'=> [
                            'index'=>'لیست افزونه',
                            'execute'=>'بروزرسانی دیتابیس ها',
                            //'add'=>'جدید',
                            //'view'=>'نمایش',
                            //'edit'=>'ویرایش',
                            //'delete'=>'حذف',
                            'enable'=>'فعال / غیرفعال',
                        ]
                    ],
                'Tags'=> [
                    'title'=>'مدیریت برچسب',
                    'action'=> [
                            'index'=>'لیست برچسب',
                            'view'=>'نمایش',
                            'add'=>'جدید',
                            'edit'=>'ویرایش',
                            'delete'=>'حذف',
                        ]
                    ],
               'Themes'=> [
                    'title'=>'مدیریت قالب',
                    'action'=> [
                            'index'=>'پوسته ها',
                            'template'=>'تنظیمات پوسته',
                            'menu'=>'فهرست ها',
                        ]
                    ], 
                'Users'=> [
                    'title'=>'مدیریت کاربران',
                    'action'=> [
                            'index'=>'لیست کاربران',
                            'view'=>'نمایش',
                            'profile'=>'پروفایل',
                            'add'=>'جدید',
                            'edit'=>'ویرایش',
                            'delete'=>'حذف کاربر'
                        ]
                    ], 
            ]
        ];
    }
    public function do_shortcode($plg , $act , $prm , $vlu){
        $data = '';
        $shortcode = $this->shortcode();
        if(isset($shortcode[$act])){
            $func = $shortcode[$act]['function'];
            $data = Shortcode::$func($act , $prm, $vlu);
        }
        return $data;
    }
    public function preload(){
        try {
            FuncHelper::do_action('post_type', self::post_type());
            FuncHelper::do_action('admin_sidemenu', self::sidemenu() + self::posttype_adminmenu() );
            FuncHelper::do_action('admin_navmenu', self::admin_navmenu());
            FuncHelper::do_action('admin_dashboard', self::post_widget('dashboard'));
            FuncHelper::do_action('options_role', self::options_role());
            FuncHelper::do_action('register_widgets', self::post_widget('widget'));
            FuncHelper::do_action('register_cronjobs', self::post_widget('cronjobs'));
        } catch (\Throwable $th) {
            die("Admin Plugin Errored");
            
        }
    }
    public function activation(){
        $conn = \Cake\Datasource\ConnectionManager::get('default');
        $conn->enableQueryLogging(false);
        $conn->begin();
        
        try{
            $conn->execute("ALTER TABLE `posts` ADD `priority` INT NULL DEFAULT NULL AFTER `post_type`;");
        }catch(Exception $e){}

        $conn->commit();
    }
    public function deactivation( $drop = false){}
    public function config(){
        return [
            'name'=>'Admin',
            'title'=>'مدیریت محتوا سامانه',
            'icon'=>'fa fa-item',
            'description'=>'مدیریت نوشته، رسانه، قالب',
            'author'=>'Mahan',
            'version'=>'1.0',
            //'sys'=> true, //system plugin (system plugin can`t enable or disable)
            'path' => [
                'index' =>'/admin/',
                'admin' =>'/admin/',
                'setting' =>'/admin/Options/index/',
            ],
            'image_size'=> [    //(options: exact, portrait, landscape, auto, crop)
                'thumbnail'=>['width'=>'150','height'=>'150','mode'=>'crop'],
                'medium'=>['width'=>'300','height'=>'300','mode'=>'crop'],
            ]
        ];
    }
}