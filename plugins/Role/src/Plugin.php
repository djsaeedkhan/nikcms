<?php
namespace Role;
use Cake\Core\BasePlugin;
use Cake\Console\CommandCollection;
use Cake\Core\ContainerInterface;
use Cake\Core\PluginApplicationInterface;
use Cake\Http\MiddlewareQueue;
use Cake\Routing\Route\DashedRoute;
use Cake\Routing\RouteBuilder;

class Plugin extends BasePlugin
{
    public $name= 'Role';
    function options_role(){
        return [
            'plugin' => self::config()['name'] ,
            'title' => self::config()['title'],
            'role'=> [
                'Home' => [
                    'title' => __d('Role','تنظیمات'),
                    'action' => [
                        'index'=>__d('Role','لیست دسترسی'),
                        'add'=>__d('Role','افزودن دسترسی'),
                        'edit'=>__d('Role','ویرایش'),
                        'delete'=>__d('Role','حذف'),
                    ]
                ],
            ]
        ];
    }
    public function options($type){
        switch ($type) {
            case 'register':
                return [
                    'register_default_role' => [
                        'type'=>'select',
                        'name'=>'register_default_role',
                        'default' => 1,
                        'options' => (TableRegistry::getTableLocator()->get('Role.roles')->find('list',['keyField'=>'id','valueField'=>'title'])->toarray()),
                        'title' => __d('Role','نقش پیش‌فرض کاربر تازه'),
                        'after' => '<small><a href="'.\Cake\Routing\Router::url('/admin/role/').'">'.
                            __d('Role','تنظیمات پلاگین') .'</a></small>',
                    ],
                ];
            case 'userfield':
                return [
                    /* 'UserMetas._joinData.meta_key' => [
                        'type'=>'text',
                        'title' => 'نقش کاربر',
                    ], */
                    'role_id' => [
                        'name' => 'role_id',
                        'type'=>'select',
                        'default' => 1,
                        'options' => TableRegistry::getTableLocator()->get('Role.roles')->find('list',['keyField'=>'id','valueField'=>'title'])->toarray(),
                        'title' => __d('Role','نقش کاربر'),
                        'after' => '<small><a href="'.
                            \Cake\Routing\Router::url('/admin/role/').'">'.
                            __d('Role','تنظیمات پلاگین') .
                            '</a></small>',
                    ],
                ];
        }
    }
    public function preload(){
        \Admin\View\Helper\FuncHelper::do_action('options_role', self::options_role());
        \Admin\View\Helper\FuncHelper::do_action('options_register', self::options('register'));
        \Admin\View\Helper\FuncHelper::do_action('options_userfield', self::options('userfield'));
    }
    public function activation(){
        $conn = \Cake\Datasource\ConnectionManager::get('default');
        $conn->execute("CREATE TABLE IF NOT EXISTS `roles` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `title` varchar(50) NOT NULL,
            `data` text NOT NULL,
            `created` datetime NOT NULL,
            PRIMARY KEY (`id`) )ENGINE=InnoDB DEFAULT CHARSET=utf8;
            COMMIT;");
    }
    public function deactivation( $drop = false){
        if($drop == true){
            $conn = \Cake\Datasource\ConnectionManager::get('default');
            $conn->execute("DROP TABLE IF EXISTS `roles`;");
        }
    }
    public function config(){
        return [
            'name'=>'Role',
            'title'=>__d('Role','دسترسی کاربران'),
            'icon'=>'fa fa-item',
            'description'=>__d('Role','مدیریت سطح دسترسی'),
            'author'=>'Mahan',
            'version'=>'1.0',
            'path' =>[
                'index' =>'',
                'admin' =>'/admin/role/',
                'setting' =>'',
                ]
        ];
    }

    public function routes(RouteBuilder $routes): void
    {
        $routes->plugin(
            'Role',
            ['path' => '/admin/role/'],
            function (RouteBuilder $builder) {
                $builder->connect('/', ['controller' => 'Home']);
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
}
