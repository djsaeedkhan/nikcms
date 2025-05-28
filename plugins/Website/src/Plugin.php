<?php
namespace Website;
use Cake\Core\BasePlugin;
use Cake\Console\CommandCollection;
use Cake\Core\ContainerInterface;
use Cake\Http\MiddlewareQueue;
use Cake\Routing\RouteBuilder;

class Plugin extends BasePlugin
{
    public $name= 'Website';
    public function preload(){}
    public function activation(){}
    public function deactivation( $drop = false){}
    public function config(){
        return [
            'name'=>'Website',
            'show' => false,
            'title'=>__d('Website','مدیریت وبسایت'),
            'icon'=>'fa fa-item',
            'description'=>__d('Website','مدیریت سایت'),
            'author'=>'Mahan',
            'version'=>'1.0',
            //'sys'=> true, //system plugin
            'path' =>[
                'index' =>'',
                'admin' =>'',
                'setting' =>'',
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