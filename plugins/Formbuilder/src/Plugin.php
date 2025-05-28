<?php
namespace Formbuilder;
use Cake\Core\BasePlugin;
use \Admin\View\Helper\FuncHelper;
use Cake\Console\CommandCollection;
use Cake\Core\PluginApplicationInterface;
use Cake\Core\ContainerInterface;
use Cake\Http\MiddlewareQueue;
use Cake\Routing\Route\DashedRoute;
use Cake\Routing\RouteBuilder;

class Plugin extends BasePlugin
{
    public $name= 'Formbuilder';
    function options_role(){
        return [
            'plugin' => self::config()['name'] ,
            'title' => self::config()['title'],
            'role'=> [
                'Home' => [
                    'title' => __d('Formbuilder', 'تنظیمات'),
                    'action' => [
                        'add'=>__d('Formbuilder', 'افزودن فرم'),
                        'edit'=>__d('Formbuilder', 'ویرایش فرم'),
                        'index'=>__d('Formbuilder', 'همه فرم ها'),
                        'viewform'=>__d('Formbuilder', 'لیست فرم های ثبت شده'),
                        'view'=>__d('Formbuilder', 'ریز فرم های ثبت شده'),
                        'delete'=>__d('Formbuilder', 'حذف'),
                    ]
                ],
            ]
        ];
    }
    function shortcode(){
        return [
            'code_formbuilder' => 'Formbuilder.View',
        ];
    }
    public function preload(){
        FuncHelper::do_action('options_role', self::options_role());
        FuncHelper::do_action('shortcode', self::shortcode());
    }
    public function routes(RouteBuilder $routes): void
    {
        $routes->plugin(
            'Formbuilder',
            ['path' => '/admin/formbuilder/'],
            function (RouteBuilder $routes) {
                $routes->connect('/', ['controller' => 'Home']);
                $routes->fallbacks(DashedRoute::class);
            }
        )
        ->plugin(
            'Formbuilder',
            ['path' => '/form/*'],
            function (RouteBuilder $routes) {
                $routes->connect('/', ['controller' => 'View','action'=>'index']);
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
    public function activation(){
        $conn = \Cake\Datasource\ConnectionManager::get('default');
        $conn->execute("CREATE TABLE IF NOT EXISTS `formbuilders` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `title` varchar(30) NOT NULL,
            `passwords` varchar(20) DEFAULT NULL,
            `action` varchar(5) DEFAULT 'email',
            `alert` varchar(5) DEFAULT '0',
            `counts` int(11) NOT NULL DEFAULT 0,
            `emails` varchar(50) DEFAULT NULL,
            `enable` tinyint(1) DEFAULT 1,
            PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
        $conn->execute("CREATE TABLE IF NOT EXISTS `formbuilder_datas` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `formbuilder_id` int(11) DEFAULT NULL,
            `data` text DEFAULT NULL,
            `field` text DEFAULT NULL,
            `ips` varchar(20) DEFAULT NULL,
            `user_id` int(11) DEFAULT NULL,
            `created` datetime NOT NULL,
            PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
        $conn->execute("CREATE TABLE IF NOT EXISTS `formbuilder_items` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `formbuilder_id` int(11) NOT NULL,
            `data` text DEFAULT NULL,
            `css` text DEFAULT NULL,
            `logo` text DEFAULT NULL,
            `uinfo` text DEFAULT NULL,
            `footer` text DEFAULT NULL,
            `submit` text DEFAULT NULL,
            PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;COMMIT;");
    }
    public function deactivation( $drop = false){
        if($drop == true){
            $conn = \Cake\Datasource\ConnectionManager::get('default');
            $conn->execute("DROP TABLE IF EXISTS `formbuilders`;");
            $conn->execute("DROP TABLE IF EXISTS `formbuilder_datas`;");
            $conn->execute("DROP TABLE IF EXISTS `formbuilder_items`;");
        }
    }
    public function config(){
        return [
            'name'=>'Formbuilder',
            'title'=>__d('Formbuilder', 'فرم ساز'),
            'icon'=>'fa fa-item',
            'description'=>__d('Formbuilder', 'ساخت آنلاین فرم و ثبت اطلاعات'),
            'author'=>'Mahan',
            'version'=>'1.0',
            'path' =>[
                'index' =>'',
                'admin' =>'/admin/formbuilder/home',
                'setting' =>'',
                ]
        ];
    }
}
