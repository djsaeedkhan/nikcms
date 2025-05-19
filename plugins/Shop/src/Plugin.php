<?php
namespace Shop;

use Admin\View\Helper\FuncHelper;
use Cake\Core\BasePlugin;

class Plugin extends BasePlugin
{
    public $name= 'Shop';
    function post_type(){
        return [
            'product'=>array(
                'name'=>array(
                    'title'=>'محصولات',
                    'index_header'=>'لیست محصولات','index_add'=>'ثبت جدید',
                    'single_add'=>'ثبت محصول جدید','single_edit'=>'ویرایش محصول',
                    'cat_header'=>'دسته بندی محصول','cat_add'=>'ثبت دسته محصول',
                    'tag_header'=>'برچسب',
                ),
                'title'=>true,'editor'=>true,'excerpt'=>false,'author'=>true,'thumbnail'=>true,
                'comments'=>false,'tag'=>true,'category'=>true,'show_in_menu'=>true,
                'position'=>1110,
            ),
        ];
    }
    function posttype_adminmenu(){
        $menu = [];
        foreach($this->post_type() as $post_type => $value ){
            $data = [
                $value['position']=>[
                    'title'=>$value['name']['title'],
                    'post_type'=> $post_type,
                    'link'=>[
                        'plugin'=>'admin',
                        'controller'=>'Posts',
                        'action'=>'index',
                        '?'=>['post_type'=>$post_type]],
                    'has_sub'=>true,
                    'icon'=>'shopping-cart',
                    'show_in_menu'=>$value['show_in_menu'],
                    'sub_menu'=>[],
                ],
            ];

            if($value['name']['index_header'] != ''){
                $data[$value['position']]['sub_menu'][1] =[
                    'title'=>$value['name']['title'],
                    'link'=>[
                        'plugin'=>'admin',
                        'controller'=>'Posts',
                        'action'=>'index',
                        '?'=>['post_type'=>$post_type]],
                ];
            }

            if($value['name']['single_add'] != ''){
                $data[$value['position']]['sub_menu'][2] =[
                    'title'=>$value['name']['single_add'],
                    'link'=>[
                        'plugin'=>'admin',
                        'controller'=>'Posts',
                        'action'=>'add',
                        '?'=>['post_type'=>$post_type]],
                ];
            }
            if($value['category']){
                $data[$value['position']]['sub_menu'][3] = [
                    'title'=>$value['name']['cat_header'],
                    'link'=>[
                        'plugin'=>'admin',
                        'controller'=>'Categories',
                        'action'=>'index',
                        '?'=>['post_type'=>$post_type]],
                ];
            }
            if($value['tag']){
                $data[$value['position']]['sub_menu'][4] = [
                    'title'=>$value['name']['tag_header'],
                    'link'=>[
                        'plugin'=>'admin',
                        'controller'=>'Tags',
                        'action'=>'index',
                        '?'=>['post_type'=>$post_type]],
                ];
            }
            $menu += $data;
        }
        return $menu;
    }
    public function sidemenu(){
        return [
            '150'=>array(
                'title'=>'افزونه فروشگاه',
                'link'=>[
                    'plugin'=>'Shop',
                    'controller'=>'Home',
                    'action'=>'index'],
                'has_sub'=>true, 
                'icon'=> 'shopping-cart', 
                'show_in_menu'=>true,
                'sub_menu'=>[
                    [
                        'title'=>'پیشخوان',
                        'link'=>'/admin/shop/home/index/',
                        'has_sub'=>false, 'icon'=>true, 'show_in_menu'=>true,
                    ],[
                        'title'=>'سفارشات',
                        'link'=>'/admin/shop/order/index/?status=paid',
                        'has_sub'=>false, 'icon'=>true, 'show_in_menu'=>true,
                    ],[
                        'title'=>'مرجوعی',
                        'link'=>'/admin/shop/refunds/index/',
                        'has_sub'=>false, 'icon'=>true, 'show_in_menu'=>true,
                    ],[
                        'title'=>'مشتریان',
                        'link'=>'/admin/shop/customers/index/',
                        'has_sub'=>false, 'icon'=>true, 'show_in_menu'=>true,
                    ],[
                        'title'=>'گزارشات',
                        'link'=>'/admin/shop/report/index/',
                        'has_sub'=>false, 'icon'=>true, 'show_in_menu'=>true,
                    ],[
                        'title'=>'پارامتر ها',
                        'link'=>'/admin/shop/home/params/',
                        'has_sub'=>false, 'icon'=>true, 'show_in_menu'=>true,
                    ],[
                        'title'=>'ویژگی ها',
                        'link'=>'/admin/shop/home/attributes/',
                        'has_sub'=>false, 'icon'=>true, 'show_in_menu'=>true,
                    ],[
                        'title'=>'نمایندگی',
                        'link'=>'/admin/shop/logestics/',
                        'has_sub'=>false, 'icon'=>true, 'show_in_menu'=>true,
                    ],[
                        'title'=>'برند ها (Brands)',
                        'link'=>'/admin/shop/home/brands/',
                        'has_sub'=>false, 'icon'=>true, 'show_in_menu'=>true,
                    ],[
                        'title'=>'اتیکت (Label)',
                        'link'=>'/admin/shop/home/labels/',
                        'has_sub'=>false, 'icon'=>true, 'show_in_menu'=>true,
                    ],[
                        'title'=>'روش ارسال',
                        'link'=>'/admin/shop/home/transport/',
                        'has_sub'=>false, 'icon'=>true, 'show_in_menu'=>true,
                    ],[
                        'title'=>'زمانبندی ارسال',
                        'link'=>'/admin/shop/home/schedule/',
                        'has_sub'=>false, 'icon'=>true, 'show_in_menu'=>true,
                    ],[
                        'title'=>'تنظیمات',
                        'link'=>'/admin/shop/home/setting/',
                        'has_sub'=>false, 'icon'=>true, 'show_in_menu'=>true,
                    ]
                ],
            ),
        ];
    }
    function post_widget( $menu_type = 'post'){
        switch ($menu_type) {
            case 'cronjobs':
                return [
                    [
                        'name'=>'delete_unpaid_order',
                        'title' =>'حذف اتوماتیک سفارش های پرداخت نشده',
                        'widget' =>'Shop.Cronjobs',
                        'plugin' =>'Shop',
                        'order'=>'hight2',
                        'every'=>'1 hours'
                    ],
                ];
                break;
            case 'dashboard':
                return [
                    [
                        'name'=>'shop_amar',
                        'title' =>'آمار فروشگاه',
                        'widget' =>'Shop.Home::dashboard',
                        'order'=>'hight2'
                    ],
                ];
                break;
            case 'register_widget':
                return [
                    [
                        'name'=>'shopfilter_brand', 
                        'title' =>'فروشگاه - فیلتر برند', 
                        'widget' =>'Shop.Fbrands',
                        'desc'=>'فیلتر لیست برندها  '
                    ],[
                        'name'=>'shopfilter_price', 
                        'title' =>'فروشگاه - فیلتر قیمت', 
                        'widget' =>'Shop.Fprice',
                        'desc'=>'فیلتر کمترین بیشترین قیمت']
                    ,[
                        'name'=>'shopfilter_category', 
                        'title' =>'فروشگاه - دسته بندی', 
                        'widget' =>'Shop.Fcategory',
                        'desc'=>'فیلتر دسته بندی محصولات']
                    ,[
                        'name'=>'shopfilter_label', 
                        'title' =>'فروشگاه - لیبل محصولات', 
                        'widget' =>'Shop.Flabel',
                        'desc'=>'فیلتر لیبل (اتیکت) محصولات']
                    ,
                ];
            default:
                return [
                    ['product' => 'Shop.Meta::product'],
                ]; break;
        }
    }
    function options_role(){
        return [
            'plugin' => self::config()['name'] ,
            'title' => self::config()['title'],
            'role'=> [
                'Home' => [
                    'title' => 'مدیریت فروشگاه',
                    'action' => [
                        'index'=>'پیشخوان',
                        'customers'=>'مشتریان',
                        'orders'=>'سفارشات',
                        'report'=>'گزارشات',
                        'setting'=>'تنظیمات فروشگاه',
                        'params'=>'پارامتر ها',
                        'attributes'=>'ویژگی ها',
                        'brands'=>'برند ها',
                        'labels'=>'اتیکت ها',
                        'brands'=>'برند ها',
                        'postsmeta'=>'ویرایش سریع',
                        'postsstock'=>'ویرایش موجودی',
                        'schedule'=>'زمانبندی ارسال',
                        'transport'=>'روش های ارسال',
                    ]
                ],
                'Refunds' => [
                    'title' => 'مدیریت مرجوعی',
                    'action' => [
                        'index'=>'لیست مرجوعی',
                        'edit'=>'ویرایش',
                    ]
                ],
                'Order' => [
                    'title' => 'مدیریت سفارشات',
                    'action' => [
                        'index'=>'لیست سفارشات',
                        'view'=>'مشاهده',
                        'edit'=>'ویرایش',
                        'delete'=>'حذف',
                        'status'=>'تغییر وضعی',
                        'logs'=>'لاگ وضعیت',
                    ]
                ],
                'Customers' => [
                    'title' => 'مدیریت مشتریان',
                    'action' => [
                        'index'=>'صفحه اصلی',
                        'view'=>'مشاهده جزئیات',
                        'edit'=>'ویرایش',
                        'add'=>'افزودن',
                        'delete'=>'حذف',
                        
                    ]
                ],
                'Report' => [
                    'title' => 'مدیریت گزارشات',
                    'action' => [
                        'index'=>'صفحه اصلی',
                        'view'=>'مشاهده جزئیات',
                        'edit'=>'ویرایش',
                        'add'=>'افزودن',
                        'delete'=>'حذف',
                    ]
                ],
                'Client' => [
                    'title' => 'فروشگاه من',
                    'action' => [
                        'index'=>'پیشخوان',
                        'orders'=>'سفارشات من',
                        'search'=>'پیگیری سفارش',
                    ]
                ],
                'Logestics'=>[
                    'title' => 'لیست نمایندگی',
                    'action' => [
                        'index'=>'صفحه اصلی',
                        'add'=>'افزودن / ویرایش',
                        'delete'=>'حذف',
                    ]
                ],
                'Logesticlists'=>[
                    'title' => 'دسته بندی نمایندگی',
                    'action' => [
                        'index'=>'صفحه اصلی',
                        'add'=>'افزودن / ویرایش',
                        'delete'=>'حذف',
                    ]
                ],
                'Logesticusers'=>[
                    'title' => 'کاربران نمایندگی',
                    'action' => [
                        'index'=>'صفحه اصلی',
                        'add'=>'افزودن / ویرایش',
                        'delete'=>'حذف',
                    ]
                ],
                'Orderlogestics'=>[
                    'title' => 'سفارشات نمایندگی',
                    'action' => [
                        'index'=>'صفحه اصلی',
                        'view'=>'مشاهده جزئیات',
                        'delete'=>'حذف',
                    ]
                ],
            ]
        ];
    }
    function admin_navmenu(){
        return [
            ['Admin.Menu::post'=>'product'],
            ['Admin.Menu::category' => 'product']
        ];
    }
    public function preload(){
        FuncHelper::do_action('post_type',self::post_type());
        FuncHelper::do_action('admin_sidemenu', self::sidemenu());
        FuncHelper::do_action('admin_navmenu', self::admin_navmenu());
        FuncHelper::do_action('admin_sidemenu', self::posttype_adminmenu());
        FuncHelper::do_action('admin_postwidget', self::post_widget('post'));
        FuncHelper::do_action('admin_dashboard', self::post_widget('dashboard'));
        FuncHelper::do_action('register_widgets', self::post_widget('register_widget'));
        FuncHelper::do_action('admin_postcnt', ['product' => 'Shop.Product']);
        FuncHelper::do_action('options_role', self::options_role());
        FuncHelper::do_action('register_cronjobs', self::post_widget('cronjobs'));
        FuncHelper::do_action('site_header', ['Shop.Pricechart']);
        FuncHelper::do_action('site_footer', ['Shop.Pricechart2']);
    }
    public function activation(){
        $conn = \Cake\Datasource\ConnectionManager::get('default');
        $conn->execute("
            CREATE TABLE IF NOT EXISTS `shop_addresses` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `user_id` int(11) DEFAULT NULL,
                `first_name` varchar(50) NOT NULL,
                `last_name` varchar(100) NOT NULL,
                `emails` varchar(100) DEFAULT NULL,
                `phone` varchar(15) NOT NULL,
                `nationalid` varchar(11) DEFAULT NULL,
                `shop_useraddress_id` int(11) NOT NULL,
                `created` datetime NOT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
            -- --------------------------------------------------------
            CREATE TABLE IF NOT EXISTS `shop_attributelists` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `shop_attribute_id` int(11) NOT NULL,
                `title` varchar(100) NOT NULL,
                `value` varchar(200) NOT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
            -- --------------------------------------------------------
            CREATE TABLE IF NOT EXISTS `shop_attributes` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `title` varchar(100) NOT NULL,
                `types` tinyint(4) DEFAULT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
            -- --------------------------------------------------------
            CREATE TABLE IF NOT EXISTS `shop_favorites` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `post_id` int(11) NOT NULL,
                `user_id` int(11) NOT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
            -- --------------------------------------------------------
            CREATE TABLE IF NOT EXISTS `shop_labels` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `title` varchar(100) NOT NULL,
                `color` varchar(100) DEFAULT NULL,
                `image` varchar(500) DEFAULT NULL,
                `descr` varchar(2000) DEFAULT NULL,
                `link` varchar(500) DEFAULT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;
            -- --------------------------------------------------------
            CREATE TABLE IF NOT EXISTS `shop_orderattributes` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `shop_orderproduct_id` int(11) NOT NULL,
                `shop_attribute_id` int(11) NOT NULL,
                `shop_attributelist_id` int(11) NOT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
            -- --------------------------------------------------------
            CREATE TABLE IF NOT EXISTS `shop_orderproducts` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `shop_order_id` int(11) NOT NULL,
                `post_id` int(11) DEFAULT NULL,
                `name` varchar(200) NOT NULL,
                `quantity` smallint(6) NOT NULL DEFAULT 0,
                `price` varchar(15) NOT NULL DEFAULT '0',
                `subtotal` varchar(15) DEFAULT '0',
                `created` datetime NOT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
            ALTER TABLE `shop_orderproducts` ADD `attrs` VARCHAR(50) NULL DEFAULT NULL AFTER `subtotal`;
            -- --------------------------------------------------------
            CREATE TABLE IF NOT EXISTS `shop_orders` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `user_id` int(11) DEFAULT NULL,
                `trackcode` varchar(20) DEFAULT NULL,
                `currency` varchar(5) DEFAULT NULL,
                `enable` tinyint(1) NOT NULL DEFAULT 1,
                `status` varchar(10) NOT NULL DEFAULT 'pending',
                `shop_address_id` int(11) DEFAULT NULL,
                `created` datetime NOT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
            -- --------------------------------------------------------
            CREATE TABLE IF NOT EXISTS `shop_ordershippings` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `shop_order_id` int(11) NOT NULL,
                `user_id` int(11) DEFAULT NULL,
                `types` varchar(10) NOT NULL,
                `price` int(11) NOT NULL,
                `sendtime` varchar(15) DEFAULT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
            ALTER TABLE `shop_ordershippings` CHANGE `price` `price` BIGINT NULL DEFAULT '0';
            -- --------------------------------------------------------
            CREATE TABLE IF NOT EXISTS `shop_ordertexts` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `shop_order_id` int(11) NOT NULL,
                `user_id` int(11) DEFAULT NULL,
                `text` text DEFAULT NULL,
                `private` tinyint(1) NOT NULL DEFAULT 0,
                `created` datetime NOT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
            -- --------------------------------------------------------
            CREATE TABLE IF NOT EXISTS `shop_ordertokens` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `shop_order_id` int(11) NOT NULL,
                `user_id` int(11) DEFAULT NULL,
                `token` varchar(15) DEFAULT NULL,
                `status` tinyint(1) NOT NULL DEFAULT 0,
                `created` datetime NOT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
            -- --------------------------------------------------------
            CREATE TABLE IF NOT EXISTS `shop_paramlists` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `shop_param_id` int(11) NOT NULL,
                `title` varchar(100) NOT NULL,
                `types` tinyint(11) DEFAULT NULL,
                `priority` smallint(6) DEFAULT 0,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
            -- --------------------------------------------------------
            CREATE TABLE IF NOT EXISTS `shop_params` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `title` varchar(100) NOT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
            -- --------------------------------------------------------
            CREATE TABLE IF NOT EXISTS `shop_payments` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `shop_order_id` int(11) NOT NULL,
                `user_id` int(11) NOT NULL,
                `terminalid` varchar(20) NOT NULL,
                `price` varchar(15) NOT NULL,
                `status` tinyint(4) NOT NULL,
                `au` varchar(50) DEFAULT NULL,
                `myrahid` varchar(20) DEFAULT NULL,
                `created` datetime NOT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
            -- --------------------------------------------------------
            CREATE TABLE IF NOT EXISTS `shop_productdetails` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `post_id` int(11) NOT NULL,
                `pattern` varchar(100) DEFAULT NULL,
                `image` varchar(2000) DEFAULT NULL,
                `sku` varchar(15) DEFAULT NULL,
                `price` bigint(20) DEFAULT 0,
                `stock` int(11) DEFAULT 0,
                `disable` tinyint(1) NOT NULL DEFAULT 0,
                `descr` varchar(2000) DEFAULT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
            -- --------------------------------------------------------
            ALTER TABLE `shop_productdetails` ADD `special_price` BIGINT NULL AFTER `price`;
            -- --------------------------------------------------------
            CREATE TABLE IF NOT EXISTS `shop_productmajors` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `post_id` int(11) NOT NULL,
                `start` int(11) NOT NULL,
                `pattern` varchar(15) DEFAULT NULL,
                `stock` int(11) DEFAULT NULL,
                `price` bigint(20) NOT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
            -- --------------------------------------------------------
            CREATE TABLE IF NOT EXISTS `shop_productprices` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `post_id` int(11) NOT NULL,
                `price` varchar(10) NOT NULL DEFAULT '0',
                `created` date NOT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
            -- --------------------------------------------------------
            CREATE TABLE IF NOT EXISTS `shop_product_metas` (
                `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
                `post_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
                `meta_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                `meta_key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                `meta_value` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
            -- --------------------------------------------------------
            CREATE TABLE IF NOT EXISTS `shop_product_params` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `post_id` int(11) NOT NULL,
                `shop_param_id` int(11) NOT NULL,
                `value` varchar(100) NOT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
            -- --------------------------------------------------------
            CREATE TABLE IF NOT EXISTS `shop_profiles` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `user_id` int(11) NOT NULL,
                `name` varchar(200) NOT NULL,
                `family` varchar(200) NOT NULL,
                `email` varchar(200) DEFAULT NULL,
                `phone` varchar(11) NOT NULL,
                `nationalid` varchar(10) NOT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
            -- --------------------------------------------------------
            CREATE TABLE IF NOT EXISTS `shop_useraddresses` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `user_id` int(11) DEFAULT NULL,
                `billing_state` int(11) NOT NULL,
                `billing_city` varchar(100) NOT NULL,
                `billing_address` varchar(500) NOT NULL,
                `billing_zip` varchar(12) DEFAULT NULL,
                `m1` varchar(20) DEFAULT NULL,
                `m2` varchar(20) DEFAULT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
            -- --------------------------------------------------------
            CREATE TABLE IF NOT EXISTS `shop_brands` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `title` varchar(50) NOT NULL,
                `slug` varchar(100) DEFAULT NULL,
                `descr` text DEFAULT NULL,
                `image` varchar(300) DEFAULT NULL,
                `link` varchar(300) DEFAULT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
            -- --------------------------------------------------------
            CREATE TABLE IF NOT EXISTS `shop_productstocks` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `post_id` int(11) NOT NULL,
                `pattern` varchar(100) DEFAULT NULL,
                `stock` int(11) NOT NULL DEFAULT 0,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
            -- --------------------------------------------------------
            COMMIT;");
    }
    public function deactivation( $drop = false){}
    public function config(){
        return [
            'name'=>'Shop',
            'title'=>'سیستم فروشگاه آنلاین',
            'icon'=>'fa fa-item',
            'description'=>'',
            'author'=>'Mahan',
            'version'=>'1.0',
            'path' =>[
                'index' =>'',
                'admin' =>'/admin/shop/index',
                'setting' =>'',
                ]
        ];
    }
}
