<?php
namespace Admin\View\Helper;

use Cake\View\Helper;
use Bank\Controller\AppController;
use Cake\Controller\Controller;
use Cake\View\View;
use Cake\ORM\TableRegistry;
use Cake\Event\Event;
use Cake\Utility\Text;
use Cake\Routing\Router;
use Cake\I18n\Date;
use Admin\View\Helper\FuncHelper;
use DateTime;

//use Cake\View\Helper\UrlHelper;

class QueryHelper extends Helper
{
    public $helpers = ['Html','Form','Func','Module','Url'];
    //------------
    public function initialize(array $config){}
    //------------
    protected $_defaultConfig = [
        'errorClass' => 'error',
        'templates' => [
            'label' => '<label for="{{for}}">{{content}}</label>',
        ],
    ];
    
    //------------
    public function info($title){
        //echo $this->FuncHelper->OptionGet($title);
        
        $this->Themes = TableRegistry::getTableLocator()->get('Admin.Themes');
        $temp = $this->Themes->find('all')
            ->select(['value'])
            ->where(['name'=>$title])
            ->first();
        if($temp)
            return $temp['value'];
        else return '';
    }
    //------------
    public function perma($data, $type = 'post'){
        $url = null;
        if($type == 'post'){ //single
            //$url = '/' . $data['post_type'] . '/single/' . $data['id'] . '/' .$data['slug'];
            if(isset($data['post_type']) and $data['post_type'] == 'product'){
                if(strtolower($data['slug']) != strtolower( str_replace(' ','-',$data['title'])))
                    $url = '/' . $data['post_type'] . '/' .$data['slug'].'/' . str_replace(' ','-',$data['title']);
                else
                    $url = '/' . $data['post_type'] . '/' .(isset($data['slug'])?$data['slug']:'');
            }
            else
                $url = '/' . (isset($data['post_type'])?$data['post_type']:'') . '/' .(isset($data['slug'])?$data['slug']:'');
        }
        elseif($type == 'index')
            $url = '/' . $data['post_type'] . '/index/'. $data['id'] . '/' .$data['slug'];//$url = '/category/' . $data['id'] . '/' .$data['slug'];
        elseif($type == 'category')
            $url = '/' . $data['post_type'] . '/category/'. $data['id'] . '/' .$data['slug'];//$url = '/category/' . $data['id'] . '/' .$data['slug'];
        elseif($type == 'catsingle')
            $url = '/' . $data['post_type'] . '/category/single/'. $data['id'] . '/' .$data['slug'];//$url = '/category/' . $data['id'] . '/' .$data['slug'];
        elseif($type == 'link'){
            $url = (isset($data[0]['link'])?$data[0]['link']:'') ;
        }
        return $url;
    }
    //------------
    public function the_id(){
        global $result;
        if(isset($result['id']))
            return $result['id'];
        else
            return 0;
    }
    //------------
    public function the_shortlink($id = null){
        global $result;
        if(isset($result['id']) and $id == null)
            $id = $result['id'];

        return Router::url('/p/'.$id,true);
    }
    //------------
    public function the_permalink($param = null){
        global $result;
        $res = $result;

        if(isset($param['id'])){
            $p['id'] = $param['id'];

            // data_type : what table search in - post table or category table
            if(isset($param['data_type']) and $param['data_type']=="category"){
                $res = QueryHelper::category(null,$p);
                $res =isset( $res[0])? $res[0]:null;
            }else{
                $res = QueryHelper::post(null,$p);
                $res =isset( $res[0])? $res[0]:null;
            }
            
        }
        elseif(isset($result['id'])){
           $res = $result; 
        }
        $type = isset($param['type'])?$param['type']:'post';
        $param['escape'] = false;
        $url = QueryHelper::perma($res, $type);
        $url = Router::url('/',true) . ltrim($url, '/');
        //$url = str_replace('//','/',$url);
        return $url;
    }
    //------------
    /* public function check_current_url($url1 = null , $url2 = null , $param = null){
        $url1 = $this->Url->build($this->getView()->getRequest()->getRequestTarget(), true) ;
        $url2 = $this->Url->build($this->the_permalink(['id'=> $url2,'type'=>(isset($param['type'])?$param['type']:'post')]) );

        if($url1 == $url2)
            return true;
        return false;
    } */
    //------------
    public function permalink($title, $data, $param = null)
    {
        $type = isset($param['type'])?$param['type']:'post';
        $return = isset($param['return'])?$param['return']:'full';
        $param['escape'] = false;
        $url = QueryHelper::perma($data, $type);
        if($return =='url') return $url;
        if($return =='furl') return Router::url('/',true) . $url;

        return $this->Html->link($title, $url, $param);
    }
    //------------
    public function get_permalink($data, $type = 'post')
    {
        return Router::url('/').QueryHelper::perma($data, $type);
    }
    //------------
    public function the_mexcerpt($string = null, $size = 50){
        return Text::excerpt(strip_tags($string),'',$size, '...' );
    }
    //------------
    public function the_slug($string = null){
        return str_replace(' ','-',$string );
    }
    //------------
    public function the_excerpt($data = null, $size = 50){
        global $result;
        if($data == null)
            $data = $result;
        if($size == null or (isset($data['summary'])) and $data['summary'] !=''){
            /* if($this->Func->OptionGet('excerpt_from_content') == "0"){
                return "";
            }
            else
            return Text::excerpt(strip_tags((isset($data['summary'])?$data['summary']:null)),'',$size, '...' ); */
            return strip_tags($data['summary']);
        }
            
        else{
            if($this->Func->OptionGet('excerpt_from_content') == "0"){
                return "";
            }
            else
                return Text::excerpt(strip_tags((isset($data['content'])?$data['content']:null)),'',$size, '...' );
        }
    }
    //------------
    public function the_image($param = []){
        global $result;
        return $this->postimage(
            isset($param['size'])?$param['size']:'thumbnail',
            $result,
            $param
        );
    }
    //------------
    public function postimage($size = 'full', $data = null, $params = null)
    {
        $type = isset($params['type'])?$params['type']:'post';
        $id = 0;
        $image = '';

        if(isset($params['new_url']) and $params['new_url'] != ''){
            $img = explode('/',$params['new_url']);
            $img = isset($img[count($img) - 1])?$img[count($img) - 1]:false;
            if($img != false){
                $id = TableRegistry::getTableLocator()->get('Admin.PostMetas')->find('all')
                    ->where(['meta_value' => $img ])
                    ->first();
                if($id)
                    $id = $id['post_id'];
                else return null;
            }
            else return null;
        }
        if (isset($data['post_metas'])) {
            foreach($data['post_metas'] as $value):
                if ($value['meta_key'] == 'thumbnail') {
                    if ($type == 'post') {
                        $id = $value['meta_value'];
                        //$id = is_numeric($value['meta_value'])?$value['meta_value']:$value['post_id'];
                    }
                    if ($type == 'gallery')
                        $id = $value['post_id'];
                }
            endforeach;
        }
        
        $tmp =  null;
        try{
            /* $tmp = TableRegistry::getTableLocator()->get('Admin.Posts')
                ->find('all')
                ->where(['Posts.id'=> intval($id) ])
                ->contain(['PostMetas'])
                ->first(); */

            $tmp = TableRegistry::getTableLocator()->get('Admin.Posts')->get(intval($id),[
                'contain' => ['PostMetas'=> function ($q) {return $q->enableAutoFields(false);}],
                'enableHydration'=>false,
                'cache' => false
            ]);
        }
        catch (\Exception $e) {
            $tmp =  null;
        }
        //pr($tmp);


        if ($tmp) :
            if ($size == 'full' or $size =='large') {
                $image = $tmp['title'];
            } else {
                if (isset($tmp['post_metas']) and is_array($tmp['post_metas'])) :
                    foreach($tmp['post_metas'] as $value):
                        if ($value['meta_key'] == $size)
                            $image = $value['meta_value'];
                    endforeach;
                endif;
            }
        endif;

        if ($image != '') {
            $image = str_replace('uploads/', '', $image);
            return '/uploads/'.$image;
        } else {
            return false;
        }
    }
    //------------
    public function UrlCon( array $url = null){
        $param = $this->getView()->getRequest()->getQuery();
        if( $param and count($param)):
            foreach($url as $k => $v){
                if(array_key_exists($k , $param))
                    unset($param[$k]);
            }
            return $param += $url;
        endif;
        return $url;
    }
    //------------
    public function UrlCon2( array $url = null){
        $current = explode('?',$this->getView()->getRequest()->getRequestTarget());
        $current = str_replace('ajax','index',$current);
        $query = [];
        $param = (array) $this->getView()->getRequest()->getQuery();
        
        if ($param and count($param)) :
            foreach ($url as $k => $v){
                if (array_key_exists($k, $param))
                    unset($param[$k]);
            }
        endif;

        $param += $url;
        foreach ($param as $k => $v) {
            if ($v != false and !is_array($v)) @$query[] = "$k=$v";
        }
        return $current[0] . (count($query)?'?'.implode('&',$query):'');
    }
    //------------
    public function the_tags($param = []) {
        global $result;
        $datas = $result;
        $title = isset($param['title'])?$param['title']:null;
        return $this->tags($title , $datas, ['split'=>'',$param]);
    }
    public function tags($title = null, $datas = [], $param = []) {
        $title == null ? __d('Admin', 'برچسب ها'): '';
        $taglist = [];
        $return = isset($param['return'])?$param['return']:null;
        
        $type = isset($param['type'])?$param['type']:'tag';
        //$split = isset($param['split'])?$param['split']:' , ';
        $split = isset($param['split'])?$param['split']:'';
        $limit = isset($param['limit'])?$param['limit']:0;
        $limit_t  = isset($param['limit_text'])?$param['limit_text']:false;
        $i=1;
        $link = null;
        if(isset($datas['tags']) and count($datas['tags'])){ 
            $link = $title;
            $ii = 0;
            foreach($datas['tags'] as $data):if(isset($data['slug'])):
                if($limit != 0){
                    if($limit < $i)
                        break;
                }
                $link .= (! in_array($split,['',',','-']) != ''?"<$split>":"");
                if($type == 'current'):
                    $title = ($limit_t != false ?QueryHelper::the_mexcerpt($data['title'],$limit_t):$data['title']);
                    $url = router::url(QueryHelper::UrlCon2(['tags' => $data['slug']]),true);
                    $taglist[$title] = $url;

                    $link .= $this->Html->link(
                        $title
                        , 
                        $url
                        , 
                        ['title'=>$data['slug']]);
                else:
                    $title = ($limit_t != false ?QueryHelper::the_mexcerpt($data['title'],$limit_t):$data['title']);
                    $url = router::url('/tag/'.$data['slug'],true);
                    $taglist[$title] = $url;

                    $link .= $this->Html->link(
                        $title
                        ,
                        $url
                        ,
                        ['title'=>$data['title']]);
                endif;
                $link .= (! in_array($split,['',',','-']) != ''?"</$split>":($ii < count($datas['tags']) - 1?' '.$split.' ':'')).' ' ;
                $i+=1;
                $ii++;

            endif;endforeach;
        }
        if( $return != null and $return == 'array'){
            return  $taglist;
        }
        else
            return $link;
    }
    //------------
    public function is_tags($datas = null)
    {
        if(isset($datas['tags']) and count($datas['tags'])){ 
            return 1;
        }
        return 0;
    }
    //--------------
    //1402-3-19
    public function getAdjascentKey( $key, $hash = array(), $increment ) {

        pr($hash);
        $keys = array_keys( $hash );   
        pr($keys ); 
        $found_index = array_search( $key, $keys );
        if ( $found_index === false ) {
            return false;
        }
        pr($found_index);
        $newindex = $found_index+$increment;
        // returns false if no result found
        return ($newindex > 0 && $newindex < sizeof($hash)) ? $keys[$newindex] : false;
    }
    /* function get_next($array, $key) {
        $currentKey = key($array);
        while ($currentKey !== null && $currentKey != $key) {
            next($array);
            $currentKey = key($array);
        }
        return next($array);
     } */

