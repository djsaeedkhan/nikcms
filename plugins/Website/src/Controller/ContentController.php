<?php
declare(strict_types=1);
namespace Website\Controller;

use Website\Controller\AppController;

use Cake\Controller\Controller;
use Cake\Event\EventInterface;
use Cake\Core\Plugin;
use Cake\View\CellTrait;
use Cake\ORM\TableRegistry;
use Cake\Http\Exception\NotFoundException;
use Cake\Routing\Router;
use Website\Controller\Component\FetchsComponent;

class ContentController extends AppController
{
    use CellTrait;
    public $template;
    public $fetch_error = false;
    //------------------------------------------------------------------
    public function initialize(): void
    {
        parent::initialize();

        $this->template = $this->Func->OptionGet('website_template');
        $this->viewBuilder()->setTheme($this->template);

        if (Plugin::isLoaded($this->template) !== true) {
            die ($this->render('Website.home'));
        } 
        $this->viewBuilder()->setLayout($this->template.'.default');

        try {
            $this->loadComponent('Website.Fetchs');
        }
        catch (\Throwable $th) {}

        try {
            $this->loadComponent($this->template.'.Fetch');
        }
        catch (\Throwable $th) {$this->fetch_error = true;}

        
        //$this->loadComponent('Captcha.Captcha');

    }
    //------------------------------------------------------------------
    public function home() {
        global $is_status;
        global $compact;
        $is_status = 'home';
        
        if($this->fetch_error == false)
            $this->Fetch->home();

        $this->set($compact);

        //$this->render($this->template.'.home');
        try {
            $this->render($this->template.'.home');
        } catch (\Exception $e) {
            try {
                $this->render($this->template.'.404');
            } catch (\Exception $e) {
                echo "متاسفانه صفحه مورد نظر پیدا نشد";
            }
        }
    }
    //------------------------------------------------------------------
    public function index()
    {
        //pr("index");
        global $is_status;
        global $id ;
        global $category;
        global $post_type;
        global $cond;
        global $results;
        global $index_posttype ;
        global $model;
        global $limit;

        $is_status = 'index';
        $post_type = ($this->request->getParam('posttype'))?strip_tags($this->request->getParam('posttype')):
        ($post_type != '' ? $post_type: null);

        $index_posttype = $this->Func->OptionGet('index_posttype');

        //Check Paginate Limit
        $index_paginate = [];
        try {
            $index_paginate = $this->Func->OptionGet('posttype_paginate');
            if($index_paginate != ""){
                $index_paginate = unserialize($index_paginate );
            }
        } catch (\Throwable $th) {
            $index_paginate = [];
        }
        if(isset($index_paginate[$post_type]) and $index_paginate[$post_type] != "")
            $limit = $index_paginate[$post_type];
        else
            $limit = $this->Func->OptionGet('posts_per_page');
        
            
        $this->Fetchs->index();
        if($this->fetch_error == false)
            $this->Fetch->index();
        
        /* SORT Start Old  */
        /* if($results->toarray()){
            global $list_id;
            $list_id = [];
            foreach($results->toarray() as $tmp){
                $list_id[$tmp['id']] = $tmp['id'];
            }
            $p = $this->getTableLocator()->get('Admin.PostMetas')
                ->find('list',['keyField'=>'post_id','valueField'=>'meta_value'])
                ->where([ "meta_key"=>'pin' ,'post_id IN '=> $list_id])
                ->order(['meta_value' => 'desc'])
                ->toarray();
            $en_ps = false; // need we to sort array by pins?
           
            foreach($p as $ps){
                if($ps == 1) $en_ps = true;
            }
            if($en_ps == true){
                
                foreach($list_id as $k => $list)
                    $list_id[$k] = 0;
                    
                foreach($p as $k => $v){
                    if(isset($list_id[$k]) and $p[$k] == 1)
                        $list_id[$k] = 1;
                    else
                        $list_id[$k] = 0;
                }
                arsort($list_id);
                $tmp_p = [];
                foreach($list_id as $k => $v)
                    $tmp_p[$k] = $k;
                $results->order(["FIELD(Posts.id, ".implode(',', $tmp_p).") ASC"]);
            }
            else
                $results->order(['Posts.created'=>'desc']);
        } */
        /* SORT end */

        /* SORT Start New 1403-09-01  */
        if($results->toarray()){
            global $list_id;
            $list_id = [];
            foreach($results->toarray() as $tmp){
                $list_id[$tmp['id']] = $tmp['id'];
            }

            $pin_list = $this->getTableLocator()->get('Admin.PostMetas')
                ->find('list',['keyField'=>'post_id','valueField'=>'meta_value'])
                ->where([
                    "meta_key"=>'pin' ,
                    'post_id IN '=> $list_id,
                    'meta_value'=> 1
                ])
                ->order(['meta_value' => 'desc'])
                ->toarray();

            if( count($pin_list) > 0 ){
                foreach($list_id as $k_ls => $v_ls){
                    if(in_array($kls , $pin_list))
                        unset($list_id[$k_ls]);
                }
                $list_id = $pin_list + $list_id;
                $results->order(["FIELD(Posts.id, ".implode(',', $list_id).") ASC"]);
            }
            else
                $results->order(['Posts.created'=>'desc']);
        }
        /* SORT end */
        
        $total_results = $results->distinct('Posts.id')->count();
        $data = $this->paginate($results->distinct('Posts.id'), $cond);
        $this->set(compact('data'));
        $this->set([
            'category' => $category,
            'post_type' => $post_type,
            'total_results'=> $total_results 
        ]);
        
        $this->render($this->template.'.index');

        /*try  
        catch (\Exception $e) {$this->render($this->template.'.home');}*/
    }
    //------------------------------------------------------------------
    public function ajax()
    {
        global $is_status;
        global $id ;
        global $category;
        global $post_type;
        global $cond;
        global $results;
        global $index_posttype ;
        global $model;

        $is_status = 'index';
        $index_posttype = $this->Func->OptionGet('index_posttype');

        $this->Fetchs->index();
        if($this->fetch_error == false)
            $this->Fetch->index();
        
        /* SORT Start */
        if($results->toarray()){
            global $list_id;
            $list_id = [];
            foreach($results->toarray() as $tmp){
                $list_id[$tmp['id']] = $tmp['id'];
            }
            $p = $this->getTableLocator()->get('Admin.PostMetas')
                ->find('list',['keyField'=>'post_id','valueField'=>'meta_value'])
                ->where([ "meta_key"=>'pin' ,'post_id IN '=> $list_id])
                ->order(['meta_value' => 'desc'])
                ->toarray();
            foreach($list_id as $k => $list)
                $list_id[$k] = 0;
            foreach($p as $k => $v){
                if(isset($list_id[$k]) and $p[$k] == 1)
                    $list_id[$k] = 1;
                else
                    $list_id[$k] = 0;
            }
            arsort($list_id);
            $tmp_p = [];
            foreach($list_id as $k => $v)
                $tmp_p[$k] = $k;
            $results->order(["FIELD(Posts.id, ".implode(',', $tmp_p).") ASC"]);
        }
        /* SORT end */
        
        $data = $this->paginate($results, $cond);
        $this->set(compact('data'));
        $this->set([
            'category' => $category,
            'post_type' => $post_type,
        ]);
        
        if(isset($this->request->getParam('?')['rss'])){
            try {
                header("Access-Control-Allow-Origin: *");
                $list = null;
                $full_url = \Cake\Routing\Router::url('/',true);
                foreach($results->toarray() as $res){
                    $list[] = [
                        'title' => $res['title'],
                        'slug' => $res['slug'],
                        'excerpt' => $this->Query->the_excerpt($res,100),
                        'link' => $this->Query->permalink('',$res,['return'=>'furl']),
                        'image' => $full_url.$this->Query->postimage('thumbnail',$res),
                        'date' =>  $this->Query->the_time($res),
                    ];
                }
                $response = $this->response->withType('application/json')->withStringBody(json_encode($list));
                return $response;
            } 
            catch (\Exception $e) {
                $response = $this->response->withType('application/json')->withStringBody(json_encode(['status'=>'error']));
                return $response;
            }
        }
        else{
            try{
                $this->render($this->template.'.index_ajax');
            }
            catch (\Exception $e) {
                header("HTTP/1.1 404 Not Found");
                //exit;

                try{
                    $this->render($this->template.'.404');
                }
                catch (\Exception $e) {
                    $this->render($this->template.'.home');
                }  
            }
        }
    }
    //------------------------------------------------------------------
    public function archive()
    {
        //pr("archive");
        global $is_status;
        $is_status = 'archive';

        try {
            $this->render($this->template.'.archive');
        } catch (\Exception $e) {
            try {
                $this->render($this->template.'.index');
            } catch (\Exception $e) {
                $this->render($this->template.'.home');
            }
        }
    }
    //------------------------------------------------------------------
    public function category()
    {
        //pr("category");
        global $is_status;
        global $id ;
        global $category;
        global $post_type;
        global $cond;
        global $results;
        global $index_posttype ;
        global $model;
        $is_status = 'category';

        $id = ($this->request->getParam('catid'))?strip_tags($this->request->getParam('catid')):null;
        $post_type = ($this->request->getParam('posttype'))?strip_tags($this->request->getParam('posttype')):null;
        $category = null;
        if( $id != null ):
            $category = $this->Query->category('',['get_type' => 'first','id' => intval($id) ]);
        endif;

        $this->set([
            'category' => $category,
            'post_type' => $post_type,
        ]);
        if($this->fetch_error == false)
            $results = $this->Fetch->category();
        $results = $this->paginate($results->distinct());
        $this->set(compact('results'));
        try {
            $this->render($this->template.'.category');
        } 
        catch (\Exception $e) {$this->render($this->template.'.home');}
    }
    //------------------------------------------------------------------
    public function catsingle()
    {
        //pr("cat single");
        global $is_status;
        $is_status = 'cat_single';

        $id = ($this->request->getParam('catid'))?strip_tags($this->request->getParam('catid')):null;
        $post_type = ($this->request->getParam('posttype'))?strip_tags($this->request->getParam('posttype')):null;

        $category = null;
        if( $id != null):
            $category = $this->Query->category('',['get_type' => 'first','id' => intval($id) ]);
        endif;

        $this->set([
            'category' => $category,
            'post_type' => $post_type,
        ]);

        if($this->fetch_error == false)
            $result = $this->Fetch->category_single();
        $result = $result->first();
        $this->set(compact('result'));
        
        try {
            $this->render($this->template.'.category_single');
        } 
        catch (\Exception $e){$this->render($this->template.'.home');}
    }
    //------------------------------------------------------------------
    public function single()
    {
        //("Hello");
        //pr("single");
        global $is_status;
        global $id;
        global $post_id;
        global $result;
        $is_status = 'single';
        if($this->request->getParam('id') )
            $id = $this->request->getParam('id');
        else
            $id = null;

        try{
            try{
                $this->Fetchs->single();
            }catch (\Exception $e){}

            try{
                if($this->fetch_error == false)
                    $this->Fetch->single();
            }catch (\Exception $e){}
        }
        catch (\Exception $e){
            header("HTTP/1.1 404 Not Found", true, 404);
            try{exit($this->render($this->template.".404"));}
            catch (\Exception $e){exit($this->render('404'));}
        }
        
        $post_type = null;
        if(isset($result['post_type']))
            $post_type = $result['post_type'];

        $metalist = $this->Func->MetaList($result);
        if(!isset($result['title']) or $result['title'] == NULL){
            if($this->Func->OptionGet('lang_redirect') == 1)
                return $this->redirect('/');
        }

        if($result){
            $post_id = $result['id'];
        }
        $this->set([
            'result' => $result,
            'post_type' => $post_type,
            'metalist' => $metalist
        ]);

        try{
            if(isset($metalist['adpost_passtype']) and $metalist['adpost_passtype'] == 2 and 
            $this->request->getSession()->read('Post.'.$result['id']) != 1){
                if($this->request->is(['post']))
                    $this->redirect($this->referer());

                $this->render("Website.password");
            }
            elseif(isset($metalist['template']) and $metalist['template'] != ''){
                try{
                    $this->render($this->template.'.'.$metalist['template']);
                }
                catch (\Exception $e){
                    $this->render($this->template.'.single');
                }
            }
            else{
                if($post_type == null){
                    header("HTTP/1.1 404 Not Found", true, 404);
                    try{exit($this->render($this->template.".404"));}
                    catch (\Exception $e){exit($this->render('404'));}
                }
                else if($post_type == 'page'){
                    try{
                        $this->render($this->template.'.page');
                    }
                    catch (\Exception $e){
                        $this->render($this->template.'.single');
                    }
                }
                else
                    $this->render($this->template.'.single');
            }
        }
        catch (\Exception $e){
            header("HTTP/1.1 404 Not Found", true, 404);
            try{exit($this->render($this->template.".404"));}
            catch (\Exception $e){exit($this->render('404'));} 
        }
    }
    //------------------------------------------------------------------
    public function tag($slug = null)
    {
        $slug = strip_tags($slug);
        global $is_status;
        global $id ;
        global $category;
        global $post_type;
        global $cond;
        global $results;
        global $index_posttype ;
        global $model;
        $cond = [
            'limit'=> 20,
            'paramType' => 'querystring'
        ];
        $is_status = 'tags';
        $this->Fetchs->tag($slug);
        if($this->fetch_error == false)
            $this->Fetch->tag($slug);
        
        $data = $this->paginate($results, $cond);
        $this->set(compact('data'));
        $this->set([
            'slug' => strip_tags($slug),
        ]);
        
       /*  $this->render($this->template.'.index');

        $templateName = $this->template.'.tag';
        $result = $this->Fetch->tag($slug);
        $data = $this->paginate($result);
        $this->set(compact('data','slug')); */

        try {
            $this->render($this->template.'.tag');
        } catch (\Exception $e) {
            try {
                $this->render($this->template.'.index');
            } catch (\Exception $e) {
                $this->render($this->template.'.home');
            }
        }
    }
    //------------------------------------------------------------------
    public function search($slug = null)
    {
        global $is_status;
        global $slug;
        global $id ;
        global $category;
        global $post_type;
        global $cond;
        global $results;
        global $index_posttype ;
        global $model;
        $cond = [
            'limit'=> 20,
            'paramType' => 'querystring'
        ];
        $is_status = 'search';

        if($this->request->getQuery('s') and $this->request->getQuery('s')!= '')
            $slug = $search_field = strip_tags($this->request->getQuery('s'));

        if($this->request->getQuery('search') and $this->request->getQuery('search')!= '')
            $slug = $search_field = strip_tags($this->request->getQuery('search'));
            
        $this->Fetchs->search($slug);
        if($this->fetch_error == false)
            $this->Fetch->search($slug);

        $data = $this->paginate($results, $cond);
        $this->set(compact('data','search_field'));
        $this->set([
            'data'=> $data,
            'slug' => $slug,
            'search_field'=> $search_field,
        ]);
        /* $search_field = null;
        $data = [];
        if(isset($this->request->getParam('?')['s']))
            $search_field = $slug = $this->request->getParam('?')['s'];
        if($slug): 
            $data = $this->Fetch->search($slug);
            $data = $this->paginate($data->distinct());
        endif;
        $this->set(compact('data','search_field')); */

        try {
            $this->render($this->template.'.search');
        } catch (\Exception $e) {
            try {
                $this->render($this->template.'.index');
            } catch (\Exception $e) {
                $this->render($this->template.'.home');
            }
        }
    }
    //------------------------------------------------------------------
    public function getdata(){ //last edit : 1398.7.15
        /* 
            type : post , category , tags
            ret  : list , all , first
        */
        //if( !$this->request->is('ajax')) die('access denied');
        //Log::write('debug',json_decode($this->request->getParam('?')['extra']));

        $post_type  = isset($this->request->getParam('?')['posttype'])?$this->request->getParam('?')['posttype']:'post';
        $limit  = isset($this->request->getParam('?')['limit'])?$this->request->getParam('?')['limit']:'6';
        $type       = isset($this->request->getParam('?')['type'])?$this->request->getParam('?')['type']:null;
        $id         = isset($this->request->getParam('?')['id'])?$this->request->getParam('?')['id']:'0';
        $ret        = isset($this->request->getParam('?')['ret'])?$this->request->getParam('?')['ret']:null;
        $extra      = isset($this->request->getParam('?')['extra'])?$this->request->getParam('?')['extra']:null;
        $extra = json_decode(json_encode(json_decode($extra)), true);

        $where = [];
        
        if(isset($this->request->getParam('?')['where'])){
           foreach(explode(',',$this->request->getParam('?')['where']) as $v){
               $temp = explode(':',$v);
               $where[$temp[0]] = isset($temp[1])?$temp[1]:"-";
           }
        }
        if($type == 'post'){
            $cond = $where + [
                'field'=>['id','title','slug','post_type'],
                'contain'=>['PostMetas'],
                'limit' => $limit,
                'find_type'=>'all',
                'parent' => (isset($extra['parent'])? intval($extra['parent']) : null),
            ];
            $data = $this->Query->post($post_type, $cond);

            global $result;
            foreach($data as $k => $result){
                $data[$k]['the_permalink']= $this->Query->the_permalink(['id'=> $result['id']]);
                $data[$k]['the_image']= $this->Query->the_image(['size'=>'thumbnail']);

                if(isset($result['categories']) and count($result['categories']) > 0){
                    foreach($result['categories'] as $ck => $cresult){
                        unset(
                            $data[$k]['categories'][$ck]['created'],
                            $data[$k]['categories'][$ck]['_joinData'],
                            $data[$k]['categories'][$ck]['lft'],
                            $data[$k]['categories'][$ck]['rght']
                        );
                        $data[$k]['categories'][$ck]['the_permalink'] = $this->Query->the_permalink(['id'=> $cresult['id'],'type'=>'index','data_type'=>'category']);
                    }
                }
                unset($data[$k]['post_metas']);
                //unset($data[$k]['categories']);
            }
        }
        elseif($type == 'category'){
            $data = $this->Query->category($post_type,[
                'field'=>['id','title'],
                'find_type'=>'treeList',
                'parent' => (isset($extra['parent'])? intval($extra['parent']) : null),
            ]);
        }
        else
            $data = [];
        $response = $this->response->withType('application/json')->withStringBody(json_encode($data));
        return $response;
    }
    //------------------------------------------------------------------
    public function robots(){

        $index_posttype = $this->Func->OptionGet('index_posttype');
        if($index_posttype != null)
            $index_posttype = unserialize($index_posttype);
        else
            $index_posttype = [];
        $text = "User-agent: *\r\n";
        foreach($index_posttype as $pt){
            $text.= 'Sitemap: '.Router::url('/',true) .$pt.'-sitemap.xml'."\n";
        }
        $response = $this->response->withStringBody($text);
        return $response;
    }
    //------------------------------------------------------------------
    public function sitemap(){
        $index_posttype = $this->Func->OptionGet('index_posttype');
        $text ='<?xml version="1.0" encoding="UTF-8"?>
        <urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        
        global $result;
        foreach(TableRegistry::getTableLocator()->get('Admin.Posts')->find('all')
            ->order(['Posts.created'=>'desc'])
            ->contain(['Categories','Tags','PostMetas','PostsI18n'])
            ->where([ 'Posts.published' => 1,'post_type IN '=>unserialize($index_posttype) ]) as $result){
                $text .= '<url>
                    <loc>'.$this->Query->the_permalink().'</loc>
                    <lastmod>'.$result->modified->format('Y-m-d').'</lastmod>
                    <priority>0.9</priority>
                </url>';
            }
        $text .= '</urlset>';
        $response = $this->response->withType('application/xml')->withStringBody($text);
        return $response;
    }
    //------------------------------------------------------------------
    public function sitemapIndex($id = null){
        $index_posttype = $this->Func->OptionGet('index_posttype');
        if($index_posttype != null)
            $index_posttype = unserialize($index_posttype);
        else
            $index_posttype = [];
$text ='<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        if($id != null){
            global $result;
            foreach(TableRegistry::getTableLocator()->get('Admin.Posts')->find('all')
                ->order(['Posts.created'=>'desc'])
                ->contain(['Categories','Tags','PostMetas','PostsI18n'])
                ->where([ 'Posts.published' => 1,'post_type IN '=> (in_array($id,$index_posttype)?$id:'post') ]) as $result){
                    $text .= '<sitemap>
                        <loc>'.$this->Query->the_permalink().'</loc>
                        <lastmod>'.$result->modified->format('Y-m-d').'</lastmod>
                    </sitemap>';
                }
        }
        else{
            foreach($index_posttype as $pt){
$text.= "\n".'<sitemap>
    <loc>'. Router::url('/',true) .$pt.'-sitemap.xml</loc>
    <lastmod>'.date('Y-m-d').'</lastmod>
</sitemap>';
            }
        }
        $text .= "\n".'</sitemapindex>';
        $response = $this->response->withType('application/xml')->withStringBody($text);
        return $response;
    }
    //------------------------------------------------------------------
    public function image(){
        $this->autoRender = false;
        //header('Content-type: image/jpg' );
        $media = TableRegistry::getTableLocator()->get('Admin.Medias')->get('325');
        $tmp = stream_get_meta_data($media['image']); 
        //return ;
        $response = $this->response->withFile(file_get_contents($tmp['uri']));
        return $response;

        exit();
    }
}