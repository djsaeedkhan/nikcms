<?php
namespace RegisterField;
use Cake\Core\BasePlugin;
use Admin\View\Helper\FuncHelper;
use \RegisterField\RField;
use Cake\Console\CommandCollection;
use Cake\Core\ContainerInterface;
use Cake\Core\PluginApplicationInterface;
use Cake\Http\MiddlewareQueue;
use Cake\Routing\Route\DashedRoute;
use Cake\Routing\RouteBuilder;

class Plugin extends BasePlugin {
    public $name= 'RegisterField';
    public function options($type = null){
        switch ($type) {
            case 'register':
            case 'register_form':
                $temp = new RField();
                return $temp->create_RegisterField($_GET);
                break;

            case 'registeration_after':
                $temp = new RField();
                return $temp->getSms($_GET);
                break;
        }
    }
    public function preload(){
        FuncHelper::do_action('options_registerform', self::options('register_form'));
        FuncHelper::do_action('registeration_after', self::options('registeration_after'));
    }
    public function activation(){}
    public function deactivation( $drop = false){}
    public function config(){
        return [
            'name'=>'RegisterField',
            'title'=>' فیلدهای ثبت نام',
            'icon'=>'fa fa-item',
            'description'=>'مدیریت فیلدهای مورد نیاز برای ثبت نام',
            'author'=>'Mahan',
            'version'=>'1.0',
            'path' =>[
                'index' =>'',
                'admin' =>'/admin/registerfield/',
                'setting' =>'',
                ]
        ];
    }
    public function routes(RouteBuilder $routes): void
    {
        $routes->plugin(
            'RegisterField',
            ['path' => '/admin/'],
            function (RouteBuilder $builder) {
                $builder->connect('/registerfield/', ['controller' => 'Home']);
                $builder->connect('/register-field/', ['controller' => 'Home']);
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
