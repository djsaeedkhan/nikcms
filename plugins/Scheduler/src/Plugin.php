<?php
namespace Scheduler;
use Cake\Core\BasePlugin;
use Admin\View\Helper\FuncHelper;
//use \RegisterField\RField;

class Plugin extends BasePlugin {
    public $name= 'Scheduler';
    public function preload(){}
    public function activation(){
        $conn = \Cake\Datasource\ConnectionManager::get('default');
        $conn->execute("
            CREATE TABLE IF NOT EXISTS `cronjobs` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `name` varchar(100) NOT NULL,
                `plugin` varchar(100) DEFAULT NULL,
                `status` tinyint(4) DEFAULT 1,
                `result` text DEFAULT NULL,
                `created` datetime NOT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;
        ");
    }
    public function deactivation($drop = false){}
    public function config(){
        return [
            'name'=>'Scheduler',
            'title'=>'مدیریت زمانبندی فرآیند',
            'icon'=>'fa fa-item',
            'description'=>'',
            'author'=>'Mahan',
            'version'=>'1.0',
            'path' =>[
                'index' =>'',
                'admin' =>'/admin/scheduler',
                'setting' =>'',
                ]
        ];
    }
}
