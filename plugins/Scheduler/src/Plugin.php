<?php
namespace Scheduler;
use Cake\Core\BasePlugin;
use Cake\Console\CommandCollection;
use Cake\Core\ContainerInterface;
use Cake\Core\PluginApplicationInterface;
use Cake\Http\MiddlewareQueue;
use Cake\Routing\Route\DashedRoute;
use Cake\Routing\RouteBuilder;

class Plugin extends BasePlugin {
    public $name= 'Scheduler';
    public function preload(){}
    public function activation(){
        $conn = \Cake\Datasource\ConnectionManager::get('default');
        $conn->execute("
            CREATE TABLE IF NOT EXISTS `cronjobs` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `name` varchar(100) NOT NULL,
                `plugin` varchar(100) DEFAULT NULL,
                `status` tinyint(4) DEFAULT 1,
                `result` text DEFAULT NULL,
                `created` datetime NOT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;
        ");
    }
    public function deactivation($drop = false){}
    public function config(){
        return [
            'name'=>'Scheduler',
            'title'=>'مدیریت زمانبندی فرآیند',
            'icon'=>'fa fa-item',
            'description'=>'',
            'author'=>'Mahan',
            'version'=>'1.0',
            'path' =>[
                'index' =>'',
                'admin' =>'/admin/scheduler',
                'setting' =>'',
                ]
        ];
    }

    public function routes(RouteBuilder $routes): void
    {
        $routes
            ->plugin(
                'Scheduler',
                ['path' => '/admin/scheduler/'],
                function (RouteBuilder $routes) {
                    $routes->connect('/', ['controller' => 'Home']);
                    $routes->fallbacks(DashedRoute::class);
                }
            )
            ->plugin(
                'Scheduler',
                ['path' => '/dowithcronjobs/'],
                function (RouteBuilder $routes) {
                    $routes->connect('/', ['controller' => 'Cron']);
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
