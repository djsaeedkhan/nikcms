<?php
namespace Captcha;
use Cake\Core\BasePlugin;
use Cake\Console\CommandCollection;
use Cake\Core\PluginApplicationInterface;
use Cake\Core\ContainerInterface;
use Cake\Http\MiddlewareQueue;
use Cake\Routing\RouteBuilder;
class Plugin extends BasePlugin
{
    public $name= 'Captcha';
    public function preload(){}
    public function activation(){}
    public function deactivation( $drop = false){}
    public function routes(RouteBuilder $routes): void
    {
        $routes->plugin(
            'Captcha',
            ['path' => '/'],
            function (RouteBuilder $builder) {
                $builder->connect('/create-captcha', ['controller' => 'Captcha', 'action' => 'create']);
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
            'name'=>'Captcha',
            'title'=>'کدکپچا',
            'icon'=>'fa fa-item',
            'description'=>'نمایش کدکپچا در مکان های مورد نیاز سایت',
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