    //------------
    public function post($post_type = null, $p = []){
        $this->Posts = TableRegistry::getTableLocator()->get('Admin.Posts');
        
        //conditions
        $condition = array();
        $condition['published'] = 1;
        if(! isset($p['id']))
            $condition['Posts.post_type'] = ($post_type != null)? $post_type:'post';

        if(isset($p['where']))
            $condition[] = $p['where'];
        
        if(isset($p['id']) and (isset($p['prev_post']) or isset($p['next_post'])) ){
            $arr =  $this->Posts->find('list',['keyField' => 'id','valueField' =>'id'])
                ->where(['post_type'=> $post_type,'published'=>1])
                ->order(['Posts.created'])
                ->toArray();
            $current = $p['id'];
            $arr = array_values($arr);
            if(isset($p['next_post'])){
                $p['id'] = isset($arr[array_search($current, $arr) + 1])?$arr[array_search($current, $arr) + 1]:0;
            }else{
                $p['id'] = isset($arr[array_search($current, $arr) - 1])?$arr[array_search($current, $arr) - 1]:0;
            }
        }

        if(isset($p['id'])){
            if(is_array($p['id']))
                $condition['Posts.id IN']=$p['id'];
            else
                $condition['Posts.id']=$p['id'];
        }

        

        if(isset($p['title'])){
            if(is_array($p['title']))
                $condition[$this->Posts->translationField('title'). ' IN'] = $p['title'];
            else
                $condition[$this->Posts->translationField('title')] = $p['title'];
        }
        if(isset($p['title_like'])){
            $condition[$this->Posts->translationField('title'). ' LIKE '] = "%".$p['title_like']."%";
        }
        if(isset($p['content_like'])){
            $condition[$this->Posts->translationField('content').' LIKE '] = "%".$p['content_like']."%";
        }

        //order
        $order = null;
        if(isset($p['order']) and $p['order'] != false)
            $order = ['Posts.id'=>'desc'];
        if(isset($p['order'])){
            $order = $p['order'];
        }

        //filed
        $field = array();
        if(isset($p['field'])) $field=(array) $p['field'];

        //limit
        if( isset($p['limit']) ){
            if($p['limit'] == 0)
                $limit = 100000000;
            else
                $limit = $p['limit'];
        }
        else
            $limit = 10;

        //contain
        $model = ['Categories','Tags','PostMetas','PostsI18n'];//'Users',
        if(isset($p['contain'])) $model = $p['contain'];

        //find_type
        $find_type = 'all';
        if(isset($p['find_type'])) $find_type=$p['find_type'];

        
        $result = $this->Posts;

        if($find_type == 'list'){
            $result= $this->Posts->find('list', [
                'keyField' => $field[0],
                'valueField' =>  $field[1]
            ]);
        }
        else{
            $result= $this->Posts->find($find_type);
        }

        if(isset($p['contain_where'])){ 
            /* 
            $this->Query->post('sources',[
                'contain'=>['PostMetas'],
                'contain_where' => []
            ]);

            'contain_where' => [
                'meta_key' => 'author',
                'meta_key_like' => '',
                'meta_value' => 'saeed',
                'meta_value_like' => 'سعید سروشیان',
            ],
            */
            $p['contain_where'] = [$p['contain_where']];
            $ex = 0;
            foreach($p['contain_where'] as $extra):
                
                $result->join([
                    'table' => 'post_metas',
                    'alias' => 'pm'. $ex,
                    'type' => 'LEFT',
                    'conditions' => ['pm'.$ex.'.post_id = Posts.id']
                ]);
                $result->where([
                    "pm$ex.meta_key".(isset($extra['meta_key_like'])?' like ':'') => 
                        (isset($extra['meta_key_like'])?"%".$extra['meta_key_like']."%":'') . 
                        (isset($extra['meta_key'])?$extra['meta_key'] : ''),

                    "pm$ex.meta_value".(isset($extra['meta_value_like'])?' like ':'') => 
                        (isset($extra['meta_value_like'])?"%".$extra['meta_value_like']."%" :'') . 
                        (isset($extra['meta_value'])? $extra['meta_value'] : ''),
                ]);
                $ex += 1;
            endforeach;
        }
       
        
        $result->select($field)
            ->contain($model)
            ->where($condition)
            ->limit($limit)
            ->enableHydration(false);

        if($order){
            if($order == 'title')
                $result->order([$this->Posts->translationField('title') => 'ASC']);
            else
                $result->order($order);
        }

        if(isset($p['cat_data']) ){
            if($p['cat_type'] == 'id'){
                $temp = $p['cat_data'];
                if(is_array($p['cat_data'])){
                    $result->matching('Categories',
                        function ($q) use ($temp){
                        return $q->where(['Categories.id IN' => $temp]);
                    });
                }else{
                    $result->matching('Categories',
                        function ($q) use ($temp){
                        return $q->where(['Categories.id' => $temp]);
                    });
                }
            }
            elseif($p['cat_type'] == 'slug'){
                $result->matching('Categories', function ($q) {return $q->where(['Categories.slug' => 24]);});
            }
        }

        if(isset($p['get_type'])){
            switch ($p['get_type']) {
                case 'first':
                    return $result->first();break;
                case 'last':
                    return $result->last();break;
                case 'count':
                    return $result->count();break;
                case 'isempty':
                    return $result->isEmpty();break;
            }
        }
		return $result->toarray();
    }
    //------------
    public function category($post_type = null, $p = [])
    {
        $this->Categories = TableRegistry::getTableLocator()->get('Admin.Categories');

        //conditions
        $condition = array();
        if(! isset($p['id']))
            $condition['Categories.post_type'] = ($post_type != null)? $post_type:'post';

        /* if(isset($p['id'] )) 
            $condition['Categories.id'] = $p['id']; */

        if(isset($p['id'])){
            if(is_array($p['id']))
                $condition['Categories.id IN']=$p['id'];
            else
                $condition['Categories.id']=$p['id'];
        }

        if(isset($p['parent'])) 
            $condition['Categories.parent_id'] = $p['parent'];

        if(isset($p['slug'] )) 
            $condition['Categories.slug'] = $p['slug'];
            
        if(isset($p['title'])){
            if(is_array($p['title']))
                $condition[$this->Categories->translationField('title'). ' IN'] = $p['title'];
            else
                $condition[$this->Categories->translationField('title')] = $p['title'];
        }

        if(isset($p['cat_id'])) 
            $condition['Categories.id IN']= $p['cat_id'];
        elseif(isset($p['cat_slug'])) 
            $condition['Categories.slug IN']= $p['cat_slug'];

        //order
        $order = ['Categories.id'=>'desc'];
        if(isset($p['order'])) $order=$p['order'];

        //contain
        $model = ['CategorieMetas'];
        if(isset($p['contain'])) $model = $p['contain'];

        //filed
        $field = array();
        if(isset($p['field'])) $field=$p['field'];

        //limit
        if( isset($p['limit']) ){
            if($p['limit'] == 0)
                $limit = 100000000;
            else
                $limit = $p['limit'];
        }
        else
            $limit = 10;


        //find_type
        $find_type = 'all';
        if(isset($p['find_type']))
            $find_type = $p['find_type'];

        if($find_type == 'treeList' or $find_type == 'treelist' or $find_type == 'list'){
            $result = $this->Categories
                ->find('treeList',['keyField'=>'id','valueField'=>'title','spacer' => '—'])
                ->order(['lft'=>'desc']);
        }
        elseif($find_type == 'treechildren'){
            $result = $this->Categories
                ->find('children', ['for' => $p['children']])
                ->find('treeList',['keyField'=>'id','valueField'=>'title','spacer' => '—']);
        }
        elseif($find_type == 'threaded'){
            $result = $this->Categories
                ->find('children', ['for' => $p['children']])
                ->find('threaded');
        }
        elseif($find_type == 'listchildren'){
            $result = $this->Categories
                ->find('children', [ 'for' => $p['children']]);
            if( isset($p['keyField']))
                $result->find('list',$p['keyField']);
            else
                $result->find('list',['keyField'=>'id','valueField'=>'title']);

        }
        elseif($find_type == 'list'){
            $result = $this->Categories
                ->find('list', $p['keyField'])//['keyField'=>'title','valueField'=>'title']
                ->order($order);
            if($field != [])
                $result->select($field);
        }    
        else{
            $result = $this->Categories
                ->find($find_type);

            if($order == 'title')
                $result->order([$this->Categories->translationField('title') => 'ASC']);
            else
                $result->order($order);
                
            if($field != [])
                $result->select($field);
        }

        $result->where($condition)
            ->limit($limit)
            ->contain($model)
            //->order(['lft'=>'desc'])
            ->enableHydration(false)
            ;

        if(isset($p['get_type'])){
            switch ($p['get_type']) {
                case 'first':
                    return $result->first();break;
                case 'last':
                    return $result->last();break;
                case 'count':
                    return $result->count();break;
                case 'isempty':
                    return $result->isEmpty();break;
            }
        }
		return $result->toarray();
    }

