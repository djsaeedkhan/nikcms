<?php
namespace Template;
use Cake\Core\BasePlugin;
use Cake\Core\PluginApplicationInterface;
use Admin\View\Helper\FuncHelper;
//use Cake\Routing\Router;
use Admin\Core\Shortcode;

class Plugin extends BasePlugin
{
    public $name= 'Template';
    function post_type(){
        return [
            
        ];
    }

    function post_widget( $menu_type = 'post'){
        switch ($menu_type) {
            case 'dashboard': break;
            case 'sidebar': break;
            case 'widget':break;
            case 'category':
                return [
					/* ['locations'=>'Template.Meta::locations_cat'],*/
				];break;
            default:
                return [
                    ['page' => 'Template.Meta::page'],
                ]; break;
        }
        return [];
    }

    private function elementor(){
        return [];
    }

    function posttype_adminmenu(){
        $menu = [];
        foreach($this->post_type() as $post_type => $value ){
            $data = [
                $value['position']=>[
                    'title'=>$value['name']['title'],
                    'link'=>[
                        'plugin'=>'admin',
                        'controller'=>'Posts',
                        'action'=>'index',
                        '?'=>['post_type'=>$post_type]],
                    'has_sub'=>true,
                    'icon'=>'chevron-right',
                    'show_in_menu'=>$value['show_in_menu'],
                    'sub_menu'=>[],
                ],
            ];
            if($value['name']['index_header'] != ''){
                $data[$value['position']]['sub_menu'][1] =[
                    'title'=>$value['name']['title'],
                    'link'=>[
                        'plugin'=>'admin',
                        'controller'=>'Posts',
                        'action'=>'index',
                        '?'=>['post_type'=>$post_type]],
                ];
            }
            if($value['name']['single_add'] != ''){
                $data[$value['position']]['sub_menu'][2] =[
                    'title'=>$value['name']['single_add'],
                    'link'=>[
                        'plugin'=>'admin',
                        'controller'=>'Posts',
                        'action'=>'add',
                        '?'=>['post_type'=>$post_type]],
                ];
            }
            if($value['category']){
                $data[$value['position']]['sub_menu'][3] = [
                    'title'=>$value['name']['cat_header'],
                    'link'=>[
                        'plugin'=>'admin',
                        'controller'=>'Categories',
                        'action'=>'index',
                        '?'=>['post_type'=>$post_type]],
                ];
            }
            if($value['tag']){
                $data[$value['position']]['sub_menu'][4] = [
                    'title'=>$value['name']['tag_header'],
                    'link'=>[
                        'plugin'=>'admin',
                        'controller'=>'Tags',
                        'action'=>'index',
                        '?'=>['post_type'=>$post_type]],
                ];
            }
            $menu += $data;
        }
        return $menu;
    }

    function shortcode(){
        return [
            'code_tchart' => 'Template.View',
        ];
    }

    public function preload(){
        define('template_slug','zarphampay');
        FuncHelper::do_action('excplgn', [
            'Challenge','Lms','Slider','Breadcrumb','Currencybase','Thumbnail','Sitemap','Rss','RegisterField','Prints', 'Elementor',
            'Backup','CsvView','Help','Ticketing','Mpdfs','Mpdf','Filemanager','Websocket','OnlineChat',
            'Shareit','Contact','DatabaseBackup','Newsletter','Poll','Rating','Security','Seo','Tinyurl','StopSpam']);
        FuncHelper::do_action('post_type',self::post_type());
        FuncHelper::do_action('admin_sidemenu', self::posttype_adminmenu());
        FuncHelper::do_action('admin_postwidget', self::post_widget('post'));
        FuncHelper::do_action('admin_catswidget', self::post_widget('category'));
        //FuncHelper::do_action('register_widgets', self::post_widget('widget'));
        //FuncHelper::do_action('register_sidebars', self::post_widget('sidebar'));
        //FuncHelper::do_action('post_elementor', self::post_widget('elementor'));

        FuncHelper::do_action('shortcode', self::shortcode());
    }
    public function activation(){
        //ALTER TABLE `` ADD `` VARCHAR(200) NULL AFTER ``;
    }
    public function deactivation( $drop = false){}
    public function config(){
        return [
            'name'=>'Template',
            'title'=>'قالب فروشگاه زرفام',
            'icon'=>'',
            'description'=>'',
            'author'=>'Mahan',
            'version'=>'1.0',
            'path' =>[
                'index' =>'',
                'admin' =>'',
                'setting' =>'/admin/Themes/template/',
            ],
            'template'=>[
                'slug'=>'Template',
                'image'=> '/template/images/template.jpg',
                'name'=>'قالب فروشگاه زرفام',
                'info'=>'قالب فروشگاه زرفام',
                'version'=>'1.0',
                'author'=>'ماهان',
            ],
            'image_size'=> [    //(options: exact, portrait, landscape, auto, crop)
                //'index'=>['width'=>'500','height'=>'500','mode'=>'auto'],
            ]
        ];
    }
}