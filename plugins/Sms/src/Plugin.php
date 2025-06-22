<?php
namespace Sms;
use Cake\Core\BasePlugin;
use Admin\View\Helper\FuncHelper;
use Cake\Console\CommandCollection;
use Cake\Core\ContainerInterface;
use Cake\Core\PluginApplicationInterface;
use Cake\Http\MiddlewareQueue;
use Cake\Routing\Route\DashedRoute;
use Cake\Routing\RouteBuilder;
use Sms\sms;

class Plugin extends BasePlugin
{
    public $name= 'Sms';
    public function options($type) {
        switch ($type) {
            case 'register':
                return [
                    'register_with_sms' => [
                        'name'=>'register_with_sms',
                        'type'=>'select',
                        'options'=>[
                            1 =>__d('Sms', 'تایید'), 
                            0 =>__d('Sms', 'عدم تایید')
                        ],
                        'title' => __d('Sms', 'تایید شماره موبایل هنگام ثبت نام'),
                        'after' => '<small><a href="'.\Cake\Routing\Router::url('/admin/sms/').'">' .
                                __d('Sms', 'تنظیمات پلاگین') .'</a></small>',
                    ],
                ];
            case 'register_form':
                if (FuncHelper::Option2Get('register_with_sms') == 1 and 
                    FuncHelper::Option2Get('register_type') != 'mobile' ) 
                return [
                    'SmsValidations.mobile' => [
                        'name'=>'SmsValidations.mobile',
                        'pholder'=>'09',
                        //'required' =>'required',
                        'class' =>'ltr',
                        'title' => __d('Sms', 'شماره موبایل'),
                        'after' =>__d('Sms', 'کدتایید به شماره موبایلتان ارسال خواهد شد'),
                    ],
                ];
        }
    }
    public function notification() {
        $class = new Sms();
    }
    public function preload() {
        FuncHelper::do_action('options_register', self::options('register'));
        FuncHelper::do_action('options_registerform', self::options('register_form'));
    }
    public function activation() {
        $conn = \Cake\Datasource\ConnectionManager::get('default');
        $conn->execute("CREATE TABLE IF NOT EXISTS `sms_logs` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `mobile` varchar(20) NOT NULL,
            `message` varchar(200) NOT NULL,
            `sender` varchar(15) NOT NULL,
            `created` datetime NOT NULL,
            PRIMARY KEY (`id`)
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8;" );
          
        $conn->execute("CREATE TABLE IF NOT EXISTS `sms_validations` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `user_id` int(11) NOT NULL,
                `mobile` varchar(11) DEFAULT NULL,
                `code` varchar(10) DEFAULT NULL,
                `status` tinyint(1) NOT NULL DEFAULT 0,
                `created` datetime NOT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

            ALTER TABLE `sms_logs` ADD `terminal` VARCHAR(10) NULL AFTER `sender`;
            ALTER TABLE `sms_logs` ADD `status` VARCHAR(25) NULL AFTER `terminal`;
            ALTER TABLE `sms_logs` CHANGE `message` `message` VARCHAR(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL;
            ALTER TABLE `sms_logs` CHANGE `message` `message` VARCHAR(500) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;
            ALTER TABLE `sms_logs` ADD `status_text` VARCHAR(200) NULL AFTER `status`;
            ALTER TABLE `sms_logs` ADD `error` VARCHAR(20) NULL AFTER `status`;
            ALTER TABLE `sms_logs` CHANGE `status_text` `error_text` VARCHAR(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;
            COMMIT;");
    }
    public function deactivation( $drop = false) {
        if ($drop == true) {
            $conn = \Cake\Datasource\ConnectionManager::get('default');
            $conn->execute("DROP TABLE IF EXISTS `sms_logs`;");
            $conn->execute("DROP TABLE IF EXISTS `sms_validations`;");
        }
    }
    public function do_sql(){
        'ALTER TABLE `sms_validations` CHANGE `user_id` `user_id` INT(11) NULL;';
    }
    public function config(){
        return [
            'name'=>'Sms',
            'title'=> __d('Sms', 'سامانه پیامک'),
            'icon'=>'fa fa-item',
            'description'=> __d('Sms', 'مدیریت ارسال پیامک از سیستم'),
            'author'=>'Mahan',
            'version'=>'1.0',
            'path' =>[
                'index' =>'',
                'admin' =>'/admin/sms/',
                'setting' =>'',
                ]
        ];
    }

public function routes(RouteBuilder $routes): void
    {
        $routes->plugin(
            'Sms',
            ['path' => '/admin/sms/'],
            function (RouteBuilder $builder) {
                $builder->connect('/', ['controller' => 'Home']);
                $builder->connect('/log', ['controller' => 'Home','action'=>'logs']);
                $builder->connect('/setting', ['controller' => 'Home','action'=>'setting']);
                $builder->connect('/sendsms', ['controller' => 'Home','action'=>'sendsms']);
                $builder->fallbacks();
            }
        )
        ->plugin(
            'Sms',
            ['path' => '/sms/'],
            function (RouteBuilder $builder) {
                $builder->connect('/activation/activate', ['controller' => 'View','action'=>'active']);
                $builder->connect('/activation/', ['controller' => 'View']);
                $builder->connect('/autoactivate', ['controller' => 'View','action'=>'autoactivate']);
                $builder->connect('/', ['controller' => 'View']);
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