<?php
namespace Mpdfs;
use Cake\Core\BasePlugin;
class Plugin extends BasePlugin {
    public $name= 'Mpdfs';
    public function preload(){}
    public function activation(){}
    public function deactivation($drop = false){}
    public function config(){
        return [
            'name'=>'Mpdfs',
            'title'=>'پی دی اف ساز (Pdf)',
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