    public function the_category2($option =[]){
        global $category;
        global $post_type;
        $ptitle = [];

        if( ($tmp = $this->Func->OptionGet('posttype_title')))
            $ptitle = unserialize($tmp);

        $cat = '';

        if(isset($category['title']) and $category['title']!= ''){
            $cat =  $category['title'];
        }
        if(! isset($category['title']) and $post_type != ""){
            $f = ModuleHelper::post_type();
            if(is_string($post_type) and isset($f[$post_type]['name']['title'])){
                if(isset($ptitle[$post_type]) and $ptitle[$post_type] != '')
                    $cat = $ptitle[$post_type];
                else
                    $cat = strip_tags($f[$post_type]['name']['title']);
            }
        }
        if($cat == 'NULL'){
            return '';
        }
        else{
            return $cat;
        }
    }

    public function the_category($results = null , $option =[])
    {
        if($results == null){
            global $result;
            $results = $result;
        }

        $type =     isset($option['type'])?$option['type']:'post';
        $sep =      isset($option['sep'])?$option['sep']:' , '; //Separator
        $linkable = isset($option['link'])?$option['link']:true;
        $title = isset($option['title'])?$option['title']:false;
        $rettype    = isset($option['rettype'])?$option['rettype']:'all'; //return link or array of data
        $retby    = isset($option['retby'])?$option['retby']:'title'; //return link or array of data

        $data = null;
        $temp_arr = [];
        if($type == 'post'){
            if(isset($results['categories']) and count($results['categories'])>0){
                echo ($title != '' ?$title : null);
                $category = $results['categories'];
                $i=1;
                foreach($category as $cat): if(isset($cat['title'])):
                    if($rettype == 'all'){
                        if($linkable == false):
                            $data .= $cat['title'].($i != count($category)?$sep:'');
                        else:
                            //$data .= QueryHelper::permalink($cat['title'],$cat,['type'=>'category']).
                            $data .= QueryHelper::permalink($cat['title'],$cat,['type'=>'index']).
                            ($i != count($category)?$sep:'');
                        endif;
                        $i+=1;

                    }
                    elseif($rettype == 'array')
                    {
                        if($retby == 'title')
                            $data[] = $cat['title'];
                        elseif($retby == 'slug')
                            $data[] = $cat['slug'];
                    }
                endif;    
                endforeach;
            }
        }
        return $data;
    }
	//-----------------------------------------------------------------------------------------
    public function category_crumb($id = null , $option =[])
    {
        $string = '';
        $sep = isset($option['sep'])?$option['sep']:' , '; //Separator
        $linkable = isset($option['linkable'])?$option['linkable']:false;
        $return = isset($option['return'])?$option['return']:'link';
        $crumbs = null;

        if($id != null){
            try {
                $crumbs = TableRegistry::getTableLocator()->get(
                    isset($option['table'])?$option['table']:'Admin.Categories')
                    ->find('path', ['for' => intval($id) ]);
            } catch (\Exception $e) {
                $crumbs = null;
            }
        }

        if( $crumbs):
            $i = 1;
            if($return == 'array'){
                $string = [];
                foreach ($crumbs->toarray() as $k => $crumb) {
                    $string[] = $crumb->title;
                }
            }
            elseif($return == 'link'){
                foreach ($crumbs->toarray() as $k => $crumb) {
                    $i += 1;
                    if(isset($option['exclude_node']) and in_array($k , $option['exclude_node']))
                        continue;
                    if($linkable)
                        $string .= 'linkable';
                    else
                        $string .= $crumb->title . ($i != count($crumbs->toarray()) + 1?$sep:'');
                }
            }
        endif;
        return $string;
    }
    //-----------------------------------------------------------------------------------------
    public function shm_to_mil($date,$sep='-'){
		$date=explode($sep,$date);
		return jalali_to_gregorian($date[0],$date[1],$date[2],'-');
	}
	//-----------------------------------------------------------------------------------------
	public function mil_to_shm($date='',$sep='-'){
        $date=explode($sep,$date);
        $dt=gregorian_to_jalali($date[0],$date[1],$date[2],'/');
        $dt=explode("/", $dt);
        return $dt[0].'/'.($dt[1]>9?$dt[1]:'0'.$dt[1]).'/'.($dt[2]>9?$dt[2]:'0'.$dt[2]);
    }
    //-----------------------------------------------------------------------------------------
    public function the_title($res = null){
        global $result;
        
        $temp = null;
        if($res != null) {$temp = $res;/*pr("res");*/}
        else {$temp = $result;/*pr("result");*/}
        
        ///pr($temp);
        if(isset($temp['title']))
            return $temp['title'];
        else
            return "";//content : empty
    }
    //-----------------------------------------------------------------------------------------
    public function Title(){
        //$this->assign('title', 'Test-Title')
        return $this->info('name').
            ($this->getView()->fetch('title')?' - '.$this->getView()->fetch('title') :'' );
    }
	//-----------------------------------------------------------------------------------------
    public function the_time($results = null , $opr = 'Y-m-d h:i'){
        if($results == null){
            global $result;
        }
        else
            $result = $results;

        try {
            $date = new Date(isset($result['created'])?$result['created']:$result);
            //return QueryHelper::mil_to_shm(date("Y-m-d", strtotime($date)));
            return jdate($opr,strtotime($date->format('Y-m-d'))); 
        } catch (\Exception $e) {
            return '';
        }
    }
    //-----------------------------------------------------------------------------------------
    function validateDate($date, $format = 'Y-m-d H:i:s')
    {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }
    //-----------------------------------------------------------------------------------------
    public function the_content($results = null){

        if($results == null){
            global $result;
        }
        else
            $result = $results;
        
        global $is_status;
        $show_post = false;
        $text = null;
        $wrong_pass = false;

        if(isset($result['content']))
            $text = $result['content'];
        else 
            $text = "";// $text = $result; //content : empty

        /* ?? 
            برای چی  گذاشته ام
            1400.8.5
        if($is_status != 'single'){
            return 'محافظت شده';
        } */

        if(isset($result['post_status']) and $result['post_status'] == 3)
            $show_post = false;
        else
            $show_post = true;

        if(isset($result['id']) and $this->getView()->getRequest()->getSession()->read('Post.'.$result['id']) == 1){
            $show_post= true;
        }

        if(isset($result['post_status']) and $result['post_status'] == 3 and $show_post == false){
            $metalist = $this->Func->MetaList($result);
            if ($this->getView()->getRequest()->is(['post'])) { 
                if( isset($metalist['adpost_password']) and 
                    $metalist['adpost_password']!= '' and  
                    $this->getView()->getRequest()->getData()['password'] !="" and
                    $this->getView()->getRequest()->getData()['password'] == $metalist['adpost_password']
                    ){
                        $this->getView()->getRequest()->getSession()->write('Post.'.$result['id'], 1);
                        $show_post = true;
                }
                else{
                    $wrong_pass = true;
                }
            }
            
            if($show_post == false){
                echo $this->Form->create();
                echo '<p style="margin:0;padding:0;font-weight:bold">
                    '.__d('Admin', 'این نوشته توسط رمز محافظت شده است').'.
                    </p><br>';
                echo $this->Form->control("password",[
                    'type'=>'text',
                    'required'=>true,
                    'class'=>'form-control',
                    'style'=>'direction: ltr;',
                    'label'=>__d('Admin', 'لطفا رمز را وارد کنید').': ' ]);

                if($wrong_pass == true)
                    echo '<p style="color:red;margin:0;padding:0;">'.
                        __d('Admin', 'رمز وارد شده اشتباه است').
                        '</p>';
                echo $this->Form->submit(
                    __d('Admin', 'ارسال'),
                    ['style'=>'margin-top:10px;']);
                echo $this->Form->end();
                //$this->getView()->getRequest()->setLayout('Admin.default');
            }
        }
        if($show_post == 0)
            return '';

        $text = $this->do_shortcode($text);
        /* $temp = ModuleHelper::shortcode();
        if(count($temp)){
            foreach(QueryHelper::parseAttributesFromTag($text) as $k => $cod){
                if(isset($temp[$k])){
                    $text = str_replace(
                        '['.$k.'="'.$cod.'"]',
                        $this->_View->cell( $temp[$k],[$cod] ), 
                        $text);
                }
            }
        } */
        return $text;
    }

