<?php
namespace Elementor;

use Cake\Core\BasePlugin;
use Admin\View\Helper\FuncHelper;
class Plugin extends BasePlugin{
    public $name= 'Elementor';
    public function options($type = null){
        switch ($type) {
            case 'register':
            case 'register_form':
                /* $temp = new RField();
                return $temp->create_RegisterField($_GET); */
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
                        'index'=>'صفحه نخست',
                        'savesetting'=>'ثبت تنظیمات',
                    ]
                ],
            ]
        ];
    }
    public function preload(){
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
    public function deactivation($drop = false){}
    public function config(){
        return [
            'name'=>'Elementor',
            'title'=>'المنتور (مدیریت بلاک ها)',
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
