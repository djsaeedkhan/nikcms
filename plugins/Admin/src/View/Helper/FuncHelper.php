<?php
declare(strict_types=1);

namespace Admin\View\Helper;

use \Cake\View\Helper;
use Cake\ORM\TableRegistry;
use Cake\Core\Plugin;
use Cake\I18n\I18n;
use Cake\Routing\Router;
//use Cake\Log\Log;
use Admin\Core\Resize;

/**
 * Func helper
 */
class FuncHelper extends Helper
{
    public $helpers = ['Html','Form','Query','Url'];
    protected $_defaultConfig = [];
    /* ------------------------ Post */
    function show_post_thumbnail($data = null, $size = 'thumbnail'){
        if(isset($data['post_metas'])){
            $list = [];
            foreach($data['post_metas'] as $meta){
                if( $meta->meta_type == 'image-size' or $meta->meta_type == 'url' ){
                    $list[$meta->meta_key] = $meta['meta_value'];
                }
            }
            if(isset($list[$size]) and $list[$size] != "")
                return $list[$size];
            else
                return isset($list["full"])?$list["full"]:'';
        }

        if(isset($data['url']) and $data['url'] != ''){
            $img = explode("/",$data['url']);
            //$img = TableRegistry::getTableLocator()->get('Admin.Posts')->find('list',['keyField'=>'id','valueField'=>'title'])
        }
    }
    /* ------------------------  */
    function Urls($name = null){
        switch ($name) {
            case 'register':
                if( ($url = FuncHelper::OptionGet('register_linkurl'))!= '')
                    return $url;
                else
                    return Router::url(['plugin'=>false,'controller'=>'Users','action'=>'Register'], true );
                break;
            
            default:
                # code...
                break;
        }
    }
    /* ------------------------  */
    function predata($title){
        switch ($title) {
            case 'yesno':
                return [
                    0 => __d('Admin', 'خیر'),
                    1 => __d('Admin', 'بله')
                ];
                break;
            case 'userGroup':
                return [
                    1 =>__d('Admin', 'کاربر ادمین'),
                    2 =>__d('Admin', 'کاربر همکار'),
                    3 =>__d('Admin', 'کاربر عضو')
                ];
                break;
                
            case'enable':
                return [ 
                    0 => __d('Admin', 'غیرفعال'), 
                    1 => __d('Admin', 'فعال')
                ];
                break;

            case 'post_publish_list':
                return [ 
                    0 => __d('Admin', 'پیش نویس') , 
                    1 => __d('Admin', 'منتشر شده')
                ];
                break;

            case 'post_show_list':
                return [ 
                    1 => __d('Admin', 'عمومی'), 
                    2 => __d('Admin', 'خصوصی') , 
                    3 => __d('Admin', 'رمزدار')
                ];
                break;

            case 'user_role':
                return TableRegistry::getTableLocator()->get('roles')
                    ->find('list',['keyField'=>'id','valueField'=>'title']);
                break;
            case 'role_list':
                
            default:
                # code...
                break;
        }
    }
    /* ------------------------  */
    function LogSave($group_id = null, $act = null, $value = null){
        $model = TableRegistry::getTableLocator()->get('logs');
        $model->save( $model->newEmptyEntity([
                'user_id' => $this->request->getAttribute('identity')->get('id'),
                'group_id'  => $group_id,
                'action_id' => $act,
                'value' => ($value!=null?$value:''),
            ]));
        return true;
    }
    /* ------------------------  */
    function LogList($group_id = null, $action_id = null){
        $data=[
            'post'=>[
                '1'=>'post insert',
                '2'=>'post update',
                '3'=>'post delete',
            ],
            'media'=>[
                '1'=>'Media Add',
                '2'=>'Media Delete',
            ],
            'comment'=>[
                '1'=>'Comment accept/deaccept',
                '2'=>'Comment edit',
                '3'=>'Comment delete',
            ],
            'option'=>[
                '1'=>'Option add/edit',
            ],
            'template'=>[
                '1'=>'Template change',
                '2'=>'Menu change',
            ],
            'user'=>[
                '1'=>'User Add',
                '2'=>'User Edit',
                '3'=>'User Delete',
                '4'=>'<span class="label label-success">User Login</span>',
                '5'=>'User Logout',
                '6'=>'<span class="label label-danger">User Login Failed</label>',
            ]
        ];
        if($group_id != null)
            return $data[$group_id][$action_id];
        return $data;
    }
    /* ------------------------ Admin Menu */
    function admin_menu_is_current($index = null, $here = null){
        $temp = ModuleHelper::admin_sidemenu();
        $menu = $temp[$index];
        if(Router::url($menu['link'], true ) == $here) return 1;
        foreach($menu['sub_menu'] as $mv){
            try {
                if(Router::url($mv['link'], true ) == $here) return 1;
            } catch (\Throwable $th) {
                return 0;
            }
            
        }
        //return 0;
    }
    /* ------------------------  */
    //1397-9
    public function plugin_total_list(){
        return explode(',',FuncHelper::OptionGet('st__plugin_avlist'));
    }
    public function plugin_available($name = null){
        $data = (unserialize(FuncHelper::OptionGet('plugin_available_list')));
        if($name != null)
            return in_array($name ,$data)? true : false;
        else
            return ($data);
    }
    //1398-8-4
    public function plugin_data(){
        $data = [];
        $available = FuncHelper::plugin_available();
        foreach(Plugin::getCollection() as $k => $app){
            if(in_array($app->getName(),$available)){
                $data[$k] = $app;
            }
        }
        return $data;
    }
    //1397-6
    //edit 1401/11/24
    public function plugin_getlist(){
        $data = [];
        $apps = Plugin::getCollection();
        $available = FuncHelper::plugin_available();
        foreach($apps as $app){
            if($app->getName()!= false and $app->getName() != 'StopSpam' ){ 
                try {
                    $data[] = $app->config($app->getName());
                } catch (\Throwable $th) {
                    //throw $th;
                } 
            }
        }
        return $data;
    }
    /* --------------------------------------  */
    /* --------------------------------------  */
    public function admin_navmenu(){
        return ModuleHelper::admin_navmenu();
    }
    public function admin_postwidget($post_type = null , $MenuType = 'post'){ //post , widget , category
        $data = [];
        if($MenuType == 'post')
            $widget = ModuleHelper::admin_postwidget();
        elseif($MenuType == 'category')
            $widget = ModuleHelper::admin_catswidget();
        
        if($widget){
            foreach($widget as $k1 => $v1){
                if($v1){
                    foreach($v1 as $k2 => $v2){
                        if($k2 == $post_type)
                        $data[] = $widget[$k1];
                    }
                }
            }
        }
        return $data;
    }
    /* --------------------------------------  */
    /* --------------------------------------  */
    //update 1398-8-12
    public function posttype_list($options = []){ //options->reading
        /*
            options:
            type : [list_key: key,value are equal]
        */
        $list = [];
        foreach(($data = ModuleHelper::post_type()) as $key => $data){
            if(isset($options['type']) and $options['type'] == "list_key"){
                $list[$key] = $key;
            } else{
                $list[$key] = isset($data['name']['title'])?$data['name']['title']:$key;
            }
        }
        //ksort($list);
        return $list;
    }
    /* --------------------------------------  */
    /* --------------------------------------  */
    public function get_label($post_type = null , $label = null){
        $type = ModuleHelper::post_type();
        return isset($type[$post_type]['name'][$label])?$type[$post_type]['name'][$label]:'-';
    }
    public function get_ptaccess($post_type = null , $label = null){
        $type = ModuleHelper::post_type();
        return isset($type[$post_type][$label])?$type[$post_type][$label]:'-';
    }
    /* --------------------------------------  */
    /* --------------------------------------  */
    public function OptionSave($name = null , $value = null , $action = null){
        $model = TableRegistry::getTableLocator()->get('Admin.Options');
        $existing = $model->findByName($name);

        if($existing->count()) {
            $model->save($model->newEmptyEntity([
                'id' => $existing->first()['id'],
                'name'  => $name,
                'value' => $value,
            ]));
            return true;
        }
        if(!$existing->count() and $action =='create'){
            $model->save($model->newEmptyEntity([
                'name'  => $name,
                'value' => $value,
            ]));
            return true;
        }
        return false;
    }
    public function OptionGet($name = null , $opt = []){

        global $current_lang;
        global $options;

        if (!empty($current_lang) && is_string($current_lang))
            I18n::setLocale($current_lang);

        if(is_array($options)){
            $data = $options;
        }
        else{
            if(isset($opt['lang']) and $opt['lang'] == 1)
                $model = TableRegistry::getTableLocator()->get('Admin.Options2'); 
            else
                $model = TableRegistry::getTableLocator()->get('Admin.Options');
            $options = $data = $model->find('list', ['keyField' => 'name','valueField' => 'value'])
                    ->select(['name','value'])
                    //->where(['name'=>$name])
                    ->toarray();
        }
        
        if(isset($data[$name])) {
            //$this->is_serial()
            return $data[$name];
        }
        else 
            return false; 
    }
    public static function Option2Get($name = null){
        $Options = TableRegistry::getTableLocator()->get('Admin.Options');
        $existing = $Options->findByName($name);
        if($existing->count()) {
            return $existing->first()->toArray()['value'];
        }
        else 
            return false; 
    }
    /* --------------------------------------  */
    /* --------------------------------------  */
    //admin plugin, post add , get thumbnail
    //review 1398-8-12
    public function PostGet($id = null){ 
        $existing = [];
        try{
            $existing = TableRegistry::getTableLocator()->get('Posts')->find('all')
                ->select(['id','image','title'])
                ->where(['id'=>$id])
                ->first();
                /* ->toarray() */

            $existing['post_metas'] = TableRegistry::getTableLocator()->get('PostMetas')
                ->find('list', ['keyField' => 'meta_key','valueField' => 'meta_value'])
                ->where(['post_id'=>$id])
                ->toarray();
        }
        catch (\Exception $e) {
            $existing = [];
        }

        return ($existing);
    }
    public function PostMetaSave($id = null , $options = array()){
        $source = isset($options['source'])?$options['source']:null;
        $type = isset($options['type'])?$options['type']:null;
        $name = isset($options['name'])?$options['name']:null;
        $value = isset($options['value'])?(is_array($options['value'])?serialize($options['value']):$options['value']):null;
        $action = isset($options['action'])?$options['action']:null;
        $call_id = 'post_id';

        if($source == 'category'){
            $PostMetas = TableRegistry::getTableLocator()->get('CategorieMetas');
            $call_id = 'categorie_id';
        }
        elseif($source == 'users'){
            $PostMetas = TableRegistry::getTableLocator()->get('Admin.UserMetas');
            $call_id = 'user_id';
        }
        else
            $PostMetas = TableRegistry::getTableLocator()->get('Admin.PostMetas');

        $existing = $PostMetas->find('all')->where([
            $call_id  => $id,
            'meta_key'=>$name ]);
  
        if($existing->count()) {
            $temp = $existing->first();
            $temp->meta_value = $value;
            $p = $PostMetas->save($temp);
            return true;
        }
        if(!$existing->count() and $action =='create'){
            $p = $PostMetas->save($PostMetas->newEmptyEntity([
                $call_id  => $id,
                'meta_key'  => $name,
                'meta_value' => $value,
                'meta_type' => $type,
            ]));
            return true;
        }
        return false;
    }
    /* --------------------------------------  */
    //1398/09/18
    public function get_usermeta($name = null){
        $user = $this->getView()->getRequest()->getSession()->read('Auth.User');
        if(isset($user['user_metas'])){
            foreach($user['user_metas'] as $meta){
                if($meta['meta_key'] == $name)
                    return $meta['meta_value'];
            }
        }
    }
    /* --------------------------------------  */
    public function MetaList($data = null , $type = null){
        $result=array();
        if($type == 'category' or isset($data['categorie_metas'])):
            foreach($data['categorie_metas'] as $d){if(isset($d['meta_key'])): 
                if($this->is_serial($d['meta_value'])){
                    $temp = array();
                    foreach(unserialize($d['meta_value']) as $i )
                        $temp[$i] = $i;
                    $result[$d['meta_key']]= $temp;
                }
                else
                    $result[$d['meta_key']] = $d['meta_value'];
                endif;
            }
            return $result;
        
        elseif($type == 'users' or isset($data['user_metas']) ):
            foreach($data['user_metas'] as $d){
                if(isset($d['meta_key'])): 
                    if($this->is_serial($d['meta_value'])){
                        $temp = array();
                        foreach(unserialize($d['meta_value']) as $i )
                            $temp[$i] = $i;
                        $result[$d['meta_key']]= $temp;
                    }
                    else
                        $result[$d['meta_key']] = $d['meta_value'];
                endif;
            }
            return $result;
        
        elseif(isset($data['post_metas'])):
            foreach($data['post_metas'] as $d){if(isset($d['meta_key'])):
                $result[$d['meta_key']] = $this->is_serial($d['meta_value'])?unserialize($d['meta_value']):$d['meta_value'];
                endif;
            }
        elseif(isset($data['shop_product_metas'])):
            foreach($data['shop_product_metas'] as $d){if(isset($d['meta_key'])):
                $result[$d['meta_key']] = $this->is_serial($d['meta_value'])?unserialize($d['meta_value']):$d['meta_value'];
                endif;
            }
        endif;

        return $result;
    }
    /* --------------------------------------  */
    function is_serial( $data , $strict = true ) {
        // If it isn't a string, it isn't serialized.
        if ( ! is_string( $data ) ) {
            return false;
        }
        $data = trim( $data );
        if ( 'N;' === $data ) {
            return true;
        }
        if ( strlen( $data ) < 4 ) {
            return false;
        }
        if ( ':' !== $data[1] ) {
            return false;
        }
        if ( $strict ) {
            $lastc = substr( $data, -1 );
            if ( ';' !== $lastc && '}' !== $lastc ) {
                return false;
            }
        } else {
            $semicolon = strpos( $data, ';' );
            $brace     = strpos( $data, '}' );
            // Either ; or } must exist.
            if ( false === $semicolon && false === $brace ) {
                return false;
            }
            // But neither must be in the first X characters.
            if ( false !== $semicolon && $semicolon < 3 ) {
                return false;
            }
            if ( false !== $brace && $brace < 4 ) {
                return false;
            }
        }
        $token = $data[0];
        switch ( $token ) {
            case 's':
                if ( $strict ) {
                    if ( '"' !== substr( $data, -2, 1 ) ) {
                        return false;
                    }
                } elseif ( false === strpos( $data, '"' ) ) {
                    return false;
                }
                // Or else fall through.
            case 'a':
            case 'O':
                return (bool) preg_match( "/^{$token}:[0-9]+:/s", $data );
            case 'b':
            case 'i':
            case 'd':
                $end = $strict ? '$' : '';
                return (bool) preg_match( "/^{$token}:[0-9.E+-]+;$end/", $data );
        }
        return false;
    } 
    /* --------------------------------------  */
    public function toarr($data = null , $split = ','){
        $temp = [];
        foreach(explode($split , $data ) as $d){
            if($d != '')
            $temp [$d] = $d;
        }
        return $temp;
    }
    /* --------------------------------------  */
    public function gallery_size(){
        $size = [];
        foreach(FuncHelper::plugin_getlist() as $data):
            if(isset($data['image_size']))
                $size += $data['image_size'];
        endforeach;
        return $size;
    }
    public function language_list($id = null , $act = null){
        switch ($act) {
            case 'arr_dir':
                $arr = [
                    'fa' => 'rtl',
                    'en' => 'ltr',
                    'ar' => 'rtl',
                    'ru' => 'ltr',
                    'cn' => 'ltr',
                    'tr' => 'ltr',
                    'es' => 'ltr',
                    'fr' => 'ltr',
                ];
                break;
            
            default:
                $arr = [
                    'fa' => __d('Admin', 'فارسی'),
                    'en' => __d('Admin', 'انگلیسی'),
                    'ar' => __d('Admin', 'عربی'),
                    'ru' => __d('Admin', 'روسی'),
                    'zh' => __d('Admin', 'چینی'),
                    'tr' => __d('Admin', 'ترکیه'),
                    'es' => __d('Admin', 'اسپانیایی'),
                    'fr' => __d('Admin', 'فرانسوی'),
                ];
                break;
        }
        
        if($id == null)
            return $arr;
        else
            return isset($arr[$id])?$arr[$id]:'-';
    }
    /* --------------------------------------  */
    public function province_list($id = null , $type = null){
        $tag = $id;
        if(! is_numeric ($id))
            $id = null;
        if($type == 'keylist'){
            $arr = [
                "azerbaijan-east" =>"آذربایجان شرقی",
                "azerbaijan-west" =>"آذربایجان غربی",
                "ardabil" =>"اردبیل",
                "isfahan" =>"اصفهان",
                "alborz" =>"البرز",
                "ilam" =>"ایلام",
                "bushehr" =>"بوشهر",
                "tehran" =>"تهران",
                "chahar-mahaal-bakhtiari" =>"چهارمحال و بختیاری",
                "khorasan-south" =>"خراسان جنوبی",
                "khorasan-razavi" =>"خراسان رضوی",
                "khorasan-north" =>"خراسان شمالی",
                "khuzestan" =>"خوزستان",
                "zanjan" =>"زنجان",
                "semnan" =>"سمنان",
                "sistan-baluchestan" =>"سیستان و بلوچستان",
                "fars" =>"فارس",
                "qazvin" =>"قزوین",
                "qom" =>"قم",
                "kurdistan" =>"كردستان",
                "kerman" =>"كرمان",
                "kermanshah" =>"كرمانشاه",
                "kohgiluyeh-boyer-ahmad" =>"كهگیلویه و بویراحمد",
                "golestan" =>"گلستان",
                "gilan" =>"گیلان",
                "lorestan" =>"لرستان",
                "mazandaran" =>"مازندران",
                "markazi" =>"مركزی",
                "hormozgan" =>"هرمزگان",
                "hamadan" =>"همدان",
                "yazd" =>"یزد",];
        }elseif($type == 'keyid'){
            $arr = [
                "1"=>"azerbaijan-east",
                "2"=>"azerbaijan-west",
                "3"=>"ardabil",
                "4"=>"isfahan",
                "5"=>"alborz",
                "6"=>"ilam",
                "7"=>"bushehr",
                "8"=>"tehran",
                "9"=>"chahar-mahaal-bakhtiari",
                "10"=>"khorasan-south",
                "11"=>"khorasan-razavi",
                "12"=>"khorasan-north",
                "13"=>"khuzestan",
                "14"=>"zanjan",
                "15"=>"semnan",
                "16"=>"sistan-baluchestan",
                "17"=>"fars",
                "18"=>"qazvin",
                "19"=>"qom",
                "20"=>"kurdistan",
                "21"=>"kerman",
                "22"=>"kermanshah",
                "23"=>"kohgiluyeh-boyer-ahmad",
                "24"=>"golestan",
                "25"=>"gilan",
                "26"=>"lorestan",
                "27"=>"mazandaran",
                "28"=>"markazi",
                "29"=>"hormozgan",
                "30"=>"hamadan",
                "31"=>"yazd",
            ];
        }
        else{
            $arr = [
            1 =>"آذربایجان شرقی",
            2 =>"آذربایجان غربی",
            3 =>"اردبیل",
            4 =>"اصفهان",
            5 =>"البرز",
            6 =>"ایلام",
            7 =>"بوشهر",
            8 =>"تهران",
            9 =>"چهارمحال و بختیاری",
            10 =>"خراسان جنوبی",
            11 =>"خراسان رضوی",
            12 =>"خراسان شمالی",
            13 =>"خوزستان",
            14 =>"زنجان",
            15 =>"سمنان",
            16 =>"سیستان و بلوچستان",
            17 =>"فارس",
            18 =>"قزوین",
            19 =>"قم",
            20 =>"كردستان",
            21 =>"كرمان",
            22 =>"كرمانشاه",
            23 =>"كهگیلویه و بویراحمد",
            24 =>"گلستان",
            25 =>"گیلان",
            26 =>"لرستان",
            27 =>"مازندران",
            28 =>"مركزی",
            29 =>"هرمزگان",
            30 =>"همدان",
            31 =>"یزد",
            ];
        }

        if($id == null){
            if($tag == 'by_name'){
                $prov = [];
                foreach($arr as $prof)
                    $prov[$prof] = $prof;
                return $prov;
            }
            else
                return $arr;
        }
        else
            return isset($arr[$id])?$arr[$id]:'-';
    }
    /* --------------------------------------  */
    public function provincename_list($id = null){
        $tag = $id;
        if(! is_numeric ($id))
            $id = null;

        $arr = ["1"=>"azerbaijan-east",
                "2"=>"azerbaijan-west",
                "3"=>"ardabil",
                "4"=>"isfahan",
                "5"=>"alborz",
                "6"=>"ilam",
                "7"=>"bushehr",
                "8"=>"tehran",
                "9"=>"chahar-mahaal-bakhtiari",
                "10"=>"khorasan-south",
                "11"=>"khorasan-razavi",
                "12"=>"khorasan-north",
                "13"=>"khuzestan",
                "14"=>"zanjan",
                "15"=>"semnan",
                "16"=>"sistan-baluchestan",
                "17"=>"fars",
                "18"=>"qazvin",
                "19"=>"qom",
                "20"=>"kurdistan",
                "21"=>"kerman",
                "22"=>"kermanshah",
                "23"=>"kohgiluyeh-boyer-ahmad",
                "24"=>"golestan",
                "25"=>"gilan",
                "26"=>"lorestan",
                "27"=>"mazandaran",
                "28"=>"markazi",
                "29"=>"hormozgan",
                "30"=>"hamadan",
                "31"=>"yazd",];

        if($id == null){
            if($tag == 'by_name'){
                $prov = [];
                foreach($arr as $prof)
                    $prov[$prof] = $prof;
                return $prov;
            }
            else
                return $arr;
        }
        else
            return isset($arr[$id])?$arr[$id]:'-';
    }
    /* --------------------------------------  */
    public function PageListGet(){
        $template = FuncHelper::OptionGet('website_template');
        $files = glob(current(\Cake\Core\App::path('Template', $template)).'Content'.DS.'*.{php}', GLOB_BRACE);
        $list = [];
        foreach($files as $file) {
            $fname = basename($file,'.php');
            $line = '';
            if($f = fopen($file, 'r')){
                $line = fgets($f);
                fclose($f);
            }
            if (strpos($line, '<?php /* template name') === 0){
                $line = str_replace(['<?php',';?>','/* template name: ',' */'],'',$line);
                $field = explode('*',str_replace('template name :','',$line));
                $list[$fname] = trim($line);
            }
        }
        return $list;
    }
    //-----------------------------------------------------------------------------------------
    public function SliderListGet(){
        $slider = [];
        $temp = TableRegistry::getTableLocator()->get('PostMetas')
            ->find('list', ['keyField' => 'post_id','valueField' => 'post_id'])
            ->where([
                'meta_key' => 'show_in_slider',
                'meta_value' => 1,
                ])
            ->order(['id'=>'desc'])
            ->toarray();
        if($temp){
            $p = $this->Query->Post(null,['id'=> $temp,'contain'=>['PostMetas']]);
            global $result;
            foreach($p as $result){
                $tmp = $this->MetaList($result);
                $slider[$result['id']] = [
                    'title' => (isset($tmp['slider_title']) and $tmp['slider_title'] !="")?
                        $tmp['slider_title']:
                        $this->Query->the_title(),

                    'descr' => (isset($tmp['slider_desc']) and $tmp['slider_desc'] !="")?
                        $tmp['slider_desc']:
                        $this->Query->the_excerpt(),

                    'label' => (isset($tmp['slider_label']) and $tmp['slider_label'] !="")?
                        $tmp['slider_label']:null,    

                    'image' => (isset($tmp['slider_image']) and $tmp['slider_image'] !="")?
                        $tmp['slider_image']:
                        Router::url($this->Query->postimage('large',$result),'/'),

                    'url' => $this->Query->the_permalink(),
                ];
            }
        }
        return $slider;
    }
    //-----------------------------------------------------------------------------------------پ
    public function date2($date = null , $format = null){
        if($date == null)
            return '-';
        if(is_array($date) and isset($date['created'])){
            $date = $date['created'];
        }elseif(isset($date->created)){
            $date = $date->created;
        }
        $date = $date->format('Y-m-d H:i:s');
        return FuncHelper::mil_to_shm(date("Y-m-d", strtotime($date))) .($format == null? ' '.date(" H:i", strtotime($date)) :'');
    }
	//-----------------------------------------------------------------------------------------
    public function shm_to_mil($date = null , $sep = '-'){
		$date = explode($sep,$date);
		return jalali_to_gregorian($date[0],$date[1],$date[2],'-');
	}
	//-----------------------------------------------------------------------------------------
	public function mil_to_shm($date = null , $sep='-'){
        $date=explode($sep,$date);
        $dt=gregorian_to_jalali($date[0],$date[1],$date[2],'/');
        $dt=explode("/", $dt);
        return $dt[0].'/'.($dt[1]>9?$dt[1]:'0'.$dt[1]).'/'.($dt[2]>9?$dt[2]:'0'.$dt[2]);
	}
    /* --------------------------------------  */
    //1398-8-4
    public function widget_find($name = null){
        $data = [];
        $available = FuncHelper::plugin_available();
        foreach(FuncHelper::plugin_data() as $app){
            if(in_array($app->getName(),$available)){
                $widget = $app->post_widget('widget');
                if(array_key_exists($name , $widget)){
                    $data[array_search($widget[$name], $widget)]  = $widget[$name];
                }
            }
            
        }
        return $data;
    }
    public function widget($name = null){
        if($name == null) return;
        if(! ($widget = FuncHelper::widget_find($name)))
            return;
        echo $this->_View->cell($widget[$name]);
    }
    /* --------------------------------------  */
    //1398-8-9
    public function preload(){
        foreach(ModuleHelper::site_preload() as $c){
            echo $this->_View->cell($c);
        }
    }