    //1403-05-21
    function do_shortcode($text = null){
        $temp = ModuleHelper::shortcode();
        if(count($temp)){
            foreach(QueryHelper::parseAttributesFromTag($text) as $k => $cod){
                if(isset($temp[$k])){
                    $text = str_replace(
                        '['.$k.'="'.$cod.'"]',
                        $this->_View->cell( $temp[$k],[$cod] ), 
                        $text);
                }
            }
        }
        return $text;
    }

    function parseAttributesFromTag($tag){
        //The Regex pattern will match all instances of attribute="value"
        $pattern = '/(\w+)=[\'"]([^\'"]*)/';
        preg_match_all($pattern, $tag, $matches, PREG_SET_ORDER);
        $result = [];
        foreach($matches as $match){
            $attrName = $match[1];
            $attrValue = is_numeric($match[2])? (int)$match[2]: trim($match[2]);
            if(QueryHelper::startsWith($attrName,'code_'))
                $result[$attrName] = $attrValue;
        }
        return $result;
    }
    function startsWith ($string, $startString) { 
        $len = strlen($startString); 
        return (substr($string, 0, $len) === $startString); 
    }
	//-----------------------------------------------------------------------------------------
    public function Navmenu_getlink($id = 0,$type ='post',$data = null)
    {
        $result = [];
        if($type =='post')
            $result = QueryHelper::post('',['id'=>$id]);
        elseif($type =='category'){
			$type ='index';
            $result = QueryHelper::category('',['id'=>$id]);
		}
        elseif($type =='link')
            $result = [0=>['title'=>$data['title'],$data]];

        $result = isset($result[0])?$result[0]:'-';
        return $result!='-'?QueryHelper::permalink($result['title'], $result,['type'=> $type,'return' =>'url']):null;
        //return $result != '-' ?QueryHelper::get_permalink( $result, $type):null;
    }
    //------------
    public function NavLinkCheck($link = null ,$current = null)
    {
        //pr(urldecode(Router::url($link,'true')));

        if(strcmp(urldecode(Router::url($link,'true')), urldecode(Router::url($current,'true'))) === 0)
            return 'active';
        else
            return null;


        if(Router::url($link,'true') === Router::url('/'.$current,'true'))
            return 'active';
        else return '';
        //pr(Router::url($link,'true'));
        //pr(Router::url($current,'true'));
        //pr($current);
        $link = explode('/',$link);
        
        unset($link[count($link)-1]);
        $link = implode('/',$link);
        
        $current = explode('/',$current);
        unset($current[count($current)-1]);
        $current = implode('/',$current).'/';

        if($link.'/' == '/'.$current)
            return 'active';
        return '';
    }
    //------------
    //1403/03/23
    function highlightKeywords($text, $keyword) {
		$wordsAry = explode(" ", $keyword);
		$wordsCount = count($wordsAry);
		
		for($i=0;$i<$wordsCount;$i++) {
			$highlighted_text = "<span style='font-weight:bold;'>$wordsAry[$i]</span>";
			$text = str_ireplace($wordsAry[$i], $highlighted_text, $text);
		}

		return $text;
	}
    //------------
    public function Navmenu($id = null, $data){
        if( $id == null ) return;
        /* $current = str_replace(
            Router::url('/'),
            '',
            Router::url($this->getView()->getRequest()->getRequestTarget())); */
        $current = Router::url($this->getView()->getRequest()->getRequestTarget());     
        $this->Themes = TableRegistry::getTableLocator()->get('Admin.Themes');

        $nav = $this->Themes->find('all')
                ->select(['id','name','value'])
                ->where(['types'=>'nav_menu','id'=> intval($id) ])
                ->order(['id'=>'desc'])
                ->first();
        if($nav == null){
            return '<span class="badge badge-danger">'.__d('Admin', 'منوی مورد نظر پیدا نشد').'</span>';
        }
        $menu_data = unserialize($nav->toarray()['value']);
        $menu_level = json_decode($menu_data['serial'],true);

        /* 
        'nav'=>'true',
            'nav_class'=>'',
            'nav_id'=>'',
            'nav_style'=>'',
        'div'=>true,
            'div_class'=>'collapse navbar-collapse',
            'div_id'=>'navbarResponsive',
            'div_style'=>'direction:rtl',
        'ul'=>true,
            'ul_class'=>'navbar-nav ml-auto',
            'ul2_class'=>'navbar-nav ml-auto',
            'ul_id'=>'',
            'ul_style'=>'padding: 0;',
        'li_class'=>'nav-item',
        'a_class'=>'nav-link' */
        
        $result = '';
        if(isset($data['nav']) and $data['nav']==true){
            $result .= '<nav 
                '.(isset($data['nav_class'])?'class="'.$data['nav_class'].'"':'').' 
                '.(isset($data['nav_id'])?'id="'.$data['nav_id'].'"':'').' 
                '.(isset($data['nav_style'])?'style="'.$data['nav_style'].'"':'').'>';
            }

        if(isset($data['div']) and $data['div']==true){
            $result .= '<div 
                '.(isset($data['div_class'])?'class="'.$data['div_class'].'"':'').' 
                '.(isset($data['div_id'])?'id="'.$data['div_id'].'"':'').' 
                '.(isset($data['div_style'])?'style="'.$data['div_style'].'"':'').'>';
            }

        if(isset($data['ul']) and $data['ul']==true){
            $result .= '<ul 
                '.(isset($data['ul_class'])?'class="'.$data['ul_class'].'"':'').' 
                '.(isset($data['ul_id'])?'id="'.$data['ul_id'].'"':'').' 
                '.(isset($data['ul_style'])?'style="'.$data['ul_style'].'"':'').'>';
            }
        // -----
        if(count($menu_level)):foreach($menu_level as $value1):$i=$value1['id'];
            $link = QueryHelper::Navmenu_getlink($menu_data[$i]['id'],$menu_data[$i]['type'],$menu_data[$i]);

            if(isset($data['li']) and $data['li'] == false){

            }else{
                $result .='<li class ="'.(isset($data['drop_class'])?$data['drop_class'].' ':'dropdown ').(isset($data['li_class'])?$data['li_class'].' ':'').(QueryHelper::NavLinkCheck($link,$current)).'">';
            }
            

            if(!isset($value1['children']) or count($value1['children']) == 0):
                
                $result .= $this->Html->link($menu_data[$i]['title'],$link, 
                    ['escape'=>false,'class'=>(QueryHelper::NavLinkCheck($link,$current)).' '.(isset($data['a_class'])?$data['a_class']:null)]);
            else:
                $link = QueryHelper::Navmenu_getlink($menu_data[$i]['id'],$menu_data[$i]['type'],$menu_data[$i]);

                $result .= $this->Html->link(
                    $menu_data[$i]['title'].(isset($data['carrot'])?$data['carrot']['i']:null)
                    ,$link,
                    [
                        'class'=>(QueryHelper::NavLinkCheck($link,$current)).' '.(isset($data['a_class'])?$data['a_class']:null).' dropdown-toggle1',
                        //'role'=>"button", 
                        //'data-toggle'=>"dropdown",
                        'aria-haspopup'=>"true",
                        'escape'=>false,
                        'aria-expanded'=>"false"]);
                //$result .='<ul class="dropdown-menu" aria-labelledby="navbarDropdown">';
                $result .= '<ul 
                    '.(isset($data['ul2_class'])?'class="'.$data['ul2_class'].'"':'').' 
                    '.(isset($data['ul_id'])?'id="'.$data['ul_id'].'"':'').' 
                    '.(isset($data['ul_style'])?'style="'.$data['ul_style'].'"':'').'>';
                
                    foreach($value1['children'] as $value2):$i=$value2['id'];   
                        $result .='<li '.(isset($data['li_class'])?'class ="dropdown '.$data['li_class'].'"':'').'>';
                        if(!isset($value2['children']) or count($value2['children']) == 0):
                            $link = QueryHelper::Navmenu_getlink($menu_data[$i]['id'],$menu_data[$i]['type'],$menu_data[$i]);
                            $result .= $this->Html->link($menu_data[$i]['title'],$link, ['escape'=>false,'class'=>(QueryHelper::NavLinkCheck($link,$current)).' '.(isset($data['a_class'])?$data['a_class']:null)]);
                        else:
                            $link = QueryHelper::Navmenu_getlink($menu_data[$i]['id'],$menu_data[$i]['type'],$menu_data[$i]);
                            $result .= $this->Html->link($menu_data[$i]['title'],$link,['class'=>(QueryHelper::NavLinkCheck($link,$current)).' '.(isset($data['a_class'])?$data['a_class']:null).' dropdown-toggle1','href'=>"#",'role'=>"button", 'data-toggle'=>"dropdown",'aria-haspopup'=>"true",'escape'=>false,'aria-expanded'=>"false"]);
                        
                            //$result .= '<ul class="dropdown-menu" aria-labelledby="navbarDropdown">';
                            $result .= '<ul 
                                '.(isset($data['ul2_class'])?'class="'.$data['ul2_class'].'"':'').' 
                                '.(isset($data['ul_id'])?'id="'.$data['ul_id'].'"':'').' 
                                '.(isset($data['ul_style'])?'style="'.$data['ul_style'].'"':'').'>';
                                foreach($value2['children'] as $value3):$i=$value3['id'];   
                                    $result .='<li '.(isset($data['li_class'])?'class ="'.$data['li_class'].'"':'').'>';
                                    $link = QueryHelper::Navmenu_getlink($menu_data[$i]['id'],$menu_data[$i]['type'],$menu_data[$i]);
                                    $result .= $this->Html->link($menu_data[$i]['title'],$link,['escape'=>false,'class'=>(isset($data['a_class'])?$data['a_class']:null)]);
                                    $result .='</li>';
                                endforeach;
                            $result .= '</ul>';    
                        endif;
                        $result .='</li>';
                    endforeach;
                $result .= '</ul>';    
            endif;

            if(isset($data['li']) and $data['li'] == false){

            }else{
                $result .='</li>';
            }
        endforeach;endif;
        // -----
        if(isset($data['ul']) and $data['ul']==true)
            $result .= '</ul>';

        if(isset($data['div']) and $data['div']==true)
            $result .= '</div>';
        
        if(isset($data['nav']) and $data['nav']==true)
            $result .= '</nav>';
        return $result;
    }
    //------------
}
include_once(dirname(__FILE__).'/jdate.php');