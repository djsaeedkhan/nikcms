<?php
namespace Mpdfs;
use Cake\Core\BasePlugin;
use Cake\Console\CommandCollection;
use Cake\Core\ContainerInterface;
use Cake\Core\PluginApplicationInterface;
use Cake\Http\MiddlewareQueue;
use Cake\Routing\Route\DashedRoute;
use Cake\Routing\RouteBuilder;

class Plugin extends BasePlugin {
    public $name= 'Mpdfs';
    public function preload(){}
    public function activation(){}
    public function deactivation($drop = false){}
    public function routes(RouteBuilder $routes): void
    {
        $routes->plugin(
            'Mpdfs',
            ['path' => '/admin/mpdfs/'],
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
    public function config(){
        return [
            'name'=>'Mpdfs',
            'title'=>'پی دی اف ساز (Pdf)',
            'icon'=>'fa fa-item',
            'description'=>'',
            'author'=>'Mahan',
            'version'=>'1.0',
            'path' =>[
                'index' =>'',
                'admin' =>'',
                'setting' =>'',
                ]
        ];
    }
}
