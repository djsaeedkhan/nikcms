<?php
namespace Challenge;

use Admin\View\Helper\FuncHelper;
use Cake\Core\BasePlugin;
use Cake\Console\CommandCollection;
use Cake\Core\ContainerInterface;
use Cake\Core\PluginApplicationInterface;
use Cake\Http\MiddlewareQueue;
use Cake\Routing\Route\DashedRoute;
use Cake\Routing\RouteBuilder;
class Plugin extends BasePlugin{
    public $name= 'Challenge';
    function post_type(){
        return [
            'chnews'=>array(
                'name'=>array(
                    'title'=>'اخبار '.__d('Template', 'همیاری').'',
                    'index_header'=>'خبرها','index_add'=>'ثبت جدید',
                    'single_add'=>'ثبت اطلاعات جدید','single_edit'=>'ویرایش اطلاعات',
                    'cat_header'=>'دسته بندی اطلاعات','cat_add'=>'ثبت دسته اطلاعات',
                    'tag_header'=>'برچسب',
                ),
                'title'=>true,'editor'=>true,'excerpt'=>false,'author'=>true,'thumbnail'=>true,
                'comments'=>false,'tag'=>false,'category'=>false,'show_in_menu'=>false,
                'position'=>1001,
            ),
            'chresource'=>array(
                'name'=>array(
                    'title'=>'منابع '.__d('Template', 'همیاری').'',
                    'index_header'=>'منابع '.__d('Template', 'همیاری').'','index_add'=>'ثبت جدید',
                    'single_add'=>'ثبت اطلاعات جدید','single_edit'=>'ویرایش اطلاعات',
                    'cat_header'=>'دسته بندی اطلاعات','cat_add'=>'ثبت دسته اطلاعات',
                    'tag_header'=>'برچسب',
                ),
                'title'=>true,'editor'=>true,'excerpt'=>false,'author'=>true,'thumbnail'=>true,
                'comments'=>false,'tag'=>false,'category'=>false,'show_in_menu'=>false,
                'position'=>1002,
            ),
            'chupdates'=>array(
                'name'=>array(
                    'title'=>'آپدیت های '.__d('Template', 'همیاری').'',
                    'index_header'=>'آپدیت '.__d('Template', 'همیاری').'','index_add'=>'ثبت جدید',
                    'single_add'=>'ثبت اطلاعات جدید','single_edit'=>'ویرایش اطلاعات',
                    'cat_header'=>'دسته بندی اطلاعات','cat_add'=>'ثبت دسته اطلاعات',
                    'tag_header'=>'برچسب',
                ),
                'title'=>true,'editor'=>true,'excerpt'=>false,'author'=>true,'thumbnail'=>true,
                'comments'=>false,'tag'=>false,'category'=>false,'show_in_menu'=>false,
                'position'=>1003,
            ),
        ];
    }
    public function sidemenu(){
        return [
            [
                'title'=>'افزونه '.__d('Template', 'همیاری').'',
                'link'=>[
                    'plugin'=>'Challenge',
                    'controller'=>'admin',
                    'action'=>'index'],
                'has_sub'=>true, 
                'icon'=> 'chevron-right', 
                'show_in_menu'=>true,
                'sub_menu'=>[
                    [
                        'title'=>'لیست '.__d('Template', 'همیاری').'',
                        'link'=>'/admin/challenge/admin/index/',
                        'has_sub'=>false, 'icon'=>true, 'show_in_menu'=>true,
                    ],
                    [
                        'title'=>'افزودن '.__d('Template', 'همیاری').' جدید',
                        'link'=>'/admin/challenge/admin/add/',
                        'has_sub'=>false, 'icon'=>true, 'show_in_menu'=>true,
                    ],
                    [
                        'title'=>'مدیریت برچسب ها',
                        'link'=>'/admin/challenge/challengetags/',
                        'has_sub'=>false, 'icon'=>true, 'show_in_menu'=>true,
                    ],
                    [
                        'title'=>'مدیریت سطوح '.__d('Template', 'همیاری').'',
                        'link'=>'/admin/challenge/challengecats/',
                        'has_sub'=>false, 'icon'=>true, 'show_in_menu'=>true,
                    ],
                    [
                        'title'=>'مدیریت موضوع ها',
                        'link'=>'/admin/challenge/challengetopics/',
                        'has_sub'=>false, 'icon'=>true, 'show_in_menu'=>true,
                    ],
                    [
                        'title'=>'مدیریت حوزه ماموریت',
                        'link'=>'/admin/challenge/challengefields/',
                        'has_sub'=>false, 'icon'=>true, 'show_in_menu'=>true,
                    ],
                    [
                        'title'=>'مدیریت کاربران',
                        'link'=>'/admin/challenge/challengeusers/index/',
                        'has_sub'=>false, 'icon'=>true, 'show_in_menu'=>true,
                    ],
                    [
                        'title'=>'لیست مشارکت ها',
                        'link'=>'/admin/challenge/challengeuserforms/index/',
                        'has_sub'=>false, 'icon'=>true, 'show_in_menu'=>true,
                    ],
                    [
                        'title'=>'تبادل نظر ها',
                        'link'=>'/admin/challenge/challengeforums/index/?action=unapproved',
                        'has_sub'=>false, 'icon'=>true, 'show_in_menu'=>true,
                    ],
                    [
                        'title'=>'تنظیمات',
                        'link'=>'/admin/challenge/setting/index',
                        'has_sub'=>false, 'icon'=>true, 'show_in_menu'=>true,
                    ],
                ],
            ]
        ];
    }
    function post_widget( $menu_type = 'post'){
        switch ($menu_type) {
            case 'dashboard':
                return [
                    [
                        'name'=>'ch_amar',
                        'title' =>'آمار '.__d('Template', 'همیاری').' ',
                        'widget' =>'Challenge.Home::dashboard',
                        'order'=>'hight2'
                    ],
                ];
                break;
            default:
                return [
                    ['chnews' => 'Challenge.Meta::chnews'],
                    ['chresource' => 'Challenge.Meta::chresource'],
                    ['chupdates' => 'Challenge.Meta::chupdates'],
                ]; break;
        }
    }
    function options_role(){
        return [
            'plugin' => self::config()['name'] ,
            'title' => self::config()['title'],
            'role'=> [
                'Admin' => [
                    'title' => ''.__d('Template', 'همیاری').'',
                    'action' => [
                        'index'=>'صفحه اصلی','add'=>'افزودن','edit'=>'ویرایش','delete'=>'حذف','view'=>'جزئیات','report'=>'لیست گزارش ها'
                    ]
                ],
                /* 'Api' => [
                    'title' => 'درخواست API',
                    'action' => [
                        'index'=>'صفحه درخواست',
                    ]
                ], */
                'Challengecats' => [
                    'title' => 'سطوح '.__d('Template', 'همیاری').'',
                    'action' => [
                        'index'=>'صفحه اصلی','add'=>'افزودن','edit'=>'ویرایش','delete'=>'حذف',
                    ]
                ],
                'Challengequests' => [
                    'title' => 'سوالات '.__d('Template', 'همیاری').'',
                    'action' => [
                        'index'=>'صفحه اصلی','add'=>'افزودن','edit'=>'ویرایش','delete'=>'حذف',
                        'report'=>'آمار پاسخ ها',
                    ]
                ],
                'Challengefields' => [
                    'title' => 'حوزه ماموریت',
                    'action' => [
                        'index'=>'صفحه اصلی','add'=>'افزودن','edit'=>'ویرایش','delete'=>'حذف',
                    ]
                ],
                'Challengeforums' => [
                    'title' => 'اطلاعات فروم',
                    'action' => [
                        'index'=>'صفحه اصلی','add'=>'افزودن','edit'=>'ویرایش','delete'=>'حذف','approve'=>'تایید'
                    ]
                ],
                'Challengeforumtitles' => [
                    'title' => 'عناوین فروم',
                    'action' => [
                        'index'=>'صفحه اصلی','add'=>'افزودن','edit'=>'ویرایش','delete'=>'حذف',
                    ]
                ],
                'Challengeimages' => [
                    'title' => 'تصاویر '.__d('Template', 'همیاری').'',
                    'action' => [
                        'index'=>'صفحه اصلی','add'=>'افزودن','edit'=>'ویرایش','delete'=>'حذف',
                    ]
                ],
                'Challengepartners' => [
                    'title' => 'همکاران '.__d('Template', 'همیاری').'',
                    'action' => [
                        'index'=>'صفحه اصلی','add'=>'افزودن','edit'=>'ویرایش','delete'=>'حذف',
                    ]
                ],
                'Challengetags' => [
                    'title' => 'مدیریت برچسب ها',
                    'action' => [
                        'index'=>'صفحه اصلی','add'=>'افزودن','edit'=>'ویرایش','delete'=>'حذف',
                    ]
                ],
                'Challengetexts' => [
                    'title' => 'شرح موضوع',
                    'action' => [
                        'index'=>'صفحه اصلی','add'=>'افزودن','edit'=>'ویرایش','delete'=>'حذف',
                    ]
                ],
                'Challengetimelines' => [
                    'title' => 'زمانبندی',
                    'action' => [
                        'index'=>'صفحه اصلی','add'=>'افزودن','edit'=>'ویرایش','delete'=>'حذف',
                    ]
                ],
                'Challengerelateds' => [
                    'title' => ''.__d('Template', 'همیاری').' مرتبط',
                    'action' => [
                        'add'=>'افزودن','edit'=>'ویرایش','delete'=>'حذف',
                    ]
                ],
                'Challengetopics' => [
                    'title' => 'مدیریت موضوع ها',
                    'action' => [
                        'index'=>'صفحه اصلی','add'=>'افزودن','edit'=>'ویرایش','delete'=>'حذف',
                    ]
                ],
                'Challengeuserforms' => [
                    'title' => 'مشارکت کاربران',
                    'action' => [
                        'index'=>'صفحه اصلی','add'=>'افزودن','edit'=>'ویرایش','delete'=>'حذف','view'=>'جزئیات',
                    ]
                ],
                'Challengeusers' => [
                    'title' => ' کاربران',
                    'action' => [
                        'index'=>'صفحه اصلی','add'=>'افزودن','edit'=>'ویرایش','delete'=>'حذف','view'=>'جزئیات',
                    ]
                ],
                'Setting' => [
                    'title' => 'تنظیمات',
                    'action' => [
                        'index'=>'صفحه تنظیمات',
                    ]
                ],
            ]
        ];
    }
    public function preload(){
        FuncHelper::do_action('admin_dashboard', self::post_widget('dashboard'));
        FuncHelper::do_action('post_type',self::post_type());
        FuncHelper::do_action('admin_sidemenu', self::sidemenu());
        FuncHelper::do_action('admin_postwidget', self::post_widget('post'));

        FuncHelper::do_action('options_role', self::options_role());
        define('challenge_title',''.__d('Template', 'همیاری').'');
    }
    public function activation()
    {
        $conn = \Cake\Datasource\ConnectionManager::get('default');
        $conn->execute("
        -- Table structure for table `challengeblueticks`
        CREATE TABLE IF NOT EXISTS `challengeblueticks` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `user_id` int(11) NOT NULL,
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        -- --------------------------------------------------------
        -- Table structure for table `challengecats`
        CREATE TABLE IF NOT EXISTS `challengecats` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `title` varchar(100) NOT NULL,
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        -- --------------------------------------------------------
        -- Table structure for table `challengefields`
        CREATE TABLE IF NOT EXISTS `challengefields` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `title` varchar(100) NOT NULL,
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        -- --------------------------------------------------------
        -- Table structure for table `challengefollowers`
        CREATE TABLE IF NOT EXISTS `challengefollowers` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `challenge_id` int(11) NOT NULL,
          `user_id` int(11) NOT NULL,
          `created` date NOT NULL,
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        -- --------------------------------------------------------
        -- Table structure for table `challengeforums`
        CREATE TABLE IF NOT EXISTS `challengeforums` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `challenge_id` int(11) NOT NULL,
          `challengeforumtitle_id` int(11) NOT NULL,
          `lft` int(11) DEFAULT NULL,
          `rght` int(11) DEFAULT NULL,
          `user_id` int(11) NOT NULL,
          `text` text NOT NULL,
          `enable` tinyint(1) NOT NULL DEFAULT '0',
          `created` datetime NOT NULL,
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        -- --------------------------------------------------------
        -- Table structure for table `challengeforumtitles`
        CREATE TABLE IF NOT EXISTS `challengeforumtitles` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `challenge_id` int(11) NOT NULL,
          `title` varchar(100) NOT NULL,
          `descr` text,
          `priority` tinyint(4) NOT NULL DEFAULT '1',
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        -- --------------------------------------------------------
        -- Table structure for table `challengeimages`
        CREATE TABLE IF NOT EXISTS `challengeimages` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `challenge_id` int(11) NOT NULL,
          `title` varchar(100) DEFAULT NULL,
          `src` varchar(200) NOT NULL,
          `types` tinyint(4) DEFAULT '1',
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        -- --------------------------------------------------------
        -- Table structure for table `challengemetas`
        CREATE TABLE IF NOT EXISTS `challengemetas` (
          `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
          `challenge_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
          `meta_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
          `meta_key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
          `meta_value` longtext COLLATE utf8mb4_unicode_ci,
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        -- --------------------------------------------------------
        -- Table structure for table `challengepartners`
        CREATE TABLE IF NOT EXISTS `challengepartners` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `challenge_id` int(11) NOT NULL,
          `title` varchar(100) DEFAULT NULL,
          `link` text,
          `image` text,
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        -- --------------------------------------------------------
        -- Table structure for table `challengerelateds`
        CREATE TABLE IF NOT EXISTS `challengerelateds` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `challenge_id` int(11) NOT NULL,
          `challenges_id` int(11) NOT NULL,
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        -- --------------------------------------------------------
        -- Table structure for table `challenges`
        CREATE TABLE IF NOT EXISTS `challenges` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `title` varchar(200) NOT NULL,
          `slug` varchar(200) NOT NULL,
          `descr` varchar(500) DEFAULT NULL,
          `img` varchar(200) DEFAULT NULL,
          `img1` varchar(200) DEFAULT NULL,
          `img2` varchar(200) DEFAULT NULL,
          `challengestatus_id` tinyint(4) NOT NULL,
          `start_date` varchar(12) DEFAULT NULL,
          `end_date` varchar(12) DEFAULT NULL,
          `user_id` int(11) DEFAULT NULL,
          `enable` tinyint(1) NOT NULL DEFAULT '1',
          `price` varchar(50) NOT NULL,
          `created` datetime NOT NULL,
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        -- --------------------------------------------------------
        -- Table structure for table `challengestatuses`
        CREATE TABLE IF NOT EXISTS `challengestatuses` (
          `id` tinyint(4) NOT NULL AUTO_INCREMENT,
          `title` varchar(100) NOT NULL,
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        -- --------------------------------------------------------
        -- Table structure for table `challenges_challengecats`
        CREATE TABLE IF NOT EXISTS `challenges_challengecats` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `challenge_id` int(11) NOT NULL,
          `challengecat_id` int(11) NOT NULL,
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        -- --------------------------------------------------------
        -- Table structure for table `challenges_challengefields`
        CREATE TABLE IF NOT EXISTS `challenges_challengefields` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `challenge_id` int(11) NOT NULL,
          `challengefield_id` int(11) NOT NULL,
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        -- --------------------------------------------------------
        -- Table structure for table `challenges_challengetags`
        CREATE TABLE IF NOT EXISTS `challenges_challengetags` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `challenge_id` int(11) NOT NULL,
          `challengetag_id` int(11) NOT NULL,
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        -- --------------------------------------------------------
        -- Table structure for table `challenges_challengetopics`
        CREATE TABLE IF NOT EXISTS `challenges_challengetopics` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `challenge_id` int(11) NOT NULL,
          `challengetopic_id` int(11) NOT NULL,
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        -- --------------------------------------------------------
        -- Table structure for table `challengetags`
        CREATE TABLE IF NOT EXISTS `challengetags` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `title` varchar(100) NOT NULL,
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        -- --------------------------------------------------------
        -- Table structure for table `challengetags_users`
        CREATE TABLE IF NOT EXISTS `challengetags_users` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `user_id` int(11) NOT NULL,
          `challengetag_id` int(11) NOT NULL,
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        -- --------------------------------------------------------
        -- Table structure for table `challengetexts`
        CREATE TABLE IF NOT EXISTS `challengetexts` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `challenge_id` int(11) NOT NULL,
          `title` text NOT NULL,
          `types` tinyint(4) NOT NULL DEFAULT '1',
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        -- --------------------------------------------------------
        -- Table structure for table `challengetimelines`
        CREATE TABLE IF NOT EXISTS `challengetimelines` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `challenge_id` int(11) NOT NULL,
          `title` text NOT NULL,
          `types` tinyint(4) NOT NULL DEFAULT '1',
          `dates` datetime NOT NULL,
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        -- --------------------------------------------------------
        -- Table structure for table `challengetopics`
        CREATE TABLE IF NOT EXISTS `challengetopics` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `title` varchar(100) NOT NULL,
          `img` varchar(200) DEFAULT NULL,
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        -- --------------------------------------------------------
        -- Table structure for table `challengeuserforms`
        CREATE TABLE IF NOT EXISTS `challengeuserforms` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `challenge_id` int(11) NOT NULL,
          `user_id` int(11) NOT NULL,
          `userinfo` text,
          `filesrc` varchar(200) DEFAULT NULL,
          `filesrc2` varchar(200) DEFAULT NULL,
          `filesrc3` varchar(200) DEFAULT NULL,
          `title` varchar(200) DEFAULT NULL,
          `descr1` text,
          `descr2` text,
          `descr3` text,
          `descr4` text,
          `descr5` text,
          `descr6` text,
          `token1` varchar(20) DEFAULT NULL,
          `enable` tinyint(1) DEFAULT '1',
          `approved` tinyint(1) DEFAULT '0',
          `created` datetime NOT NULL,
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        -- --------------------------------------------------------
        -- Table structure for table `challengeuserprofiles`
        CREATE TABLE IF NOT EXISTS `challengeuserprofiles` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `user_id` int(11) NOT NULL,
          `gender` varchar(1) NOT NULL COMMENT 'm/f',
          `provice` tinyint(4) NOT NULL,
          `birth_date` smallint(6) DEFAULT NULL,
          `single` tinyint(3) NOT NULL DEFAULT '1' COMMENT 'single or groups',
          `eductions` tinyint(4) DEFAULT NULL,
          `email` varchar(30) DEFAULT NULL,
          `mobile` varchar(15) DEFAULT NULL,
          `center` tinyint(4) DEFAULT NULL,
          `center_name` varchar(100) DEFAULT NULL,
          `semat` varchar(100) DEFAULT NULL,
          `codemeli` varchar(15) DEFAULT NULL,
          `field` varchar(100) DEFAULT NULL,
          `univercity` varchar(100) DEFAULT NULL,
          `image` varchar(100) DEFAULT NULL,
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        ALTER TABLE `challengeuserprofiles` ADD `descr` VARCHAR(5000) NULL AFTER `univercity`;
        -- --------------------------------------------------------
        -- Table structure for table `challengeuserprofiles_challengetopics`
        CREATE TABLE IF NOT EXISTS `challengeuserprofiles_challengetopics` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `challengeuserprofile_id` int(11) NOT NULL,
          `challengetopic_id` int(11) NOT NULL,
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        -- --------------------------------------------------------
        -- Table structure for table `challengeviews`
        CREATE TABLE IF NOT EXISTS `challengeviews` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `challenge_id` int(11) NOT NULL,
          `views` int(11) NOT NULL,
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        COMMIT;
        
        ALTER TABLE `challengetopics` ADD `descr` TEXT NULL AFTER `img`;
        ");
    }

    public function routes(RouteBuilder $routes): void
    {
     
        $routes->plugin(
            'Challenge',
            ['path' => '/admin/challenge/'],
            function (RouteBuilder $routes) {
                $routes->connect('/', ['controller' => 'Admin']);
                $routes->fallbacks(DashedRoute::class);
            }
        )
        ->plugin(
            'Challenge',
            ['path' => '/challenge'],
            function (RouteBuilder $routes) {
                $routes->connect('/profile/*', ['controller' => 'Challenges','action'=>'profile']);
                $routes->connect('/:slug/', ['controller' => 'Challenges','action'=>'View']);
                //$routes->connect('/:slug/solution', ['controller' => 'Challenges','action'=>'solution']);
                $routes->connect('/:slug/:method', ['controller' => 'Challenges','action'=>'View']);
                $routes->connect('/follow/:slug/', ['controller' => 'Challenges','action'=>'follow']);
                $routes->connect('/', ['controller' => 'Challenges']);
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
    public function deactivation( $drop = false){}
    public function config(){
        return [
            'name'=>'Challenge',
            'title'=>'سامانه '.__d('Template', 'همیاری').'',
            'icon'=>'fa fa-item',
            'description'=>'مدیریت نسخه '.__d('Template', 'همیاری').'',
            'author'=>'Mahan',
            'version'=>'1.0',
            'path' =>[
                'index' =>'',
                'admin' =>'/admin/challenge/',
                'setting' =>'',
                ]
        ];
    }
}
