<?php
namespace Tinyurl;
use Cake\Core\BasePlugin;

class Plugin extends BasePlugin
{
    public $name= 'Tinyurl';
    function options_role(){
        return [
            'plugin' => self::config()['name'] ,
            'title' => self::config()['title'],
            'role'=> [
                'Home' => [
                    'title' => __d('Tinyurl','تنظیمات'),
                    'action' => [
                        'index'=> __d('Tinyurl','صفحه اصلی'),
                        'add'=> __d('Tinyurl','افزودن لینک'),
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
        $conn->execute("CREATE TABLE IF NOT EXISTS `tinyurls` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `title` text NOT NULL,
            `slug` text NOT NULL,
            `link` text NOT NULL,
            `category` int(11) NOT NULL,
            `expire` int(11) NOT NULL,
            `status` tinyint(1) NOT NULL,
            `views` int(11) NOT NULL,
            `created` datetime NOT NULL,
            PRIMARY KEY (`id`)
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='tinyurls';
          COMMIT;");
    }
    public function deactivation( $drop = false){
        if($drop == true){
            $conn = \Cake\Datasource\ConnectionManager::get('default');
            $conn->execute("DROP TABLE IF EXISTS `tinyurls`;");
        }
    }
    public function config(){
        return [
            'name'=>'Tinyurl',
            'title'=>__d('Tinyurl','کوتاه کننده لینک'),
            'icon'=>'fa fa-item',
            'description'=> __d('Tinyurl','مدیریت کوتاه کننده لینک'),
            'author'=>'Mahan',
            'version'=>'1.0',
            'path' =>[
                'index' =>'',
                'admin' =>'/admin/url/',
                'setting' =>'',
                ]
        ];
    }
}
