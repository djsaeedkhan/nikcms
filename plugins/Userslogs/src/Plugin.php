<?php
namespace Userslogs;
use Cake\Core\BasePlugin;
use Cake\Console\CommandCollection;
use Cake\Core\ContainerInterface;
use Cake\Core\PluginApplicationInterface;
use Cake\Http\MiddlewareQueue;
use Cake\Routing\Route\DashedRoute;
use Cake\Routing\RouteBuilder;

class Plugin extends BasePlugin
{
    public $name= 'Userslogs';
    public function admin_navmenu(){return [];}
    public function admin_sidemenu(){return [];}
    public function preload(){
        \Admin\View\Helper\FuncHelper::do_action('options_role', self::options_role());
    }
    function options_role(){
        return [
            'plugin' => self::config()['name'] ,
            'title' => self::config()['title'],
            'role'=> [
                 'Home' => [
                    'title' => __d('Userslogs', 'نمایش لاگ'),
                    'action' => [
                        'index'=>__d('Userslogs', 'صفحه اصلی'),
                    ]
                ],
            ]
        ];
    }
    /* public function console($commands)
    {
        // Add console commands here.
        $commands = parent::console($commands);
        //$commands->add('bake model', ModelCommand::class);
        return $commands;
    } */
    public function activation(){
        $conn = \Cake\Datasource\ConnectionManager::get('default');
        $conn->execute("CREATE TABLE IF NOT EXISTS `users_logs` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `user_id` int(11) DEFAULT NULL,
          `username` varchar(100) DEFAULT NULL,
          `types` tinyint(4) DEFAULT NULL COMMENT '1:succ/2:faild',
          `created` datetime NOT NULL,
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        COMMIT;");
    }
    public function deactivation( $drop = false){
        if($drop == true){
            $conn = \Cake\Datasource\ConnectionManager::get('default');
            $conn->execute("DROP TABLE IF EXISTS `users_logs`;");
        }
    }
    public function config(){
        return [
            'name'=>'Userslogs',
            'title'=> __d('Userslogs', 'لاگ فعالیت کاربران'),
            'icon'=>'fa fa-item',
            'description'=> __d('Userslogs', 'مدیریت لاگ فعالیت کاربران') ,
            'author'=>'Mahan',
            'version'=>'1.0',
            'path' =>[
                'index' =>'',
                'admin' =>'/admin/userslogs/home/?last=true',
                'setting' =>'',
                ]
        ];
    }
    /* public function routes(RouteBuilder $routes): void
    {
        $routes->plugin(
            'Userslogs',
            ['path' => '/admin/userslogs/'],
            function (RouteBuilder $routes) {
                $routes->connect('/', ['controller' => 'Home']);
                $routes->fallbacks(DashedRoute::class);
            }
        );

        parent::routes($routes);
    } */
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
