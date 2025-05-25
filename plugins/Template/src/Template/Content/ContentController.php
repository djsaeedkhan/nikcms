<?php
namespace Shop\Controller;

use Shop\Controller\AppController;
use Cake\Controller\Controller;
use Cake\Core\Configure;
use Cake\Event\EventInterface;
use Cake\Core\Plugin;
use Cake\View\CellTrait;
use Cake\ORM\TableRegistry;
use Cake\Http\Exception\NotFoundException;
use Shop\View\Helper\ShopHelper;

class ContentController extends AppController
{
    public $template;
    public function initialize(): void
    {
        parent::initialize();
        $this->template = $this->Func->OptionGet('website_template');
        $this->viewBuilder()->setTheme($this->template);
        if (Plugin::isLoaded($this->template) !== true) {
            //die ($this->render('Website.home'));
            return $this->render('Website.home');
        } 
        $this->viewBuilder()->setLayout($this->template.'.default');
        $this->loadComponent('Website.Fetchs');
    }
    //-----------------------------------------------------------
    public function beforeFilter(EventInterface $event)
    {
        $this->Authentication->addUnauthenticatedActions();
    }
    //-----------------------------------------------------------
    public function home(){
        try{
            $this->render($this->template.'.product_home');
        }
        catch (\Exception $e) {
            try{$this->render('Shop.home');}
            catch (\Exception $e) {
                try{$this->render($this->template.'.404');}
                catch (\Exception $e) {return $this->render('Website.404');}
            }
        }
    }
    //-----------------------------------------------------------
    public function index(){
        global $is_status;
        global $id ;
        global $category;
        global $post_type;
        global $cond;
        global $results;
        $cond = ['limit'=> 20,'paramType' => 'querystring' ];
        $post_type = 'product';
        $is_status = 'index';
        $this->Fetchs->index();

        //***** Brand *****//
        if($this->request->getQuery('brand') or $this->request->getParam('brands')){
            $brand = $this->request->getParam('brands') ?? $this->request->getQuery('brand');
            $brand = strip_tags((string) $brand);
            $brand = $this->getTableLocator()->get('Shop.ShopBrands')->find('all')
                ->where([
                    'OR'=>[
                        ['slug' => $brand],
                        ['title' => str_replace('-', ' ', $brand)],
                        ['title' => $brand]
                    ]])
                ->first();
            if( isset($brand['id']) ){
                $results->join([
                    'table' => 'shop_product_metas','alias' => "shpm1",'type' => 'LEFT',
                    'conditions' => ["shpm1.post_id = Posts.id"] ]);
                $results->where([
                    "shpm1.meta_key"=>'brands', 
                    "shpm1.meta_value"=> $brand['id'] ]);
            }
            $this->set([
                'brands'=> $brand,
            ]);
        }

        if($this->request->getParam('pass') and $this->request->getParam('pass')[0] = 'amazing' ){
            $results->join([
                'table' => 'shop_product_metas','alias' => "shpm_label",'type' => 'LEFT',
                'conditions' => ["shpm_label.post_id = Posts.id"] ]);
            $results->where([
                "shpm_label.meta_key"=>'special_price_check', 
                "shpm_label.meta_value"=> 1 ]);
            $this->set([
                'amazing'=> "amazing",
            ]);
        }
        
        //***** Label *****//
        if($this->request->getQuery('label') or $this->request->getParam('label')){
            $label = null;
            if($this->request->getParam('label'))
                $label = $this->request->getParam('label');
            elseif($this->request->getQuery('label'))
                $label = $this->request->getQuery('label');
                
            $label = strip_tags($label);
            $label = $this->getTableLocator()->get('Shop.ShopLabels')->find('all')
                ->where([ 'title' =>$label ])
                ->first();
            if( isset($label['id']) ){
                $results->join([
                    'table' => 'shop_product_metas','alias' => "shpm_label",'type' => 'LEFT',
                    'conditions' => ["shpm_label.post_id = Posts.id"] ]);
                $results->where([
                    "shpm_label.meta_key"=>'label', 
                    "shpm_label.meta_value"=> $label['id'] ]);
            }
            $this->set([
                'label'=> strip_tags($label),
            ]);
        }

        global $list_id;
        $list_id = [];
        foreach($results->toarray() as $tmp){
            $list_id[$tmp['id']] = $tmp['id'];
        }
        
        $sort = ShopHelper::Setting('default_sort');

        //***** Sort *****//
        if($this->request->getQuery('sort') or $sort != '' ){
            if($this->request->getQuery('sort') != '')
                $sort = strip_tags($this->request->getQuery('sort'));

            if($list_id):

                $temp_stock = [];
                foreach($list_id as $li){
                    $tmp['stock'] = ShopHelper::get_Stocklist($li);
                    if(ShopHelper::get_StockStatus($tmp))
                        $temp_stock[$li] = 1;
                    else
                        $temp_stock[$li] = 0;
                }

                switch ( $sort ) {
                    case 'price.desc':
                    case 'price.asc':
                        $p = $this->getTableLocator()->get('Shop.ShopProductMetas')
                            ->find('list',['keyField'=>'post_id','valueField'=>'post_id'])
                            ->where([ "meta_key"=>'price','post_id IN '=> $list_id])
                            ->toarray();
                        $price = [];
                        global $result;
                        foreach($p as $pp){
                            $price[$pp] = intval(str_replace(',','',ShopHelper::PriceGet($pp)));
                            unset($result['shop_metas']);
                        }
                        /* if(strtolower($sort == 'price.asc')) asort($price);
                        else arsort($price); */

                        /* foreach($price as $k=>$pr)
                            $price[$k] = $k; */

                        foreach(array_reverse($list_id,true) as $k => $v){
                            if(isset($price[$k]) and $price[$k] != 0)
                                $temp[1][$k] = $price[$k];
                            else
                                $temp[0][$k] = $price[$k];
                        }
                        if(strtolower($sort == 'price.asc'))
                            asort($temp[1]);
                        else arsort($temp[1]);
                        $temp1 = (isset($temp[1])?$temp[1]:[]) + (isset($temp[0])?$temp[0]:[]);  
                        
                        $temp2 = [];
                        foreach($temp1 as $k=>$pr)
                            $temp2[$k] = $k;
                        $results->order(["FIELD(Posts.id, ".implode(',', $temp2).")"]);
                        //$results->order(["FIELD(Posts.id, ".implode(',', $price).")"]);
                        break;

                    case 'view.desc': //پربازدیدترین
                        $p = $this->getTableLocator()->get('Admin.PostMetas')
                            ->find('list',['keyField'=>'post_id','valueField'=>'meta_value'])
                            ->where([ "meta_key"=>'post_views' ,'post_id IN '=> $list_id])
                            ->order(['meta_value' => 'desc'])
                            ->toarray();

                        foreach($list_id as $k => $list)
                            $list_id[$k] = 0;
                        
                        foreach($p as $k=>$v){
                            if(isset($list_id[$k])){
                                if(isset($temp_stock[$k]) and $temp_stock[$k] == 1)
                                    $list_id[$k] = $v;
                                else
                                    $list_id[$k] = 0;
                            }
                        }

                        arsort($list_id);
                        $tmp_p = [];
                        foreach($list_id as $k => $v)
                            $tmp_p[$k] = $k;
                        $results->order(["FIELD(Posts.id, ".implode(',', $tmp_p).") ASC"]);
                        break;

                    case 'order.desc': //پرفروش ترین
                        $query = $this->getTableLocator()->get('Shop.ShopOrderproducts')
                            ->find('list',['keyField'=>'post_id','valueField'=>'count']); 
                        $p  = $query->select(['post_id','count' => $query->func()->count('post_id')])
                            ->group(['post_id'])
                            ->enableHydration(false)
                            ->where(['post_id IN '=> $list_id])
                            ->order(['count'=>'desc'])
                            ->toarray();

                        foreach($list_id as $k=>$list)
                            $list_id[$k] = 0;
                        
                        foreach($p as $k=>$v){
                            if(isset($list_id[$k])){
                                if(isset($temp_stock[$k]) and $temp_stock[$k] == 1)
                                    $list_id[$k] = $v;
                                else
                                    $list_id[$k] = 0;
                            }
                        }
                        arsort($list_id);

                        $tmp_p = [];
                        foreach($list_id as $k => $v)
                            $tmp_p[$k] = $k;

                        $results->order(["FIELD(Posts.id, ".implode(',', $tmp_p).") ASC"]);

                        break;

                    case 'popularity.desc': //محبوب ترین
                        $query = $this->getTableLocator()->get('Shop.ShopFavorites')
                            ->find('list',['keyField'=>'post_id','valueField'=>'count']); 
                        $p = $query->select(['post_id','count' => $query->func()->count('post_id')])
                            ->group(['post_id'])
                            ->enableHydration(false)
                            ->where(['post_id IN '=> $list_id])
                            ->order(['count'=>'desc'])
                            ->toarray();
                        
                        foreach($list_id as $k=>$list)
                            $list_id[$k] = 0;
                        
                        foreach($p as $k=>$v){
                            if(isset($list_id[$k])){
                                if(isset($temp_stock[$k]) and $temp_stock[$k] == 1)
                                    $list_id[$k] = $v;
                                else
                                    $list_id[$k] = 0;
                            }
                        }
                        arsort($list_id);
                        
                        $tmp_p = [];
                        foreach($list_id as $k => $v)
                            $tmp_p[$k] = $k;

                        $results->order(["FIELD(Posts.id, ".implode(',', $tmp_p).") ASC"]);
                        break;

                    case 'new.desc': //جدیدترین
                        $temp = [] ;
                        foreach(array_reverse($list_id,true) as $k => $v){
                            if(isset($temp_stock[$k]) and $temp_stock[$k] == 1)
                                $temp[1][$k] = $v;
                            else
                                $temp[0][$k] = $v;
                        }
                        $temp1 = (isset($temp[1])?$temp[1]:[]) + (isset($temp[0])?$temp[0]:[]);
                        $results->order(["FIELD(Posts.id, ".implode(',', $temp1).") ASC"]);
                        break;

                    case 'stock.asc': //موجودی
                    case 'stock.desc': //موجودی
                    default:
                        $temp = [];
                        foreach($list_id as $li){
                            $tmp['stock'] = ShopHelper::get_Stocklist($li);
                            if(ShopHelper::get_StockStatus($tmp))
                                $temp[$li] = 1;
                            else
                                $temp[$li] = 0;
                        }
                        asort($temp);
                        
                        $tmp_p = [];
                        foreach($temp as $k => $v)
                            $tmp_p[$k] = $k;

                        if($sort == 'stock.asc')
                            $results->order(["FIELD(Posts.id, ".implode(',', $tmp_p).") ASC"]);
                        else
                            $results->order(["FIELD(Posts.id, ".implode(',', $tmp_p).") DESC"]);
                        break;
                }
            endif;
            //Way 2 : //$cond['order'] = 'FIELD(Posts.id, '.implode(',', $price).')';
        }
        else{
            $results->order(['Posts.created'=>'desc']);
        }

        try{
            if(isset($this->request->getParam('pass')[0]) and $this->request->getParam('pass')[0] =='json'){
                $cond['limit'] = 100;
                if(!count($results->toarray())):
                    //echo "asdasd";
                endif;
            }
            $data = $this->paginate($results->distinct('Posts.id'),$cond);
        }
        catch (\Exception $e) {
            try{
                return $this->render($this->template.'.404');
            }catch (\Exception $ee) {
                return $this->render('Website.404');
            }
        }
        
        $this->set(compact('data'));
        $this->set([
            'category' => $category,
            'post_type' => $post_type,
        ]);

        if(isset($this->request->getParam('pass')[0]) and $this->request->getParam('pass')[0] =='json'){
            $temp = [];
            global $result;
            $i= 0;
            if(count($results->toarray())):
                foreach($results->toarray() as $rs){
                    $result = null;
                    $sku = ShopHelper::Meta('sku' , $rs['id']);
                    $temp[] = [
                        'product_id' => $sku != '' ?$sku : $rs['id'],
                        'page_url' => $this->Query->the_permalink(['id'=>$rs['id']]),
                        'price' => (ShopHelper::CheckSpPrice() != false)?ShopHelper::CheckSpPrice():ShopHelper::PriceGet(),
                        'availability' => $result['stock_state'] == true ?'instock':'',
                    ];
                    if(ShopHelper::CheckSpPrice() != false){
                        $temp[$i]['old_price'] = ShopHelper::PriceGet($rs['id'], ['with_spprice'=>1]);
                    }
                    $i++;
                }
            endif;
            $response = $this->response->withStringBody(json_encode($temp));
            return $response;
        }
        try{
            $this->render($this->template.'.product_index');
        }
        catch (\Exception $e) {
            try{$this->render('Shop.index');}
            catch (\Exception $e) {
                try{$this->render($this->template.'.404');}
                catch (\Exception $e) {return $this->render('Website.404');}
            }
        }
    }
    //-----------------------------------------------------------
    public function single(){
        global $is_status;
        global $id;
        global $result;

        $is_status = 'single';
        $id = null;
        
        $this->loadComponent('Website.Fetchs');
        $this->loadComponent('Template.Fetch');

        try{
            $result = $this->Fetchs->single();
            $result = $this->Fetch->single( $id );
        }
        catch (\Exception $e){
            try{
                return $this->render("Template.404");
            }
            catch (\Exception $e){
                return $this->render("Website.404");
            }
            throw new NotFoundException(__('Product not found'));
        }

        /* $result['shop_metas'] = $this->getTableLocator()->get('Shop.ShopProductMetas')
            ->find('list',['keyField'=>'meta_key','valueField'=>'meta_value'])
            ->where(['post_id' => $id ])
            ->toArray(); */
        $post_type = $result['post_type'];
        $metalist = $this->Func->MetaList($result);
        
        $this->set([
            'result' => $result,
            'post_type' => $post_type,
            'metalist' => $metalist
        ]);

        try{
            $this->render($this->template.'.product_single');
        } catch (\Exception $e) {
            try{$this->render('Shop.single');}
            catch (\Exception $e) {
                try{$this->render($this->template.'.404');}
                catch (\Exception $e) {return $this->render('Website.404');}
            }
        }
    }
    //-----------------------------------------------------------
    public function category(){
        try{
            $this->render($this->template.'.product_category');
        }
        catch (\Exception $e) {
            try{$this->render('Shop.category');}
            catch (\Exception $e) {
                try{$this->render($this->template.'.404');}
                catch (\Exception $e) {return $this->render('Website.404');}
            }
        }
    }
    //-----------------------------------------------------------
    public function search($slug = null){
        $slug = strip_tags($slug);
        $search_field = null;
        $data = [];
        try {
            if(isset($this->request->getParam('?')['s']))
                $search_field = $slug = strip_tags($this->request->getParam('?')['s']);

            if($slug): 
                $model = $this->getTableLocator()->get('Admin.Posts');
                $result = $model->find('all')
                    ->order(['Posts.created'=>'desc'])
                    ->contain(['Categories','Tags','PostMetas'])
                    ->where([
                        'Posts.published' => 1,
                        'post_type'=>'product',
                        'OR' => [
                            $model->translationField('title').' LIKE' => "%$slug%",
                            $model->translationField('content').' LIKE' => "%$slug%"],
                        ]);  
                    
                $data = $this->paginate($result->distinct('Posts.id'));
            endif;
            $this->set(compact('data','search_field'));
        
            try {$this->render($this->template.'.product_search');}
            catch (\Exception $e) {
                $this->render($this->template.'.product_index');
            }

        } catch (\Exception $e) {
            $this->render($this->template.'.home');
        }
    }
    //-----------------------------------------------------------
    public function Getdata(){
        $this->render(false);
        $this->autoRender = false;
        Configure::write('debug', 0);
        $response = $this->response->withStringBody(0);
        if ($this->request->is(['ajax'])){
            if(isset($this->request->getData()['type']) and $this->request->getData()['type'] == 'stock'){
                $response = $this->response->withStringBody(ShopHelper::Stock(null, $this->request->getData()));
            }
            elseif(isset($this->request->getData()['type']) and $this->request->getData()['type'] == 'wholelist'){
                $response = $this->response->withStringBody(ShopHelper::get_Wholesale($this->request->getData()['id'], $this->request->getData()['attrs']));
            }
            else
                $response = $this->response->withStringBody(ShopHelper::PriceCalc($this->request->getData()));
        }elseif ($this->request->is(['get'])){
            $response = $this->response->withStringBody("bad query string");
        }
        return $response;
    }
    //-----------------------------------------------------------
    public function Price(){
        $this->render(false);
        $this->autoRender = false;
        try{
            if(ShopHelper::Setting('getprice_enable') != 1)
                return;

                $tala_now = 0;
            switch (ShopHelper::Setting('getprice_type')) {
                case 'persianapi':
                    //header('Content-Type: application/json'); // Specify the type of data
                    $ch = curl_init('https://studio.persianapi.com/index.php/web-service/gold'); // Initialise cURL
                    $post = json_encode([
                        'format' => 'json',
                        'limit' => '30',
                        'page' => '1',
                    ]);
                    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.2; WOW64; rv:17.0) Gecko/20100101 Firefox/17.0');
                    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , 'Authorization: Bearer mv4hft8it1ge1vfoikgq')); // Inject the token into the header
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET"); // Specify the request method as POST
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $post); // Set the posted fields
                    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); // This will follow any redirects
                    $result = curl_exec($ch); // Execute the cURL statement
                    $status_code = curl_getinfo( $ch )['http_code'] ?? 0;
                    curl_close($ch); // Close the cURL connection
                    if ( $status_code == 200 ) {
                        $response = json_decode( $result,true );
                        if(isset($response['result']['data'][0]['قیمت'])){
                            $tala_now = $response['result']['data'][0]['قیمت']; 
                        }
                    } else {
                        echo '<br> error not 200, status code:' . $status_code;
                    }
                    break;
                
                default:
                    $tala_now = trim(str_replace(',','',ShopHelper::Setting('gold_now_price')));
                    break;
            }

            if(intval($tala_now) == 0)
                return;
                
            $this->Meta =  $this->getTableLocator()->get('Shop.ShopProductMetas');
            $result = $this->Meta->find('all')
                ->order(['ShopProductMetas.id'=>'desc'])
                ->contain(['Posts'=>['ShopProductMetas']])
                ->where([
                    'ShopProductMetas.meta_key' => "price_type",
                    'ShopProductMetas.meta_value IS NOT NULL'
                    ])
                ->toarray();  

            foreach($result as $ar){
                if($ar['meta_value'] == "gold" and isset($ar['post']['shop_product_metas'][0])){
                    $metalist = $this->Func->MetaList($ar['post']);

                    if(is_array($metalist) and isset($metalist['weight']) and $metalist['weight'] != "" ){
                        $new_price = $tala_now * $metalist['weight'];

                        if($new_price != $metalist['price'] and intval($new_price) > 0 ){
                            $this->Meta->query()->update()
                                ->set(['meta_value' => $new_price  ])
                                ->where([
                                    'meta_key' => "price",
                                    'post_id' => $ar['post']['id'],
                                    ])
                                ->execute();
                        }
                    }
                }
            }
            echo 'Work Correctly';
        }
        catch (\Exception $e){
            try{
                return $this->render("Template.404");
            }
            catch (\Exception $e){
                return $this->render("Website.404");
            }
            throw new NotFoundException(__('Product not found'));
        }
       
    }
    //-----------------------------------------------------------
}