<?php
namespace Postviews;
use Cake\Core\BasePlugin;
use Admin\View\Helper\FuncHelper;
use Cake\Console\CommandCollection;
use Cake\Core\ContainerInterface;
use Cake\Core\PluginApplicationInterface;
use Cake\Http\MiddlewareQueue;
use Cake\Routing\Route\DashedRoute;
use Cake\Routing\RouteBuilder;

class Plugin extends BasePlugin
{
    public $name= 'Postviews';
    function post_widget( $menu_type = 'post'){
        switch ($menu_type) {
            case 'dashboard':
                return [
                    [
                        'name'=>'pw_totalview', 
                        'title' =>__d('Postviews','نمودار بازدید پست ها'), 
                        'widget' =>'Postviews.Totalview',
                        'order'=>'hight'
                    ],
                ];
                break;
            case 'sidebar':
                return []; break;
            case 'widget':
                return []; break;
            case 'category':
                return []; break;
            default:
                return []; break;
        }
    }
    function options_role(){
        return [
            'plugin' => self::config()['name'] ,
            'title' => self::config()['title'],
            'role'=> [
                'Home' => [
                    'title' => __d('Postviews','تنظیمات'),
                    'action' => [
                        'index'=>__d('Postviews','لیست آخرین پربازدیدها'),
                        'setting'=>__d('Postviews','تنظیمات'),
                    ]
                ],
            ]
        ];
    }
    public function preload(){
        FuncHelper::do_action('admin_dashboard', self::post_widget('dashboard'));
        FuncHelper::do_action('options_role', self::options_role());
    }
    public function activation(){}
    public function deactivation( $drop = false){}
    public function config(){
        return [
            'name'=>'Postviews',
            'title'=>__d('Postviews','بازدید مطالب'),
            'icon'=>'fa fa-item',
            'description'=>__d('Postviews','مدیریت بازدید مطالب'),
            'author'=>'Mahan',
            'version'=>'1.0',
            'path' =>[
                'index' =>'',
                'admin' =>'/admin/postviews/',
                'setting' =>'/admin/postviews/setting/',
                ]
        ];
    }

    public function routes(RouteBuilder $routes): void
    {
        $routes->plugin(
            'Postviews',
            ['path' => '/admin/postviews/setting/*'],
            function (RouteBuilder $routes) {
                $routes->connect('/', ['controller' => 'Home','action'=>'setting']);
                $routes->fallbacks(DashedRoute::class);
            }
        )
        ->plugin(
            'Postviews',
            ['path' => '/admin/postviews/*'],
            function (RouteBuilder $routes) {
                $routes->connect('/', ['controller' => 'Home','action'=>'index']);
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