<?php
namespace Lms;
use Admin\View\Helper\FuncHelper;
use Cake\Core\BasePlugin;
use Exception;

class Plugin extends BasePlugin
{
    public $name= 'Lms';
    function post_type(){
        return [];
    }
    public function sidemenu(){
        return [
            [
                'title'=>'پیشخوان',
                'link'=>'/lms/client/index',
                'has_sub'=>true, 
                'icon'=> 'chevron-right', 
                'show_in_menu'=>true,
                'sub_menu'=>[],
                'position'=>1104,
            ],
            [
                'title'=>'ثبت نام',
                'link'=>'/lms/',
                'has_sub'=>false, 
                'icon'=> 'chevron-right', 
                'show_in_menu'=>true,
                'position'=>1105,
                'sub_menu'=>[
                    [
                        'title'=>'مشاهده ثبت نام',
                        'link'=>'/lms/',
                        'has_sub'=>false, 'icon'=>true, 'show_in_menu'=>true,
                    ],
                ],
            ],
            [
                'title'=>'سامانه آموزشی',
                'link'=>[
                    'plugin'=>'lms',
                    'controller'=>'courses',
                    'action'=>'index'],
                'has_sub'=>true, 
                'icon'=> 'layers', 
                'show_in_menu'=>true,
                'position'=>1106,
                'sub_menu'=>[
                    [
                        'title'=>'مدیریت دوره ها',
                        'link'=>'/admin/lms/courses/index/',
                        'has_sub'=>false, 'icon'=>true, 'show_in_menu'=>true,
                    ],
                    [
                        'title'=>'مدیریت آزمون ها',
                        'link'=>'/admin/lms/exams/index/',
                        'has_sub'=>false, 'icon'=>true, 'show_in_menu'=>true,
                    ],
                    [
                        'title'=>'نتایج آزمون ها',
                        'link'=>'/admin/lms/results/index/',
                        'has_sub'=>false, 'icon'=>true, 'show_in_menu'=>true,
                    ],
                    [
                        'title'=>'مدیریت فاکتور ها',
                        'link'=>'/admin/lms/factors/index/',
                        'has_sub'=>false, 'icon'=>true, 'show_in_menu'=>true,
                    ],
                    [
                        'title'=>'مدیریت پرداخت ها',
                        'link'=>'/admin/lms/payments/index/',
                        'has_sub'=>false, 'icon'=>true, 'show_in_menu'=>true,
                    ],
                    [
                        'title'=>'کوپن تخفیف',
                        'link'=>'/admin/lms/coupons/index/',
                        'has_sub'=>false, 'icon'=>true, 'show_in_menu'=>true,
                    ],
                    [
                        'title'=>'گواهینامه ها',
                        'link'=>'/admin/lms/certificates/index/',
                        'has_sub'=>false, 'icon'=>true, 'show_in_menu'=>true,
                    ],
                    [
                        'title'=>'مدیریت کاربران',
                        'link'=>'/admin/lms/user/index/',
                        'has_sub'=>false, 'icon'=>true, 'show_in_menu'=>true,
                    ],
                    [
                        'title'=>'تنظیمات',
                        'link'=>'/admin/lms/setting/index',
                        'has_sub'=>false, 'icon'=>true, 'show_in_menu'=>true,
                    ],
                ],
            ],
            [
                'title'=>'حساب من',
                'link'=>[
                    'plugin'=>'lms',
                    'controller'=>'client',
                    'action'=>'course'
                ],
                'has_sub'=>true, 
                'icon'=> 'trello', 
                'show_in_menu'=>true,
                'position'=>1107,
                'sub_menu'=>[
                    /* [
                        'title'=>'پیشخوان',
                        'link'=>'/lms/client/index',
                        'has_sub'=>false, 'icon'=>true, 'show_in_menu'=>true,
                    ], */
                    [
                        'title'=>' دوره ها',
                        'link'=>'/lms/client/course',
                        'has_sub'=>false, 'icon'=>true, 'show_in_menu'=>true,
                    ],
                    [
                        'title'=>'فاکتور ها',
                        'link'=>'/lms/client/factors',
                        'has_sub'=>false, 'icon'=>true, 'show_in_menu'=>true,
                    ],
                    [
                        'title'=>'پرداخت ها',
                        'link'=>'/lms/client/payments',
                        'has_sub'=>false, 'icon'=>true, 'show_in_menu'=>true,
                    ],
                    [
                        'title'=>'درخواست گواهینامه',
                        'link'=>'/page/govahi',
                        'has_sub'=>false, 'icon'=>true, 'show_in_menu'=>true,
                    ]
                    /*[
                        'title'=>'مشاهده آزمون ها',
                        'link'=>'/lms/client/myexams/',
                        'has_sub'=>false, 'icon'=>true, 'show_in_menu'=>true,
                    ],*/
                ],
            ],
        ];
    }
    function post_widget( $menu_type = 'post'){
        switch ($menu_type) {
            case 'cronjobs':
                return [
                    [
                        'name'=>'nofactor_newuser',
                        'title' =>'پیامک به کاربرانی که ثبت نام کرده ولی فاکتور نداشته اند',
                        'widget' =>'Lms.Cronjobs::nofactor_newuser',
                        'plugin' =>'Lms',
                        'order'=>'hight2',
                        'every'=>'24 hours'
                    ],
                    [
                        'name'=>'delete_unpaid_factor',
                        'title' =>'حذف فاکتور های پرداخت نشده پس از زمان مشخص شده',
                        'widget' =>'Lms.Cronjobs::delete_unpaid_factor',
                        'plugin' =>'Lms',
                        'order'=>'hight2',
                        'every'=>'24 hours'
                    ],
                    [
                        'name'=>'course_alert_60day',
                        'title' =>'پیامک اطلاع رسانی به کاربر،60روز مانده تا انقضا',
                        'widget' =>'Lms.Cronjobs::user_alert_60day',
                        'plugin' =>'Lms',
                        'order'=>'hight2',
                        'every'=>'24 hours'
                    ],
                    [
                        'name'=>'course_alert_30day',
                        'title' =>'پیامک اطلاع رسانی به کاربر،30روز مانده تا انقضا',
                        'widget' =>'Lms.Cronjobs::user_alert_30day',
                        'plugin' =>'Lms',
                        'order'=>'hight2',
                        'every'=>'24 hours'
                    ],
                    [
                        'name'=>'course_alert_10day',
                        'title' =>'پیامک اطلاع رسانی به کاربر،10روز مانده تا انقضا',
                        'widget' =>'Lms.Cronjobs::user_alert_10day',
                        'plugin' =>'Lms',
                        'order'=>'hight2',
                        'every'=>'24 hours'
                    ],
                    [
                        'name'=>'course_alert_0day',
                        'title' =>'پیامک منقضی شدن پنل کاربر',
                        'widget' =>'Lms.Cronjobs::user_alert_0day',
                        'plugin' =>'Lms',
                        'order'=>'hight2',
                        'every'=>'24 hours'
                    ],
                ];
                break;
            case 'dashboard':
                return [
                    [
                        'name'=>'lms_amar',
                        'title' =>'آمار سامانه آموزش مجازی',
                        'widget' =>'Lms.Home::user_dashboard',
                        'order'=>'hight2'
                    ],
                ];
                break;
            default:
                return [
                    //['chnews' => 'Challenge.Meta::chnews'],
                    //['chresource' => 'Challenge.Meta::chresource'],
                    //['chupdates' => 'Challenge.Meta::chupdates'],
                ]; break;
        }
    }
	public function options($type){
        switch ($type) {
            case 'user_field':
                return [
                    'UserMetas.educational_id' => ['name'=>'educational_id','title' => 'شناسه آموزشی', 'type'=>'text','in_profile'=> false],
                    'UserMetas.membership_type' => ['name'=>'membership_type','title' => 'نوع عضویت', 'type'=>'text','in_profile'=> false],
                ];
                break;
            /* case 'register_form':
                return [
                    'educational_id' => [
                        'name'=>'educational_id',
                        'type'=>'text',
                        'class'=>'ltr',
                        'title' => 'شناسه آموزشی',
                    ],
                    'membership_type' => [
                        'name'=>'membership_type',
                        'type'=>'text',
                        'class'=>'',
                        'title' => 'نوع عضویت',
                    ],
                ]; */
        }
    }
    function options_role(){
        return [
            'plugin' => self::config()['name'] ,
            'title' => self::config()['title'],
            'role'=> [
                'Home' => [
                    'title' => 'پیشخوان',
                    'action' => [
                        'index'=>'پیشخوان',
                    ]
                ],
                'Courseexams' => [
                    'title' => 'دوره - آزمون ها',
                    'action' => [
                        'index'=>'صفحه اصلی','add'=>'افزودن','edit'=>'ویرایش','delete'=>'حذف','view'=>'جزئیات',
                    ]
                ],
				'Coursefilenotes' => [
                    'title' => 'دوره - توضیحات فایل ها',
                    'action' => [
                        'index'=>'صفحه اصلی','add'=>'افزودن','edit'=>'ویرایش','delete'=>'حذف','view'=>'جزئیات , دیده شدن فایل',
                    ]
                ],
				'Coursefiles' => [
                    'title' => 'دوره - فایل ها',
                    'action' => [
                        'index'=>'صفحه اصلی','add'=>'افزودن','edit'=>'ویرایش','delete'=>'حذف','view'=>'جزئیات',
                    ]
                ],
				'Courserelateds' => [
                    'title' => 'دوره - دوره های مرتبط',
                    'action' => [
                        'index'=>'صفحه اصلی','add'=>'افزودن','edit'=>'ویرایش','delete'=>'حذف','view'=>'جزئیات',
                    ]
                ],
				'Courses' => [
                    'title' => 'دوره ها',
                    'action' => [
                        'index'=>'صفحه اصلی',
                        'add'=>'افزودن','edit'=>'ویرایش','delete'=>'حذف','view'=>'جزئیات',
                    ]
                ],
				'Courseusers' => [
                    'title' => 'دوره - کاربران دوره',
                    'action' => [
                        'index'=>'صفحه اصلی',
                        'add'=>'افزودن',
                        'view'=>'جزئیات',
                        'delete'=>'حذف',
                        'edit'=>'ویرایش',
                    ]
                ],
                'Coursecategories' => [
                    'title' => 'دوره - دسته بندی',
                    'action' => [
                        'index'=>'صفحه اصلی',
                        'add'=>'افزودن / ویرایش',
                        'view'=>'جزئیات',
                        'delete'=>'حذف',
                    ]
                ],
                'Certificates' => [
                    'title' => 'مدیریت گواهینامه',
                    'action' => [
                        'index'=>'صفحه اصلی',
                        'add'=>'افزودن',
                        'view'=>'جزئیات',
                        'delete'=>'حذف',
                        'edit'=>'ویرایش',
                    ]
                ],
				'Courseweeks' => [
                    'title' => 'دوره - مدیریت عناوین',
                    'action' => [
                        'index'=>'صفحه اصلی','add'=>'افزودن','edit'=>'ویرایش','delete'=>'حذف','view'=>'جزئیات',
                    ]
                ],
				'Examquests' => [
                    'title' => 'آزمون - سوالات',
                    'action' => [
                        'index'=>'صفحه اصلی','add'=>'افزودن','edit'=>'ویرایش','delete'=>'حذف','view'=>'جزئیات',
                    ]
                ],
				'Exams' => [
                    'title' => 'آزمون ها',
                    'action' => [
                        'index'=>'صفحه اصلی','add'=>'افزودن','duplicate'=>'کپی کردن','edit'=>'ویرایش','delete'=>'حذف','view'=>'جزئیات',
                    ]
                ],
                'Factors' => [
                    'title' => 'فاکتورها',
                    'action' => [
                        'index'=>'صفحه اصلی','add'=>'افزودن','edit'=>'ویرایش','delete'=>'حذف','view'=>'جزئیات',
                    ]
                ],
                'Coupons' => [
                    'title' => 'کوپن تخفیف',
                    'action' => [
                        'index'=>'صفحه اصلی','add'=>'افزودن','edit'=>'ویرایش','delete'=>'حذف','view'=>'جزئیات',
                    ]
                ],
                'Payments' => [
                    'title' => 'پرداخت ها',
                    'action' => [
                        'index'=>'صفحه اصلی','add'=>'افزودن','edit'=>'ویرایش','delete'=>'حذف','view'=>'جزئیات',
                    ]
                ],
				'Examusers' => [
                    'title' => 'آزمون - کاربران',
                    'action' => [
                        'index'=>'صفحه اصلی','add'=>'افزودن','edit'=>'ویرایش','delete'=>'حذف','view'=>'جزئیات',
                    ]
                ],
				'Results' => [
                    'title' => 'امتحانات - نتایج',
                    'action' => [
                        'index'=>'صفحه اصلی','add'=>'افزودن','edit'=>'ویرایش آزمون','editq'=>'ویرایش نتایج سوالات','delete'=>'حذف','view'=>'جزئیات',
                    ]
                ],
				'User' => [
                    'title' => 'مدیریت کاربران',
                    'action' => [
                        'index'=>'صفحه اصلی','add'=>'افزودن','edit'=>'ویرایش','delete'=>'حذف','view'=>'جزئیات','group'=>'افزدن گروهی کاربر',
                    ]
                ],
                'Setting' => [
                    'title' => 'تنظیمات',
                    'action' => [
                        'index'=>'صفحه تنظیمات',
                    ]
                ],
				'Client' => [
                    'title' => 'پنل کاربران',
                    'action' => [
                        'index'=>'پیشخوان',
                        'course'=>'لیست دوره',
                        'courses'=>'جزئیات دوره',
                        'factors'=>'فاکتور',
                        'payments'=>'پرداخت ها',
                        'exam'=>'آزمون دوره',
                        'myexam'=>'آزمون های من',
                        'video' =>'نمایش فیلم',
                        'certificate' =>'درخواست گواهینامه',
                    ]
                ],
                'Guest' => [
                    'title' => 'پنل مهمان',
                    'action' => [
                        'index'=>'صفحه اصلی',
                        'courses'=>'دوره ها',
                        'exam'=>'آزمون دوره',
                        'myexam'=>'آزمون های من',
                        'video' =>'نمایش فیلم'
                    ]
                ],
            ]
        ];
    }
    public function preload(){
        //FuncHelper::do_action('admin_dashboard', self::post_widget('dashboard'));
        FuncHelper::do_action('options_userfield', self::options('user_field'));
        FuncHelper::do_action('post_type',self::post_type());
        FuncHelper::do_action('admin_sidemenu', self::sidemenu());
        FuncHelper::do_action('admin_postwidget', self::post_widget('post'));
        FuncHelper::do_action('options_role', self::options_role());
        FuncHelper::do_action('user_dashboard', self::post_widget('dashboard'));
        FuncHelper::do_action('register_cronjobs', self::post_widget('cronjobs'));
    }
    public function activation(){
        $conn = \Cake\Datasource\ConnectionManager::get('default');
        $conn->enableQueryLogging(false);
        $conn->begin();
        $conn->execute("
        CREATE TABLE IF NOT EXISTS `lms_courseexams` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `lms_course_id` int(11) NOT NULL,
            `lms_coursefile_id` int(11) NOT NULL,
            `lms_exam_id` int(11) NOT NULL,
            `on_success` tinyint(1) DEFAULT NULL COMMENT 'go next level if success',
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        -- --------------------------------------------------------
        CREATE TABLE IF NOT EXISTS `lms_coursefilecans` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `user_id` int(11) NOT NULL,
            `lms_course_id` int(11) NOT NULL,
            `lms_coursefile_id` int(11) NOT NULL,
            `enable` tinyint(1) NOT NULL DEFAULT 0,
            `types` tinyint(1) NOT NULL DEFAULT 0,
            `created` datetime NOT NULL DEFAULT '2021-09-18 00:00:00',
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        -- --------------------------------------------------------
        CREATE TABLE IF NOT EXISTS `lms_coursefilenotes` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `lms_coursefile_id` int(11) NOT NULL,
            `types` tinyint(4) DEFAULT 0 COMMENT '1:text,2:file,3:image,4:link',
            `descr` text DEFAULT NULL,
            `created` datetime NOT NULL,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        -- --------------------------------------------------------
        CREATE TABLE IF NOT EXISTS `lms_coursefiles` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `title` varchar(300) DEFAULT NULL,
            `lms_course_id` int(11) NOT NULL,
            `lms_courseweek_id` int(11) NOT NULL,
            `days` smallint(6) NOT NULL DEFAULT 0 COMMENT 'چه زمانی فعال شود/z0:nolimit/n:day',
            `filesrc_1` text DEFAULT NULL,
            `filesrc_2` text DEFAULT NULL,
            `filesrc_3` text DEFAULT NULL,
            `filesrc_4` text DEFAULT NULL,
            `filesrc_extra` text DEFAULT NULL,
            `content` text DEFAULT NULL,
            `priority` smallint(6) DEFAULT 1,
            `show_in_list` tinyint(4) DEFAULT 0,
            `image` varchar(200) DEFAULT NULL,
            `enable` tinyint(1) NOT NULL DEFAULT 1,
            `created` datetime NOT NULL,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        -- --------------------------------------------------------
        CREATE TABLE IF NOT EXISTS `lms_courserelateds` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `lms_course_id` int(11) NOT NULL,
            `lms_course_ids` int(11) NOT NULL,
            `types` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1:pishniaz/2:hamniaz',
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        -- --------------------------------------------------------
        CREATE TABLE IF NOT EXISTS `lms_courses` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `title` varchar(200) NOT NULL,
            `user_id` int(11) DEFAULT NULL,
            `text` text DEFAULT NULL,
            `textweb` longtext DEFAULT NULL,
            `image` varchar(200) DEFAULT NULL,
            `date_start` datetime DEFAULT NULL,
            `date_end` datetime DEFAULT NULL,
            `date_type` tinyint(4) NOT NULL DEFAULT 1,
            `price` bigint(20) DEFAULT NULL,
            `price_special` bigint(20) DEFAULT 0,
            `price_renew` int(11) DEFAULT NULL,
            `show_in_list` tinyint(1) NOT NULL DEFAULT 1,
            `can_add` tinyint(1) NOT NULL DEFAULT 1,
            `can_renew` tinyint(1) DEFAULT 1,
            `renew_day` int(11) DEFAULT 0,
            `enable` tinyint(1) NOT NULL DEFAULT 1,
            `priority` smallint(6) DEFAULT 1,
            `created` datetime NOT NULL,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        -- --------------------------------------------------------
        CREATE TABLE IF NOT EXISTS `lms_coursesessions` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `lms_course_id` int(11) DEFAULT NULL,
            `lms_courseweek_id` int(11) DEFAULT NULL,
            `lms_coursefile_id` int(11) DEFAULT NULL,
            `user_id` int(11) NOT NULL,
            `created` datetime NOT NULL,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        -- --------------------------------------------------------
        CREATE TABLE IF NOT EXISTS `lms_courseusers` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `lms_course_id` int(11) NOT NULL,
            `user_id` int(11) NOT NULL,
            `created` datetime NOT NULL,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        -- --------------------------------------------------------
        CREATE TABLE IF NOT EXISTS `lms_courseweeks` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `lms_course_id` int(11) NOT NULL,
            `title` varchar(200) NOT NULL,
            `priority` tinyint(4) DEFAULT 1,
            `created` datetime NOT NULL,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        -- --------------------------------------------------------
        CREATE TABLE IF NOT EXISTS `lms_examquests` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `lms_exam_id` int(11) NOT NULL,
            `title` text NOT NULL,
            `images` varchar(200) DEFAULT NULL,
            `priority` smallint(6) NOT NULL DEFAULT 1,
            `types` tinyint(1) NOT NULL DEFAULT 1 COMMENT '0:tashrih/1:testi/2:checkbox',
            `q1` text DEFAULT NULL,
            `q2` text DEFAULT NULL,
            `q3` text DEFAULT NULL,
            `q4` text DEFAULT NULL,
            `q5` text DEFAULT NULL,
            `correct` tinyint(4) DEFAULT NULL,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        -- --------------------------------------------------------
        CREATE TABLE IF NOT EXISTS `lms_examresultlists` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `user_id` int(11) NOT NULL,
            `lms_examresult_id` int(11) NOT NULL,
            `lms_exam_id` int(11) NOT NULL,
            `lms_examquest_id` int(11) NOT NULL,
            `token` smallint(6) DEFAULT NULL,
            `answer` text NOT NULL,
            `result` tinyint(2) DEFAULT 0,
            `filesrc` varchar(200) DEFAULT NULL,
            `created` datetime NOT NULL,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        -- --------------------------------------------------------
        CREATE TABLE IF NOT EXISTS `lms_examresults` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `user_id` int(11) NOT NULL,
            `lms_exam_id` int(11) NOT NULL,
            `lms_coursefile_id` int(11) DEFAULT NULL,
            `token` varchar(15) DEFAULT NULL,
            `result` tinyint(2) DEFAULT 0,
            `descr` varchar(200) DEFAULT NULL,
            `created` datetime NOT NULL,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        -- --------------------------------------------------------
        CREATE TABLE IF NOT EXISTS `lms_exams` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `title` varchar(300) NOT NULL,
            `descr` varchar(5000) DEFAULT NULL,
            `timer` smallint(6) DEFAULT 0 COMMENT 'minute/0:no limited',
            `reexam` tinyint(4) DEFAULT 1 COMMENT 'تکرار شرکت در ازمون',
            `fail_count` tinyint(4) NOT NULL,
            `user_id` int(11) DEFAULT NULL,
            `created` datetime NOT NULL,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        -- --------------------------------------------------------
        CREATE TABLE IF NOT EXISTS `lms_examusers` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `user_id` int(11) NOT NULL,
            `lms_exam_id` int(11) NOT NULL,
            `token` smallint(6) DEFAULT NULL COMMENT 'ثبت آزمون تکراری برای کاربر',
            `final_result` varchar(5) DEFAULT '0',
            `created` datetime NOT NULL,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        -- --------------------------------------------------------
        CREATE TABLE IF NOT EXISTS `lms_factors` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `user_id` int(11) NOT NULL,
            `user_ids` int(11) DEFAULT NULL,
            `price` bigint(20) NOT NULL DEFAULT 0,
            `paid` tinyint(4) NOT NULL DEFAULT 0,
            `status` tinyint(4) DEFAULT NULL,
            `descr` text DEFAULT NULL,
            `created` datetime NOT NULL,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        -- --------------------------------------------------------
        CREATE TABLE IF NOT EXISTS `lms_payments` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `lms_factor_id` int(11) DEFAULT NULL,
            `token` varchar(100) DEFAULT NULL,
            `price` bigint(20) NOT NULL,
            `user_id` int(11) NOT NULL,
            `terminal_ids` tinyint(4) DEFAULT NULL,
            `auth` varchar(100) DEFAULT NULL,
            `RefID` varchar(100) DEFAULT NULL,
            `TraceID` varchar(100) DEFAULT NULL,
            `Errcode` varchar(100) DEFAULT NULL,
            `Errtext` varchar(100) DEFAULT NULL,
            `status` tinyint(4) NOT NULL DEFAULT 0,
            `enable` tinyint(1) NOT NULL DEFAULT 0,
            `created` datetime NOT NULL,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        -- --------------------------------------------------------
        CREATE TABLE IF NOT EXISTS `lms_userfactors` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `user_id` int(11) NOT NULL,
            `lms_factor_id` int(11) NOT NULL,
            `lms_course_id` int(11) NOT NULL,
            `user_ids` int(11) DEFAULT NULL,
            `enable` tinyint(1) NOT NULL DEFAULT 0,
            `created` datetime NOT NULL,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        -- --------------------------------------------------------
        CREATE TABLE IF NOT EXISTS `lms_usernotes` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `user_id` int(11) NOT NULL,
            `lms_course_id` int(11) NOT NULL,
            `lms_coursefile_id` int(11) NOT NULL,
            `text` text NOT NULL,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        -- --------------------------------------------------------
        CREATE TABLE IF NOT EXISTS `lms_userprofiles` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `user_id` int(11) NOT NULL,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        -- --------------------------------------------------------
        CREATE TABLE IF NOT EXISTS `lms_coupons` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `title` varchar(20) NOT NULL,
            `product_ids` text DEFAULT NULL,
            `usage_limit_per_user` int(11) DEFAULT 0,
            `usage_limit_price` int(11) DEFAULT 0,
            `usage_count` int(11) DEFAULT 0,
            `maximum_amount` int(11) DEFAULT 0,
            `product_categories` text DEFAULT NULL,
            `discount_type` varchar(100) DEFAULT 'precent',
            `expiry_date` date DEFAULT NULL,
            `created` datetime NOT NULL,
            `modified` datetime NOT NULL,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        -- --------------------------------------------------------
        ALTER TABLE `lms_factors` ADD `old_price` BIGINT NULL AFTER `price`, ADD `lms_coupon_id` INT NULL AFTER `old_price`;
        ALTER TABLE `lms_coursefiles` ADD `top_content` VARCHAR(5000) NULL AFTER `content`;

        CREATE TABLE IF NOT EXISTS lms_coursecategories (
            id int(11) NOT NULL AUTO_INCREMENT,
            title varchar(1000) NOT NULL,
            descr varchar(5000) DEFAULT NULL,
            created datetime NOT NULL,
            PRIMARY KEY (id)
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

        -- --------------------------------------------------------
        ");
       
        try{
            $conn->execute("ALTER TABLE `lms_coupons` ADD `descr` TEXT NULL AFTER `expiry_date`;");
        }catch(Exception $e){}
        try{
            $conn->execute("ALTER TABLE `lms_coursefiles` ADD `preview` VARCHAR(1000) NULL AFTER `filesrc_extra`;");
        }catch(Exception $e){}

        /* try{
            $conn->execute("ALTER TABLE `lms_coursefiles` ADD `waee` INT NULL AFTER `enable`;");
        }catch(Exception $e){} */

        try{
            $conn->execute("ALTER TABLE `lms_courses` ADD `options` VARCHAR(2000) NULL AFTER `priority`;");
        }catch(Exception $e){}

        try{
            $conn->execute("ALTER TABLE `lms_courseusers` ADD `status` TINYINT NULL AFTER `user_id`, ADD `enable` BOOLEAN NOT NULL DEFAULT TRUE AFTER `status`;
            ");
        }catch(Exception $e){}

        try{
            $conn->execute("CREATE TABLE IF NOT EXISTS `lms_certificates` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `user_id` int(11) NOT NULL,
                `lms_course_id` int(11) NOT NULL,
                `input_data` text DEFAULT NULL,
                `image` varchar(1000) DEFAULT NULL,
                `download` varchar(1000) DEFAULT NULL,
                `status` tinyint(4) DEFAULT NULL,
                `alert` text DEFAULT NULL,
                `enable` tinyint(1) NOT NULL DEFAULT 0,
                `created` datetime DEFAULT NULL,
                `accepted` datetime DEFAULT NULL,
                PRIMARY KEY (`id`)
              ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
              COMMIT;");
        }catch(Exception $e){}


        $conn->commit();

    }
    public function routes(RouteBuilder $routes): void
    {
        $routes->plugin(
            'Sss',
            ['path' => '/sss'],
            function (RouteBuilder $builder) {
                // Add custom routes here

                $builder->fallbacks();
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
            'name'=>'Lms',
            'title'=>'سامانه آموزشی',
            'icon'=>'fa fa-item',
            'description'=>'',
            'author'=>'Mahan',
            'version'=>'1.0',
            'path' =>[
                'index' =>'',
                'admin' =>'/admin/lms/index',
                'setting' =>'',
                ]
        ];
    }
}
