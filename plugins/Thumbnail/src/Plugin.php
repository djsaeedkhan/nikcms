<?php
namespace Thumbnail;
use Cake\Core\BasePlugin;
use Cake\Console\CommandCollection;
use Cake\Core\ContainerInterface;
use Cake\Core\PluginApplicationInterface;
use Cake\Http\MiddlewareQueue;
use Cake\Routing\Route\DashedRoute;
use Cake\Routing\RouteBuilder;

class Plugin extends BasePlugin {
    public $name= 'Thumbnail';
    public function preload(){}
    public function activation(){}
    public function deactivation($drop = false){}
    public function config(){
        return [
            'name'=>'Thumbnail',
            'title'=>'بازسازی تصاویر بندانگشتی',
            'icon'=>'fa fa-item',
            'description'=>'',
            'author'=>'Mahan',
            'version'=>'1.0',
            'path' =>[
                'index' =>'',
                'admin' =>'/admin/thumbnail/home/index/',
                'setting' =>'',
                ]
        ];
    }
    public function routes(RouteBuilder $routes): void
    {
        $routes->plugin(
            'Thumbnail',
            ['path' => '/admin/thumbnail/'],
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
