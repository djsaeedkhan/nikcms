<?php
namespace Thumbnail;
use Cake\Core\BasePlugin;
use Admin\View\Helper\FuncHelper;

class Plugin extends BasePlugin {
    public $name= 'Thumbnail';
    public function preload(){}
    public function activation(){}
    public function deactivation($drop = false){}
    public function config(){
        return [
            'name'=>'Thumbnail',
            'title'=>'بازسازی تصاویر بندانگشتی',
            'icon'=>'fa fa-item',
            'description'=>'',
            'author'=>'Mahan',
            'version'=>'1.0',
            'path' =>[
                'index' =>'',
                'admin' =>'/admin/thumbnail/home/index/',
                'setting' =>'',
                ]
        ];
    }
}
