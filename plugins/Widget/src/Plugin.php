<?php
namespace Widget;
use Cake\Core\BasePlugin;

class Plugin extends BasePlugin
{
    public $name= 'Widget';
    function options_role(){
        return [
            'plugin' => self::config()['name'] ,
            'title' => self::config()['title'],
            'role'=> [
                'Home' => [
                    'title' =>__d('Widget','تنظیمات'),
                    'action' => [
                        'index'=>__d('Widget','لیست ویجت'),
                        'add'=>__d('Widget','افزودن (اجباری)'),
                        'items'=>__d('Widget','ابزارک ها (اجباری)'),
                    ]
                ],
            ]
        ];
    }
    public function preload(){
        \Admin\View\Helper\FuncHelper::do_action('options_role', self::options_role());
    }
    public function activation(){
        $conn = \Cake\Datasource\ConnectionManager::get('default');
        $conn->execute("CREATE TABLE IF NOT EXISTS `widgets` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `title` varchar(50) NOT NULL,
            `slug` varchar(50) NOT NULL,
            `created` datetime NOT NULL,
            PRIMARY KEY (`id`)
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");

        $conn->execute("CREATE TABLE IF NOT EXISTS `widget_forms` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `widgets_id` int(11) NOT NULL,
            `title` varchar(50) NOT NULL,
            `data` text NOT NULL,
            PRIMARY KEY (`id`)
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
          COMMIT;");
    }
    public function deactivation( $drop = false){
        if($drop == true){
            $conn = \Cake\Datasource\ConnectionManager::get('default');
            $conn->execute("DROP TABLE IF EXISTS `widgets`;");
            $conn->execute("DROP TABLE IF EXISTS `widget_forms`;");
        }
    }
    public function config() {
        return [
            'name'=>'Widget',
            'title'=>__d('Widget','ابزارک ها'),
            'icon'=>'fa fa-item',
            'description'=>__d('Widget','مدیریت ابزارک'),
            'author'=>'Mahan',
            'version'=>'1.0',
            'path' => [
                'index' =>'',
                'admin' =>'/admin/widget/',
                'setting' =>'',
                ]
        ];
    }
}