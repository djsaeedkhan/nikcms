<?php
namespace Breadcrumb;
use Cake\Core\BasePlugin;

class Plugin extends BasePlugin
{
    public $name= 'Breadcrumb';
    function options_role(){
        return [
            'plugin' => self::config()['name'] ,
            'title' => self::config()['title'],
            'role'=> [
                'Home' => [
                    'title' => __d('Breadcrumb','تنظیمات'),
                    'action' => [
                        'index'=> __d('Breadcrumb','صفحه اصلی'),
                    ]
                ],
            ]
        ];
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
    public function preload(){
        \Admin\View\Helper\FuncHelper::do_action('options_role', self::options_role());
    }
    public function activation(){}
    public function deactivation( $drop = false){}
    public function config(){
        return [
            'name'=>'Breadcrumb',
            'title'=>__d('Breadcrumb','مکان نما'),
            'icon'=>'fa fa-item',
            'description'=>__d('Breadcrumb','مدیریت مکان نما'),
            'author'=>'Mahan',
            'version'=>'1.0',
            'path' =>[
                'index' =>'',
                'admin' =>'',
                'setting' =>'/admin/breadcrumb/',
                ]
        ];
    }
}
