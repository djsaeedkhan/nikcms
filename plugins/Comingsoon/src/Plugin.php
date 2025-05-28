<?php
namespace Comingsoon;
use Cake\Core\BasePlugin;
use Cake\Core\PluginApplicationInterface;
use Admin\View\Helper\FuncHelper;

class Plugin extends BasePlugin
{
    public $name= 'Comingsoon';
    public function options($type = null){
        switch ($type) {
            case 'public':
                return [
                    'maintenance_mode' => [
                        'name'=>'maintenance_mode',
                        'title' => 'وضعیت حالت تعمیر' , 
                        'type'=>'select',
                        'options' =>[ 0 => 'غیرفعال ', 1 => 'فعال'],
                        'after' => '<small><a href="'.\Cake\Routing\Router::url('/admin/comingsoon/').'">تنظیمات پلاگین</a></small>',
                    ],
                ];
            break;
        }
    }
    function options_role(){
        return [
            'plugin' => self::config()['name'] ,
            'title' => self::config()['title'],
            'role'=> [
                'Home' => [
                    'title' => 'تنظیمات',
                    'action' => [
                        'index'=>'صفحه اصلی',
                    ]
                ],
            ]
        ];
    }
    public function preload(){
        //FuncHelper::do_action('site_header', ['Comingsoon.View']);
        //FuncHelper::do_action('site_preload', ['Comingsoon.View::display']);
        FuncHelper::do_action('options_public', self::options('public'));
        FuncHelper::do_action('options_role', self::options_role());
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
    public function activation(){}
    public function deactivation( $drop = false){}
    public function config(){
        return [
            'name'=>'Comingsoon',
            'title'=>'به زودی (Coming Soon) ',
            'icon'=>'fa fa-item',
            'description'=>'مدیریت وضعیت نمایش سایت',
            'author'=>'Mahan',
            'version'=>'1.0',
            'path' =>[
                'index' =>'',
                'admin' =>'/admin/comingsoon/',
                'setting' =>'',
                ]
        ];
    }
}
