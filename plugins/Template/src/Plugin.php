<?php
namespace Template;
use Cake\Core\BasePlugin;
use Cake\Core\PluginApplicationInterface;
use Admin\View\Helper\FuncHelper;
use Cake\Console\CommandCollection;
use Cake\Core\ContainerInterface;
use Cake\Http\MiddlewareQueue;
use Cake\Routing\Route\DashedRoute;
use Cake\Routing\RouteBuilder;

class Plugin extends BasePlugin
{
    public $name= 'Template';
    function post_type(){
        return [
            'challenges'=>array(
                'name'=>array(
                    'title'=>'جمع سپاری',
                    'index_header'=>'جمع سپاری','index_add'=>'ثبت جدید',
                    'single_add'=>'جمع سپاری جدید','single_edit'=>'ویرایش اطلاعات',
                    'cat_header'=>'دسته بندی جمع سپاری ها','cat_add'=>'ثبت دسته اطلاعات',
                    'tag_header'=>'برچسب',
                ),
                'title'=>true,'editor'=>true,'excerpt'=>true,'author'=>true,'thumbnail'=>true,
                'comments'=>true,'tag'=>true,'category'=>true,'show_in_menu'=>true,
                'position'=>101,
            ),
            'knowledge'=>array(
                'name'=>array(
                    'title'=>'پایگاه دانش',
                    'index_header'=>'پایگاه دانش','index_add'=>'ثبت جدید',
                    'single_add'=>'پایگاه دانش جدید','single_edit'=>'ویرایش اطلاعات',
                    'cat_header'=>'دسته بندی','cat_add'=>'ثبت دسته اطلاعات',
                    'tag_header'=>'برچسب',
                ),
                'title'=>true,'editor'=>true,'excerpt'=>true,'author'=>true,'thumbnail'=>true,
                'comments'=>true,'tag'=>true,'category'=>true,'show_in_menu'=>true,
                'position'=>102,
            ),
            'multimedia'=>array(
                'name'=>array(
                    'title'=>'چندرسانه ای',
                    'index_header'=>'چندرسانه ای','index_add'=>'ثبت جدید',
                    'single_add'=>'چندرسانه ای جدید','single_edit'=>'ویرایش اطلاعات',
                    'cat_header'=>'دسته بندی','cat_add'=>'ثبت دسته اطلاعات',
                    'tag_header'=>'برچسب',
                ),
                'title'=>true,'editor'=>true,'excerpt'=>true,'author'=>true,'thumbnail'=>true,
                'comments'=>true,'tag'=>true,'category'=>true,'show_in_menu'=>true,
                'position'=>103,
            ),
            'topics'=>array(
                'name'=>array(
                    'title'=>'موضوعات',
                    'index_header'=>'موضوعات','index_add'=>'ثبت جدید',
                    'single_add'=>'موضوعات جدید','single_edit'=>'ویرایش اطلاعات',
                    'cat_header'=>'دسته بندی موضوعات','cat_add'=>'ثبت دسته اطلاعات',
                    'tag_header'=>'برچسب',
                ),
                'title'=>true,'editor'=>true,'excerpt'=>true,'author'=>true,'thumbnail'=>true,
                'comments'=>true,'tag'=>true,'category'=>true,'show_in_menu'=>true,
                'position'=>104,
            ),
        ];
    }

    function post_widget( $menu_type = 'post'){
        switch ($menu_type) {
            case 'dashboard': break;
            case 'sidebar': break;
            case 'widget':break;
            case 'elementor':return self::elementor();break;
            case 'category':
                return [
					/* ['locations'=>'Template.Meta::locations_cat'],*/
				];break;
            default:
                return [
                    ['knowledge' => 'Template.Meta::knowledge'],
                    ['topics' => 'Template.Meta::topics'],
                    ['multimedia' => 'Template.Meta::multimedia'],
                    /* ['sources' => 'Template.Meta::sources'],
                    ['organizations' => 'Template.Meta::organizations'],
                    ['topics' => 'Template.Meta::topics'],
                    ['models' => 'Template.Meta::models'],
                    ['dashboard' => 'Template.Meta::dashboard'],
                    ['impacts' => 'Template.Meta::impacts'], */
                    ['page' => 'Template.Meta::page'],
                ]; break;
        }
        return [];
    }

    private function elementor(){
        return [
            'تیتر پر اهمیت'=>'
            <!---- block start -----><blockquote>
                <h5 class="title">عنوان</h5>
                <p>توضیحات</p>
            </blockquote><!---- block end ----->',
        ];
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

    public function preload(){
        define('template_slug','tadbir');
        /* FuncHelper::do_action('excplgn', [
            //'Lms',
            'Shop'
        ]); */
        FuncHelper::do_action('post_type',self::post_type());
        FuncHelper::do_action('admin_sidemenu', self::posttype_adminmenu());
        FuncHelper::do_action('admin_postwidget', self::post_widget('post'));
        FuncHelper::do_action('admin_catswidget', self::post_widget('category'));
        //FuncHelper::do_action('register_widgets', self::post_widget('widget'));
        //FuncHelper::do_action('register_sidebars', self::post_widget('sidebar'));
        FuncHelper::do_action('post_elementor', self::post_widget('elementor'));
    }
    public function activation(){
        //ALTER TABLE `` ADD `` VARCHAR(200) NULL AFTER ``;
    }
    public function deactivation( $drop = false){}
    public function config(){
        return [
            'name'=>'Template',
            'title'=>'قالب جمع سپاری تدبیر',
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
                'name'=>'قالب تدبیر',
                'info'=>'قالب تدبیر',
                'version'=>'1.0',
                'author'=>'ماهان',
            ],
            'image_size'=> [    //(options: exact, portrait, landscape, auto, crop)
                //'index'=>['width'=>'500','height'=>'500','mode'=>'auto'],
            ]
        ];
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