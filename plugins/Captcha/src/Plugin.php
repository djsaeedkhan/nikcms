<?php
namespace Captcha;
use Cake\Core\BasePlugin;

class Plugin extends BasePlugin
{
    public $name= 'Captcha';
    public function preload(){}
    public function activation(){}
    public function deactivation( $drop = false){}
    public function config(){
        return [
            'name'=>'Captcha',
            'title'=>'کدکپچا',
            'icon'=>'fa fa-item',
            'description'=>'نمایش کدکپچا در مکان های مورد نیاز سایت',
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