    //1398-8-14
    public function header(){
        foreach(ModuleHelper::site_header() as $c)
            echo $this->_View->cell($c);
    }
    public function footer(){
        foreach(ModuleHelper::site_footer() as $c)
            echo $this->_View->cell($c);
    }
    public function Run(){
        $available = FuncHelper::plugin_available();
        foreach(FuncHelper::plugin_data() as $app){
            try {
                if(in_array($app->getName(),$available))
                    $app->preload();
            } catch (\Throwable $th) {
                //debug($app->name);
            }
        }
    }
    /* --------------------------------------  */
    //1398-8-10
    public static function do_action($action = null , $value = null){
        /* if($action == "post_type"){
            ModuleHelper::post_type($value);
        } */
		ModuleHelper::$action($value);
    }
    /* --------------------------------------  */
    public function create_form($form = [] , $result = null){
        if(! count($form)) return;
        $str = '';
        foreach($form as $name => $sm):
            if(count($sm)):
                $str .= '<div class="mb-1 col-sm-'.( isset($sm['col'])?$sm['col']:'' ).'">';
                $str .= $this->Form->control($name, [
                    'type'=> isset($sm['type'])? $sm['type']: 'text',
                    'default'=>(isset($result[$sm['name']])?$result[$sm['name']]:(isset($result[$name])?$result[$name]:false)),
                    'options'=> isset($sm['options']) ?$sm['options']: false,
                    'style'=>isset($sm['select_img'])?'padding-right: 30px;':false,
                    'empty'=> isset($sm['options']) ?'-- '.__d('Admin', 'انتخاب کنید').' --': false,
                    'placeholder'=> isset($sm['pholder'])? $sm['pholder']: false,
                    'label'=> isset($sm['title'])? $sm['title']: false,
                    'class'=> 'form-control '. (isset($sm['class'])? $sm['class']: false ),
                    'id'=> isset($sm['id'])?$sm['id']:(isset($sm['select_img'])?($sm['id'] = 'ids'. rand(1000,9999)):false),
                    'required'=> isset($sm['required'])?$sm['required']:false,
                    'data-role'=> isset($sm['data-role'])?"tags-input":false,
                    'escape'=>false,
                ]);
                if(isset($sm['select_img'])){
                    $str .= '<div class="mb-1" style="margin-top: -30px;float: right;margin-right: 10px;">'.
                        $this->Html->link('<i data-feather="camera"></i>',false,['data-toggle'=>'modal', 'data-target'=>'#exampleModal',
                        'data-action'=>'select_src', 'title'=>__d('Admin', 'انتخاب تصویر'), 'escape'=>false,'data-dest'=> $sm['id'],'style'=>'color:#9e9e9e']).'</div>';
                }
                if(isset($sm['after'])) $str .= $sm['after'];
                $str .= '</div>';
            else:
                $str .= '<hr><br>';
            endif;
        endforeach;
        return $str;
    }
    public function AllMenu(){
        return TableRegistry::getTableLocator()->get("Admin.Options")->find('list')
        ->select(['id','name'])
        ->where(['types' => 'nav_menu'])
        ->order(['id' => 'desc']);
    }
    /* --------------------------------------  */
    //1399-4-17
    public function check_role($url = null){
        $plg = strtolower( $url['plugin'] );
        $cont = strtolower( $url['controller'] );
        $act = strtolower( $url['action'] );
        $role = [];
        
        if($this->getView()->getRequest()->getSession()->read('Auth.User'))
            $role = $this->getView()->getRequest()->getSession()->read('Auth.User')['role_list'];

        if( isset($role[$plg]) ){
            if(isset($role[$plg][$cont][$act]) and $role[$plg][$cont][$act] != "0")
                return true;
            else
                return false;
        }
        return true;
    }
    /* --------------------------------------  */
    //-----------------------------------------------------------------------------------------
    public function DiffDuration($datas = null , $until = null, $current = null ){
        try{
            $end_date = '';
            foreach($datas as $data){
                if($data['active'] == 2)
                    $end_date = $data['end_date'];
            }
            if($current == 'current') return $end_date;

            if($end_date != ''){
                if (! preg_match("/^[0-9]{4}\/(0[1-9]|1[0-2])\/(0[1-9]|[1-2][0-9]|3[0-1])$/",$end_date)){
                    echo '<br><span class="badge badge-warning">'.__d('Admin', 'تاریخ نامعتبر').'</span>';
                    return '-';
                }

                $now = str_replace('/','-',FuncHelper::mil_to_shm(date("Y-m-d", strtotime(date('Y-m-d')))));
                $date1 = date_create($now);

                $date2 = date_create(str_replace('/','-',$end_date));
                $diff = date_diff($date1,$date2);
                return intval($diff->format("%R%a"));
            }
            else return '-';
        } catch (\Exception $e) {
            return '-';
        }
    }
    //-----------------------------------------------------------------------------------------
    public function DiffDate($start_date = null , $end_date = null){
        if($start_date == 'now')
            $date1 = date_create(str_replace('/','-',FuncHelper::mil_to_shm(date("Y-m-d", strtotime(date('Y-m-d'))))));
        else 
            $date1 = date_create(date("Y-m-d", strtotime($start_date)));//date_create(str_replace('/','-',$start_date));

        if($end_date == 'now')
            $date2 = date_create(date("Y-m-d", strtotime(date('Y-m-d H:i:s'))));
            //$date2 = date_create(str_replace('/','-',FuncHelper::mil_to_shm(date("Y-m-d", strtotime(date('Y-m-d'))))));
        else
            $date2 = date_create($end_date);
            
        $diff = date_diff($date1,$date2);
        return ($diff->format("%R%a"));
    }
    //-----------------------------------------------------------------------------------------
    public function DiffDateFa($start_date = null , $end_date = null){

        if($start_date == 'now')
            $start_date = date_create(date("Y-m-d"));
        else 
            $start_date = date_create(str_replace('/','-',FuncHelper::shm_to_mil($start_date,'/')));

        if($end_date == 'now')
            $end_date = date_create(date("Y-m-d"));
        else 
            $end_date = date_create(str_replace('/','-',FuncHelper::shm_to_mil($end_date,'/')));


        $interval = date_diff(
            ($start_date),
            ($end_date )
        );
        $origin = $interval->format('%R%a');
        return $interval->format("%R%a");
        /* $day = (intval($origin));
        if($end_date == 'now')
            $date2 = date_create(date("Y-m-d", strtotime(date('Y-m-d H:i:s'))));
            //$date2 = date_create(str_replace('/','-',FuncHelper::mil_to_shm(date("Y-m-d", strtotime(date('Y-m-d'))))));
        else
            $date2 = date_create($end_date);
            
        $diff = date_diff($date1,$date2);
        return ($diff->format("%R%a")); */
    }
    //-----------------------------------------------------------------------------------------
    public function getSiteSetting(){
        /*
            usage : $this->Func->getSiteSetting();
        */
        $value = null;
        $setting['hsite'] = null;
        if($this->OptionGet('lang_enable') == 1)
            $value = $this->OptionGet('setting' . (defined('template_slug')?'_'.template_slug :''),['lang'=> 1] );
        else {
            $value = $this->OptionGet('setting' . (defined('template_slug')?'_'.template_slug :'') );
        }
        
        if ($value != null) {
            try {
                if ($this->isJson($value))
                    $setting = json_decode($value,true);
                else
                    $setting = @unserialize($value);
            } catch (\Throwable $th) {
                throw $th ;
            }
        }
        //$setting = unserialize($value);

        if( ! defined('setting'))
            define("setting", (isset($setting['hsite'])?$setting['hsite']:[]) );
    }
    //-----------------------------------------------------------------------------------------
    function isJson($string = null) {
        json_decode($string);
        return json_last_error() === JSON_ERROR_NONE;
    }
    //-----------------------------------------------------------------------------------------
    public function tocsv($data = null , $header = null , $fileName = null){
        /* 
            $header = array("Book Title", "ISBN No.", "Auther");
            $data = array(
                array('Title1', '111111', '222222),
            ); 
        */

        if($fileName == null)
            $fileName = "report_".date("d-m-y:h:s").".xls";

        if($header != null)
            $fileContent = implode("\t ", $header)."\n";
        else{
            if(isset($data[0])){
                $temp = array_keys($data[0]);
                $fileContent = implode("\t ",$temp  )."\n";
            }
            else
                $fileContent = '';
        }

        if($data != null and count($data) > 0 ){
            foreach($data as $result) {
                $fileContent .=  implode("\t ", $result )."\n";
            }
        }
        header('Content-type: application/ms-excel;charset=utf-8');
        header('Content-Disposition: attachment; filename='.$fileName);
        echo chr(255).chr(254).iconv("UTF-8", "UTF-16LE//IGNORE", $fileContent); 
        exit;
    }
    //-----------------------------------------------------------------------------------------
    public function user_id(){
        return $this->getView()->getRequest()->getSession()->read('Auth.User.id');
    }
    public function loggined(){
        if($this->getView()->getRequest()->getSession()->read('Auth.User.id'))
            return true;
        return false;
    }
    //-----------------------------------------------------------------------------------------
    //1399-11-12
    public function newline($string = null){
        return preg_split("/\r\n|\n|\r/", $string);
    }
    //-----------------------------------------------------------------------------------------
    //1402-03-16
    public function CSP(){
        if(FuncHelper::OptionGet('security_scp_view') == 1){
            echo "<meta http-equiv='Content-Security-Policy' content=".
                '"'.
                "script-src 'strict-dynamic' 'nonce-".get_nonce."'".
                '">'."\n";
        }
    }
    //-----------------------------------------------------------------------------------------
    //1400-01-07
    public function the_comments($id = null, $attr = []){
        echo $this->_View->cell('Admin.Comments',[$id, $attr]);
    }
    //-----------------------------------------------------------------------------------------
    public function is_connected($url = "www.google.com"){
        $connected = @fsockopen($url, 80);
        if ($connected){
            $is_conn = true; //action when connected
            fclose($connected);
        }else{
            $is_conn = false; //action in connection failure
        }
        return $is_conn;
    }
    //-----------------------------------------------------------------------------------------
    //----1400/8/13-------------------------------------------------------------------------------------
    public function save_image_size( $url = null , $media_id=null ){
        global $upload_path;
        if($upload_path != '')
            $this->upload_path = $upload_path;
        $extension = strtolower(pathinfo($url, PATHINFO_EXTENSION));
        $ext = array('jpg','jpeg','png','gif');
        if(! in_array($extension,$ext))
            return 0;
        $size = FuncHelper::gallery_size();
        $result_size= [];
        foreach($size as $size_key => $size_value):
            $result = $this->ImageCreateTHumbnail([
                'url'=> WWW_ROOT.$this->upload_path.$url,
                'dest_path'=>'uploads',
                'width'=>$size_value['width'],
                'height'=>$size_value['height'],
                'mode'=>$size_value['mode'],//(options: exact, portrait, landscape, auto, crop)
                'quality'=>'100',
            ]);
            
            $newimg = str_replace($this->upload_path,'',$result);
            $result_size[$size_key]=[
                'size'=>$size_key,
                'name'=>$newimg,
                'id'=>$media_id];

            $this->PostMetaSave($media_id,[
                'type' => 'image-size',
                'name' => $size_key,
                'value' => $newimg,
                'action' => 'create']);
        endforeach;
        return $result_size;
    }
    //----1400/8/13-------------------------------------------------------------------------------------
    public function UniqId($max = 16){
        return substr(md5(microtime()) . base_convert((string)time(), 10, 36), 0, $max);
    }
    //----1402/03/07-------------------------------------------------------------------------------------
    function Numconvert($string = null) {
        $persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        $arabic = ['٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩'];
    
        $num = range(0, 9);
        $convertedPersianNums = str_replace($persian, $num, $string);
        $englishNumbersOnly = str_replace($arabic, $num, $convertedPersianNums);
        
        return $englishNumbersOnly;
    }
    //----1400/8/13-------------------------------------------------------------------------------------
    public function Redirect($url = null){
        die(header('location: '.$url));
        //die('<meta http-equiv="refresh" content="0; url='.$url.'">'.'Please wait ...');
    }
    //----1400/8/13-------------------------------------------------------------------------------------
    public function ImageCreateTHumbnail($opt=null){
        $resizeObj = new Resize($opt['url']);
        $ext = strtolower(pathinfo($opt['url'], PATHINFO_EXTENSION));
        $name = explode('/',str_replace('.'.$ext,'',$opt['url']).'-'.$opt['width'].'x'.$opt['height'].'.'.$ext);
        $name = end($name);
        $resizeObj -> resizeImage($opt['width'], $opt['height'], $opt['mode']);
        $resizeObj -> saveImage($save_path = ($opt['dest_path'].'/'.$name),$opt['quality']);
        return ($save_path);
    }
    //----1400/12/13-------------------------------------------------------------------------------------
    public function create_admin_alert($plugin = null , $options = []){
        $p = FuncHelper::OptionGet('alert_'.$plugin);
        $type = isset($options['slug'])?$options['slug']:'new';
        $title = ' '.(isset($options['title'])?$options['title']:__d('Admin', 'پیام جدید ثبت شده است'));

        if($p == null){
            $temp[$type] = [
                'count'=> 1,
                'title'=>'1 '.$title,
                'plugin'=>$plugin,
                'link'=> isset($options['link'])?$options['link']:'/admin/',
                'descr'=> isset($options['descr'])?$options['descr']:'',
            ];
        }
        else{
            $temp = unserialize($p);
            if(isset($temp[$type]['count'])){
                $temp[$type] = [
                    'count'=> $temp[$type]['count']+1,
                    'title'=>($temp[$type]['count']+1) .$title,
                    'plugin'=>$plugin,
                    'link'=> isset($options['link'])?$options['link']:'/admin/',
                    'descr'=> isset($options['descr'])?$options['descr']:'',
                ];
            }
            else{
                $temp[$type] = [
                    'count'=> 1,
                    'title'=>'1'.$title,
                    'plugin'=>$plugin,
                    'link'=> isset($options['link'])?$options['link']:'/admin/',
                    'descr'=> isset($options['descr'])?$options['descr']:'',
                ];
            }
        }
        FuncHelper::OptionSave('alert_'.$plugin,serialize($temp),'create');
    }
}
include_once(dirname(__FILE__).'/jdate.php');