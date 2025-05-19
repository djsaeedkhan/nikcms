<?php
namespace Shop\View\Helper;

use Admin\View\Helper\FuncHelper;
use Admin\View\Helper\QueryHelper;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;
use Cake\View\Helper;
use Cake\View\View;
use Cake\Core\Plugin;
use Cake\I18n\Time;
use \Cake\View\Cell;
use \Cake\View\CellTrait;
use Cake\View\Helper\FormHelper;
use Cake\View\Helper\HtmlHelper;
use Shop\Model\Entity\ShopParam;
use Shop\Predata;

class ShopHelper extends Helper
{
    public $helpers = ['Html','Form','Session'];
    protected $_defaultConfig = [];
    public static $setting;
    ////////////////////////////////////////////////////////////////////////////////
    public static function GetAllSetting(){
        //$result = $this->Func->OptionGet('plugin_shop');
        $result = TableRegistry::getTableLocator()->get('Admin.Options')
            ->find('list',['keyField'=>'name','valueField'=>'value'])
            ->where(['name' => 'plugin_shop'])
            ->toArray();
        self::$setting = isset($result['plugin_shop'])? unserialize($result['plugin_shop']) :[];
    }
    ////////////////////////////////////////////////////////////////////////////////
    public static function Setting($key = null){
        if(self::$setting == null)
            ShopHelper::GetAllSetting();

        if(isset(self::$setting[$key]))
            return self::$setting[$key];
        else
            return null;
    }
    ////////////////////////////////////////////////////////////////////////////////
    public static function get_brands($title = null, $options = []){
        $brands = TableRegistry::get('Shop.ShopBrands')->find('all')
            ->where([ $title!= null?['OR'=>[
                    'slug' => $title , 
                    'title' => str_replace('-',' ', $title),
                    'title' => $title ]]:false])
            //->limit(isset($options['limit']) ?$options['limit']:false)
            /* ->select(['view_count' => 'COUNT(a.post_id)'])
            ->enableAutoFields(true)
            ->join([
                'a' => [
                    'table' => 'shop_product_metas',
                    'type' => 'LEFT',
                    'conditions' => 'a.meta_value = ShopBrands.id',
                ],
                
            ]) */
            /* ->leftJoinWith([
                'table' => 'shop_product_metas',
                'alias' => 'a',
                'type' => 'LEFT',
                'conditions' => [
                    'a.meta_key' =>'brands',
                    'a.meta_value = ShopBrands.id',
                    ]
            ]) */
            ->toarray();

        if( isset($options['width_product']) ){
            foreach( $brands as $k => $value){
                switch ($options['width_product']['type']) {
                   
                    case 'count':
                        $brands[$k]['product_count'] = TableRegistry::get('Shop.ShopProductMetas')
                            ->find('all')
                            ->where([
                                'meta_key' =>'brands',
                                'meta_value'=>$value['id']
                                ])
                            ->distinct('id')
                            ->count();
                        break;
                    
                    default:
                        $brands[$k]['product_all'] = TableRegistry::get('Shop.ShopProductMetas')
                            ->find('all')
                            ->where([
                                'meta_key' =>'brands',
                                'meta_value'=>$value['id']
                                ])
                            ->distinct('id')
                            ->toarray();
                        break;
                }
                
            }
        }
        return $brands;
    }
    ////////////////////////////////////////////////////////////////////////////////
    public static function get_labels($title = null, $options = []){
        $title = strip_tags($title);
        $labels = TableRegistry::get('Shop.ShopLabels')
            ->find('all')
            ->where([ 'title' =>$title ])
            ->limit(isset($options['limit']) ?$options['limit']:false)
            ->toarray();

        if( isset($options['width_product']) ){
            foreach( $labels as $k => $value){
                switch ($options['width_product']['type']) {
                   
                    case 'count':
                        $labels[$k]['product_count'] = TableRegistry::get('Shop.ShopProductMetas')
                            ->find('all')
                            ->where([
                                'meta_key' =>'label',
                                'meta_value'=>$value['id']
                                ])
                            ->distinct('id')
                            ->count();
                        break;
                    
                    default:
                        $labels[$k]['product_all'] = TableRegistry::get('Shop.ShopProductMetas')
                            ->find('all')
                            ->where([
                                'meta_key' =>'label',
                                'meta_value'=>$value['id']
                                ])
                            ->distinct('id')
                            ->toarray();
                        break;
                }
            }
        }
        return $labels;
    }
    ////////////////////////////////////////////////////////////////////////////////
    public static function getcart(){
        return Router::getRequest()->getSession()->read('Shop');
    }
    ////////////////////////////////////////////////////////////////////////////////
    public static function prepare($id = null) {
        global $result;
        global $is_status;

        if($result == null or !isset($result['shop_metas']) ){
            $result['shop_metas'] = TableRegistry::get('Shop.ShopProductMetas')
                ->find('list',['keyField'=>'meta_key','valueField'=>'meta_value'])
                ->where(['post_id' => $id ])
                ->toArray();
                
            if(isset($result['shop_metas']['product_type']) and $result['shop_metas']['product_type'] == 'wholesale'){
                $result['shop_metas']['wholesale'] = TableRegistry::get('Shop.ShopProductmajors')
                    ->find('all')
                    ->enableHydration(false)
                    ->select(['id','start','pattern','price'])
                    ->where(['post_id' => $id ])
                    ->toArray();
            }
            $result['stock'] = ShopHelper::get_Stocklist($id);
            $result['stock_state'] = ShopHelper::get_StockStatus($result);
            if($is_status == 'single')
                $result['stock_first'] = ShopHelper::get_StockStatus($result,'first');
        }
    }
    ////////////////////////////////////////////////////////////////////////////////
    public static function Imagelist($var = null, $options = null) {
        global $result;
        if($var != null)
            $result = $var;

        ShopHelper::prepare($result['id']);
        $list = [];
        if(isset($result['shop_metas'])){
            $temp = $result['shop_metas'];
            $cnt = ShopHelper::Setting('product_image_count')?ShopHelper::Setting('product_image_count'):5;
            for($i=0;$i<$cnt;$i++){
                if(isset($temp['gallery'.$i]) and $temp['gallery'.$i] != ''){
                    $list[] = [
                        isset($temp['gallery'.$i])?$temp['gallery'.$i]:'',
                        isset($temp['gallery'.$i.'_alt'])?$temp['gallery'.$i.'_alt']:''
                    ];
                }
            }
        }
        if(isset($options['get'])){
            switch ($options['get']) {
                case 'first':
                    return  isset($list[0])?$list[0]: null;
                    break;
            }
        }
        return $list;
    }
    ////////////////////////////////////////////////////////////////////////////////
    public static function ProductDetail($id = null) {
        if($id == null)
            global $id;
        $data = [];

        $pid = self::Meta('param_id',$id);
        if(!$pid) 
            return $data;

        $lists = TableRegistry::get('Shop.ShopParamlists')->find('all')
            ->where(['shop_param_id'=> $pid ])
            ->enableHydration(false)
            ->order(['priority'=>'asc'])
            ->toarray();

        $temps = TableRegistry::get('Shop.ShopProductParams')
            ->find('list',['keyField'=>'shop_param_id','valueField'=>'value'])
            ->where(['post_id'=> $id])
            ->enableHydration(false)
            ->toarray();
        
        if($temps and $lists){
            foreach($lists as $list){
                if($list['types'] == 2)
                    $data[$list['title']] = '-';
                else{
                    if(isset($list['id'],$temps) and isset($temps[$list['id']]))
                        $data[$list['title']] =  isset($temps[$list['id']])?$temps[$list['id']]:null;
                }
            }
        }
        return $data;
    }
    ////////////////////////////////////////////////////////////////////////////////
    public static function TotalPrice(){
        echo '<div class="total_price_box d-none">
            <span style="float:right">مبلغ قابل پرداخت</span>
            <span class="zoFloatLeft fw-b "><span class="total_price">0</span>'.ShopHelper::CurrencyShow().'</span>
            <div class="clearfix"></div>
        </div>';
    }
    ////////////////////////////////////////////////////////////////////////////////
    public static function get_StockStatus($result = null, $attr = null){
        $no_stock = true;
        if(count($result['stock']) == 0) 
            $no_stock = false;
        else{
            foreach($result['stock'] as $stk){
                if($stk != 0)
                $no_stock = false;
            }
        }
        if($attr != null){
            switch ($attr) {
                case 'first':
                    $temps = $result['stock']; 
                    foreach($temps as $k=>$temp){
                        if($temp == 0)
                            unset($temps[$k]);
                    }
                    $key = array_key_first($temps);
                    return isset($temps[$key])?$key:null;
            }
        }else{
            if($no_stock == true) return false;
            else return true;
        }
    }
    ////////////////////////////////////////////////////////////////////////////////
    public static function get_Stocklist($id = null){
        $result = TableRegistry::get('Shop.ShopProductstocks')
            ->find('list',['keyField'=>'pattern','valueField'=>'stock'])
            ->where(['post_id' => $id ])
            ->toArray();
        return $result;
    }
    ////////////////////////////////////////////////////////////////////////////////
    public static function Stock($id = null, $data = null ){
        global $result;
        if($id == null){
            global $id;
        }
        if(isset($data['id']) and $data['id'] != null ){
            $id = $data['id'];
        }
        
        ShopHelper::prepare($id);
        $str = null;        
        if($data == null)
            $str .= '<div class="shop-stock" id="shop-stock">';
        if(isset($data['qty'])){

            if($data['attrs'] == null) 
                $data['attrs'] = 0;

            if(ShopHelper::Meta('maximum_order') != null and $data['qty'] > ShopHelper::Meta('maximum_order'))
                $str .=  '<script nonce="'.get_nonce.'">alert("حداکثر تعداد سفارش این محصول '.ShopHelper::Meta('maximum_order').' می باشد و تعداد سفارش بیشتر ثبت نخواهد گردید");</script>';
  
            if(ShopHelper::Meta('sold_individually') == 1 and $data['qty'] > 1)
                $str .=  '<script nonce="'.get_nonce.'">alert("این محصول بصورت تک فروشی ارائه می گردد. تعداد بیشتر در سبد خرید ثبت نخواهد شد.");</script>';

            elseif(isset($result['stock'][$data['attrs']])){
                $stock = $result['stock'][$data['attrs']];
                if($stock < $data['qty']){
                    $str .=  'no_stock';
                }
            }
        }
        elseif(ShopHelper::Setting('stock_show') == 1){
            $str .=  'موجودی : <span>'.ShopHelper::Meta('stock').'</span>';
        }
        if($data == null)
            $str .=  '</div>';
        
        return $str;
    }
    ////////////////////////////////////////////////////////////////////////////////
    public static function getStock($id = null , $attr = null){
        global $result;
        if($id == null)
            global $id;
        ShopHelper::prepare($id);

        $lists = TableRegistry::get('Shop.ShopOrders')->find('all')
            ->where(['status' => 'pending' , function($exp) {
                $now1 = Time::now();$now = Time::now();
                $now->modify('-60 minutes');
                return $exp->between('created', $now->format('Y-m-d H:i:s') , $now1->format('Y-m-d H:i:s') , 'date');
            }])
            ->contain(['ShopOrderproducts' => function($query) use ($id) {
                return $query->where(['post_id' => $id]);
            }])
            ->enableHydration(false)
            ->toarray();

        if($lists){
            foreach($lists as $list){if(isset($list['shop_orderproducts'])){
                foreach($list['shop_orderproducts'] as $temp){
                    if(isset($temp['attrs']) and $temp['attrs'] == null )
                        $temp['attrs'] = 0;

                    if(isset($result['stock'][$temp['attrs']])){
                        $result['stock'][$temp['attrs']] = $result['stock'][$temp['attrs']] - $temp['quantity'];
                    }
                }
            }}
        }
        
        /* if($attr === null)
            return isset($result['stock'])?$result['stock']:'-'; */
        if($attr == '') 
            $attr = 0;
            
        if($attr == null )
            return $result['stock'];
        if(isset($result['stock'][$attr]))
            return $result['stock'][$attr];
        else 
            return false; 
    }
    ////////////////////////////////////////////////////////////////////////////////
    public static function updateStock($id = null , $attr = null, $count = null){
        global $result;
        if($id == null)
            global $id;
        ShopHelper::prepare($id);
        
        if($attr === null)
            return $result['stock'];
            
        if($attr == '') $attr = 0;
        
        if(isset($result['stock'][$attr]))
            return $result['stock'][$attr];
        else 
            return false; 
    }
    ////////////////////////////////////////////////////////////////////////////////
    
    public static function PriceCalc($data = null){
        global $result;
        $price = 0;
        if(isset($data['id']) and $data['id'] != ''){
            global $id;
            $id = intval($data['id']);
            ShopHelper::prepare($id);
        }
        $temp = null;
        if(isset( $data['attrs'])){
            $temp = TableRegistry::get('Shop.ShopProductdetails')->find('all')
                ->where(['post_id'=> $data['id'],'pattern' => $data['attrs'] ])
                ->first();
        }
            
        $meta = $result['shop_metas'];
        if(isset($meta['price']) and $meta['price'] != ''){
            $price = $meta['price'];
            $price = preg_replace('/[^0-9]/', '',$price);
        }
        elseif($data['attrs'] and $data['attrs']){
            if($temp){
                $price = $temp['price'];
                $price = preg_replace('/[^0-9]/', '',$price);
            }
        }

        if( ($spr = ShopHelper::CheckSpPrice()) != false){
            $price = $spr;
        }
        elseif( isset($meta['product_type']) and  $meta['product_type'] == 'wholesale'){
            $list_p = [];
            $list_s = [];
            foreach($meta['wholesale'] as $sale){
                if( $sale['pattern'] == $data['attrs'] ){
                    $list_p[] = $sale['price'];
                    $list_s[] = $sale['start'];
                }
            }

            $i=0;
            $p_find = false;
            foreach($meta['wholesale'] as $sale){
                if( $sale['pattern'] == $data['attrs'] ){
                    $start = $sale['start'];
                    $end = (isset($list_s[$i+1])?intval($list_s[$i+1] - 1): 9999999999999);
                    
                    if( $start <= $data['qty'] and $data['qty'] <= $end){
                        $p_find = true;
                        $price = $list_p[$i] ;//* $data['qty'];
                    }
                    $i+=1;
                }
            }
            if($p_find == false and isset($temp['price']) and $temp['price'] != ''){
                $price = $temp['price'];
            }
        }       
        return number_format(intval($price));
    }
    ////////////////////////////////////////////////////////////////////////////////
    public static function PriceGet($id = null, $options = [] ){
        global $result;
        if($id == null){
            global $id;
        }
        ShopHelper::prepare($id);
        $stock = ShopHelper::getStock($id);
        $price = 0;

        if( (!isset($options['with_spprice'])) and  (($spr = ShopHelper::CheckSpPrice()) != false) ){
            $price = $spr;
        }
        elseif(isset($result['shop_metas']['product_type'])){
            $meta = $result['shop_metas'];

            if(isset($meta['price']) and $meta['price'] == 0):
                return '<div class="price_zero">'.ShopHelper::Setting('text_price_zero').'</div>';
            endif;

            switch ($meta['product_type']) {
                case 'simple':
                    if(isset($options['attrs'])){
                        $price = TableRegistry::get('Shop.ShopProductdetails')
                            ->find('list',['keyField'=>'price','valueField'=>'price'])
                            ->where(['post_id'=> $id , 'pattern'=> $options['attrs']])
                            ->first();
                    }
                    elseif(isset($meta['price']) and $meta['price'] != '')
                        $price = $meta['price'];
                    else{
                        $temp = TableRegistry::get('Shop.ShopProductdetails')
                            ->find('list',['keyField'=>'price','valueField'=>'price'])
                            ->where(['post_id'=> $id])
                            ->toarray();
                        if($temp){
                            if(count($temp) == 0)
                                $price = 0;
                            elseif(count($temp) == 1)
                                $price = $temp[0];
                            else{
                                $p = [];
                                intval(min($temp))!=0?$p[] = number_format(intval(min($temp))) : null;
                                intval(max($temp))!=0?$p[] = number_format(intval(max($temp))) : null;
                                switch (count($p)) {
                                    case 0: $price = 0; break;
                                    case 1: $price = $p[0]; break;
                                    default:
                                        $price = number_format(intval(min($temp)));
                                        
                                        /* if($is_status == 'home') //if is home
                                        else
                                            $price = number_format(intval(min($temp))).' - '.number_format(intval(max($temp)));
                                        break; */
                                }
                            }
                        }
                    }
                    break;
                //---------------------------------------------------------------------------------
                case 'wholesale':
                    
                    $temp = TableRegistry::get('Shop.ShopProductdetails')
                            ->find('list',['keyField'=>'pattern','valueField'=>'price'])
                            ->where(['post_id'=> $id])
                            ->toarray();

                    $temp = TableRegistry::get('Shop.ShopProductdetails')
                            ->find('list',['keyField'=>'price','valueField'=>'price'])
                            ->where(['post_id'=> $id])
                            ->toarray();
                       
                    if(isset($options['attrs'])){
                        $price = TableRegistry::get('Shop.ShopProductdetails')
                            ->find('list',['keyField'=>'price','valueField'=>'price'])
                            ->where(['post_id'=> $id , 'pattern'=> $options['attrs']])
                            ->first();
                    }
                    elseif(isset($meta['price']) and $meta['price'] != ''){
                        $price = $meta['price'];
                    }
                    else{
                        if($temp){
                            if(count($temp) == 0)
                                $price = 0;
                            elseif(count($temp) == 1)
                                $price = $temp[0];
                            else{
                                $p = [];
                                intval(min($temp))!=0?$p[] = number_format(intval(min($temp))) : null;
                                intval(max($temp))!=0?$p[] = number_format(intval(max($temp))) : null;
                                switch (count($p)) {
                                    case 0:
                                        $price = 0;
                                        break;
                                    case 1:
                                        $price = $p[0];
                                        break;
                                    default:
                                        $price = number_format(intval(min($temp)));
                                        /* if($is_status == 'home') //if is home
                                        else
                                            $price = number_format(intval(min($temp))).' - '.number_format(intval(max($temp))); */
                                        break;
                                }
                            }
                        }
                    }

                    $price = preg_replace('/[^0-9]/', '',$price);
                    if(isset($options['qty'])){ 
                        if( isset($meta['product_type']) and  $meta['product_type'] == 'wholesale'){

                            $p_find = false;
                            $list_p = [];
                            $list_s = [];
                            foreach($meta['wholesale'] as $sale){
                                if( $sale['pattern'] == $options['attrs'] ){
                                    $list_p[] = $sale['price'];
                                    $list_s[] = $sale['start'];
                                }
                            }
                
                            $i=0;
                            foreach($meta['wholesale'] as $sale){
                                if( $sale['pattern'] == $options['attrs'] ){
                
                                    $start = $sale['start'];
                                    $end = (isset($list_s[$i+1])?intval($list_s[$i+1] - 1): 9999999999999);
                                    
                                    if( $start <= $options['qty'] and $options['qty'] <= $end){
                                        $price = $list_p[$i];
                                    }
                                    $i+=1;
                                }
                            }

                            if($p_find == false and isset($temp['price']) and $temp['price'] != ''){
                                $price = $temp['price'];
                            }
                        }
                    }
                    elseif(isset($meta['wholesale']) and is_array($meta['wholesale'])){
                        $plist = [];
                        foreach($meta['wholesale'] as $temp){
                            if(isset($result['stock_first'])){
                                if(( is_null($temp['pattern']) ?0:$temp['pattern']) == $result['stock_first'])
                                    $plist[] = $temp['price'];
                            }
                            elseif($stock[( is_null($temp['pattern']) ?0:$temp['pattern'])] != 0)
                                $plist[] = $temp['price'];
                        }

                        if($plist){
                            $price = number_format(intval(min($plist)));
                        }
                    }
                //---------------------------------------------------------------------------------
                default:
                    # code...
                    break;
            }
        }

        $no_stock = true;
        foreach($stock as $stk){
            if($stk != 0) $no_stock = false;
        }
            
        if($no_stock == true)
            return 'اتمام موجودی';

        return $price;
    }
    
    ////////////////////////////////////////////////////////////////////////////////
    public static function CheckSpPrice($id = null ){ 
        //Check Special Price Date
        global $result;
        if($id == null){
            global $id;
        }
        ShopHelper::prepare($id);

        if( isset($result['shop_metas']['special_price']) and 
            $result['shop_metas']['special_price'] != '' and 
            $result['shop_metas']['special_date_start']!='' and
            $result['shop_metas']['special_date_end'] != ''){
            $Func = new FuncHelper(new \Cake\View\View());
            
            /* $start = date('Y-m-d', strtotime( $result['shop_metas']['special_date_start'] ));
            $end = date('Y-m-d', strtotime( $result['shop_metas']['special_date_end'] )); */
            
            $now = date('Y-m-d', strtotime(date('Y-m-d')));
            $start = date('Y-m-d', strtotime($Func->shm_to_mil($result['shop_metas']['special_date_start'],'/')));
            $end = date('Y-m-d', strtotime($Func->shm_to_mil($result['shop_metas']['special_date_end'],'/')));
            if (($now >= $start) && ($now <= $end)){
                return $result['shop_metas']['special_price']; 
            }
        }
        return false;
    }
    ////////////////////////////////////////////////////////////////////////////////
    public static function WholesaleList($id = null ){
        
        global $result;
        if($id == null){
            global $id;
        }
        ShopHelper::prepare($id);

        $str = null;
        if( isset($result['shop_metas']['product_type']) and $result['shop_metas']['product_type'] == 'wholesale'){
            $str.= '<ul id="moqRanges" class="moqRangesborder">';
            switch (count($result['shop_metas']['wholesale'])) {
                case 0: $str.= 'بدون اطلاعات عمده فروشی';break;
                default:
                    /* if(! isset($result['stock'][0]) or $result['stock'][0] == 0)
                        break; */

                    if(ShopHelper::CheckSpPrice() != false)
                        break;

                    $predata = new Predata;
                    foreach($result['shop_metas']['wholesale'] as $item){
                        if(isset($result['stock_first'])){
                            if($result['stock_first'] == $item['pattern'] )
                                $items[] = $item;
                        }
                        else{
                            if($item['pattern'] == '')
                                $items[] = $item;
                        }
                    }

                    if(isset($items) and count($items)){
                        $i = 0;
                        foreach($items as $item){
                            $start = $item['start'];
                            $end = (isset($items[$i+1])?intval($items[$i+1]['start'] - 1): null);
                            $price = $item['price'];
                            $str.= '<li data-min="'.$start.'" data-max="'.$end .'" data-price="" class="zoFloatLeft moqRanges">
                                <span class="moqRangesspan">
                                '.($end==null ?'بیشتر  ':'' ).'
                                '.$start.'  
                                '.($end != ''? ' تا '. $end :'').'
                                </span>
                                <span style="padding-right:20px;padding-left:20px">'.$predata->getvalue('prd_unit',ShopHelper::Meta('unit')).'</span> 
                                <span class="moqRangeSpanPrice zoFloatLeft fw-b">'.($price != 0?number_format(intval($price)).ShopHelper::CurrencyShow() :'بدون' ).
                                //'<span class="moqRangeSpanPrice">'.($price != 0?ShopHelper::PriceShow($price) :'بدون' ).
                                '</span>
                            </li>';
                            $i+=1;
                        }
                    }
                break;
            }
            $str.= '</ul>';
        }
        return $str;
    }
    ////////////////////////////////////////////////////////////////////////////////
    public static function get_Wholesale($id = null , $attr = '' ){
        global $result;
        if($id == null){
            global $id;
        }
        ShopHelper::prepare($id);

        if(ShopHelper::CheckSpPrice() != false)
            return;
            
        $items = [];
        $predata = new Predata;
        if(isset($result['shop_metas']['wholesale'])){
            foreach($result['shop_metas']['wholesale'] as $item){
                if($item['pattern'] == $attr )
                    $items[] = $item;
            }
        }
        
        $i = 0;
        $str = null;
        foreach($items as $item){
            $start = $item['start'];
            $end = (isset($items[$i+1])?intval($items[$i+1]['start'] - 1): null);
            $price = $item['price'];
            $str .= '<li data-min="'.$start.'" data-max="'.$end .'" data-price="" class="zoFloatLeft moqRanges">
                <span class="moqRangesspan">
                '.($end==null ?'بیشتر  ':'' ).'
                '.$start.'  
                '.($end != ''? ' تا '. $end :'').'
                </span>
                <span style="padding-right:20px;padding-left:20px">'.$predata->getvalue('prd_unit',ShopHelper::Meta('unit')).'</span> 
                <span class="moqRangeSpanPrice zoFloatLeft fw-b">'.($price != 0?number_format(intval($price)).ShopHelper::CurrencyShow() :'بدون' ).
                '</span>
            </li>';
            $i+=1;
        }
        return $str;
    }
    ////////////////////////////////////////////////////////////////////////////////
    public static function CreateForm( $id = null,$options = [] ){
        if($id == null)
            global $id;
        global $result;
        
        ShopHelper::prepare($id);

        echo "\n
        <script nonce='".get_nonce."'>
        var vcount = 0;
        function shopqtyfnct() {
            var items = [];
            jQuery('.shopattr').each(function() {
                var currentElement = $(this);
                var value = currentElement.val();
                items.push(value);
            });
            get_stock(items.toString(),document.getElementById('shop-qty').value);
            if(fndata != 'no_stock'){
                get_price(items.toString(),document.getElementById('shop-qty').value);
                get_whole(items.toString());
                $('.total_price_box').addClass('d-none');
            }else{ }
            vcount = document.getElementById('shop-qty').value;
        }
        </script>";

        $Form = new FormHelper(new \Cake\View\View());
        $html = new HtmlHelper(new \Cake\View\View());
        echo $Form->create(null, ['url' => '/product/add','id'=>'shopforms' , 'onsubmit'=>'return fnacheck();']);
        echo $Form->control('id', ['type' => 'hidden', 'value' => $id ]);
        echo $Form->control('shop_qty', ['type' => 'hidden','label'=>false, 'value' => 1,'onchange'=>"return shopqtyfnct()" ]);

        $i=0;
        foreach(ShopHelper::CreateAttribute($id) as $tmp){
            switch ($tmp['type']) {
                case 1: //color ------------------------------------
                    echo $Form->control('attr'.$tmp['id'],[
                        'id'=>'shp_prdct_list',
                        'default'=> isset($result['stock_first'])?$result['stock_first']:false,
                        'type'=>'hidden', 'class'=>'shopattr']);
                       
                    $stock = ShopHelper::getStock($id);
                    echo '<ul class="shpprdct_colorlist">';
                    foreach($tmp['data2'] as $tk =>$tv){
                        if(isset($result['stock_first']) and $result['stock_first'] == $tk){
                            echo '<li style="background: rgb(0, 191, 214);"><span value="'.$tk.'" style="background:'.$tv['value'].'" 
                                data-toggle="tooltip" data-placement="bottom" title="'.$tv['title'].'"> </span></li>';
                        }
                        elseif(isset($stock[$tk]) and $stock[$tk] > 0){
                            echo '<li><span value="'.$tk.'" style="background:'.$tv['value'].'" 
                                data-toggle="tooltip" data-placement="bottom" title="'.$tv['title'].'"> </span></li>';
                        }
                        else{
                            echo '<li><span value="'.$tk.'" style="background:'.$tv['value'].'" 
                                data-toggle="tooltip" data-placement="bottom" title="'.$tv['title'].' [اتمام موجودی]" disabled=disabled> </span></li>';
                        }
                    }
                    echo '</ul>';
                    
                    echo "\n
                    <script nonce='".get_nonce."'>
                        $('.shpprdct_colorlist span').click(function(){
                            if ($(this).is('[disabled=disabled]') == false ) {
                                $('#shp_prdct_list').val($(this).attr('value'));
                                $('.shpprdct_colorlist li').css('background', 'none');
                                $(this).parent().css('background', '#00bfd6');
                                document.getElementById('shp_prdct_list').dispatchEvent(new Event('change',{}));
                            }
                        });
                    </script>
                    <style>
                    .shpprdct_colorlist li{list-style: none;display: inline-block;margin-left: 10px;border: 1px solid #eee;border-radius: 50%;padding: 2px;}
                    .shpprdct_colorlist li span{display: block;width: 25px;height: 25px;border-radius: 50%;cursor:pointer;border: 1px solid #FFF;}
                    </style>";
                    break;
                case 2: //img ------------------------------------
                    echo $Form->control('attr'.$tmp['id'],[
                        'id'=>'shp_prdct_list',
                        'default'=> isset($result['stock_first'])?$result['stock_first']:false,
                        'type'=>'hidden', 'class'=>'shopattr']);
                       
                    echo '<ul class="shpprdct_imglist">';
                    foreach($tmp['data2'] as $tk =>$tv){
                        echo '<li>'.$html->image($tv['value'],
                            ['value'=> $tk,'alt'=>$tk,
                            'data-toggle'=>"tooltip", "data-placement"=>"bottom",
                            'title'=> isset($tmp['data'][$tk])?$tmp['data'][$tk]:'-']).'</li>';
                    }
                    echo '</ul>';
                    
                    echo "\n
                    <script nonce='".get_nonce."'>
                        $('.shpprdct_imglist img').click(function(){
                            $('#shp_prdct_list').val(this.alt);
                            $('.shpprdct_imglist img').css('background', '#FFF');
                            $(this).css('background', '#00bfd6');
                            document.getElementById('shp_prdct_list').dispatchEvent(new Event('change',{}));
                        });
                    </script>
                    <style>
                    .shpprdct_imglist li{list-style: none;display: inline;margin-left: 10px;}
                    .shpprdct_imglist li img{width: 50px;height: 50px;padding: 4px;cursor:pointer;/*border-radius: 20px;border: 1px solid #eee;*/}
                    </style>
                    ";
                    break;
                default://default ------------------------------------
                    echo $Form->control('attr'.$tmp['id'],[
                        'label'=>$tmp['title'],
                        'empty'=>($i == 0?'-- ':null),
                        'type'=>'select','options'=> $tmp['data'] , 'class'=>'form-control mb-2 shopattr']);
                break;
            }
            $i+=1;
        }

        if(isset($options['addbtn_show']) and $options['addbtn_show'] == false){}
        else
            echo '<br>'.$Form->button(
                (ShopHelper::Setting('text_addtocart')!=''?ShopHelper::Setting('text_addtocart'):'Add To Cart'),
                ['class' => 'btn btn-success btn-sm', 'id' => 'addtocart']);
        echo $Form->end();

        echo "\n
        <script nonce='".get_nonce."'>
        function fnacheck(){
            if(document.getElementById('shop-qty').value == 0){
                alert('لطفا تعداد سفارش را مشخص نمایید');
                e.preventDefault();
                return false;
            }
        }
        $('.shopattr').on('change', function (e) { 
            var items = [];
            jQuery('.shopattr').each(function() {
                var currentElement = $(this);
                var value = currentElement.val();
                items.push(value);
            });

            get_stock(items.toString(),document.getElementById('shop-qty').value);
            if(fndata != 'no_stock'){
                get_price(items.toString(),document.getElementById('shop-qty').value);
                get_whole(items.toString());
                $('.total_price_box').addClass('d-none');
            }else{ }
        });
        
        function get_whole(lists){
            fndata = '';
            $.ajax({ type : 'POST',async: false,data: 'type=wholelist&id=".$id."&attrs='+lists ,
                url : '". Router::url(['controller' => 'Content', 'action' => 'Getdata'],false)."',
                success : function(data){ $('#moqRanges').html(data); },
                error:function (XMLHttpRequest, textStatus, errorThrown) { console.log('cannot fetch data2')}
            });
        }
        function get_price(lists,qty){
            if(qty == 0) qty = 1;
            $.ajax({ type : 'POST',async: false,data: 'id=".$id."&attrs='+lists+'&qty='+qty ,
                url : '". Router::url(['controller' => 'Content', 'action' => 'Getdata'],false)."',
                success : function(data){ $('#price".$id."').text(data );},
                error:function (XMLHttpRequest, textStatus, errorThrown) { console.log('cannot fetch data')}
            });
            //+' ".ShopHelper::CurrencyShow()."'
        }
        
        var fndata = '';
        var data = '';
        function get_stock(lists,qty){
            fndata = '';
            $.ajax({ type : 'POST',async: false,data: 'type=stock&id=".$id."&attrs='+lists+'&qty='+qty ,
                url : '". Router::url(['controller' => 'Content', 'action' => 'Getdata'],false)."',
                success : function(data){
                    if(data == 'no_stock'){
                        alert('تعداد کالای درخواستی شما بیشتر از موجودی انبار است ، لطفا رنگ یا سایز دیگری را انتخاب کنید');
                        document.getElementById('shop-qty').value = vcount;
                        $('.qty').val(vcount);
                        $('.qty').attr('min', '0');
                    }else{ $('#shop-stock').html(data); }
                    fndata = data;
                },
                error:function (XMLHttpRequest, textStatus, errorThrown) { console.log('cannot fetch data')}
            });
        }
        </script>";
    }
    ////////////////////////////////////////////////////////////////////////////////
    public static function PriceShow($price = null , $id = null ){

        if($id == null)
            global $id;

        if($price == null)
            return '<span id="price'.$id.'"></span>';

        if($price == 'اتمام موجودی')
            return 'اتمام موجودی';

        if(substr($price, 0, 24 ) === '<div class="price_zero">' )
            return $price;

        elseif(is_numeric($price))
            return '<span id="price'.$id.'">'.number_format(intval($price)).'</span> '. 
                (!is_array(ShopHelper::CurrencyShow())?ShopHelper::CurrencyShow():'-');
        else
            return '<span id="price'.$id.'">'.$price.'</span> '.
                (!is_array(ShopHelper::CurrencyShow())?ShopHelper::CurrencyShow():'-');
    }
    ////////////////////////////////////////////////////////////////////////////////
    public static function RelatedShow($id = null ){
        global $result;
        if($id == null){
            global $id;
        }
        ShopHelper::prepare($id);
        $post = [];
        if(isset($result['shop_metas']['related'])){
            $ids = explode(';',$result['shop_metas']['related']);
            $query = new QueryHelper(new \Cake\View\View());
            $post = $query->post('product',['id'=> $ids]);
        }
        return $post;
    }
    ////////////////////////////////////////////////////////////////////////////////
    public static function SuggestShow($id = null ){
        global $result;
        if($id == null){
            global $id;
        }
        ShopHelper::prepare($id);
        $post = [];
        if(isset($result['shop_metas']['suggested'])){
            $ids = explode(';',$result['shop_metas']['suggested']);
            $query = new QueryHelper(new \Cake\View\View());
            $post = $query->post('product',['id'=> $ids]);
        }
        return $post;
    }    
    ////////////////////////////////////////////////////////////////////////////////
    public static function CurrencyShow(){
        try {
            if(defined('shop_currency'))
                return shop_currency;
            else{
                define("shop_currency", CartHelper::Predata('currency',ShopHelper::Setting('currency') ));
                define("shop_currency_name", ShopHelper::Setting('currency') );
                return shop_currency;
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
        
    }
    ////////////////////////////////////////////////////////////////////////////////
    public static function CreateAttribute($id = null ){
        if($id == null)
            global $id;

        global $result;
        $attrib = [];
        if(isset($result['shop_metas']['attribute'])){
            $attr = explode(';', $result['shop_metas']['attribute']);
            $items = TableRegistry::get('Shop.ShopAttributes')->find('all')
                ->where(['id IN '=> $attr])
                ->contain(['shopAttributelists'])
                ->toarray();
            
            $patterns = TableRegistry::get('Shop.ShopProductdetails')
                ->find('list',['keyField'=>'pattern','valueField'=>'pattern'])
                ->where(['post_id'=>$id ,'pattern IS NOT NULL'])
                ->toarray();  
            $plist = [];
            foreach($patterns as $pattern){
                $tmp = explode(',', $pattern);
                if(count($tmp)){
                    foreach($tmp as $tm)
                        $plist[$tm] = $tm;
                }
            }

            foreach($items as $item){
                $list = [];
                $list2 = [];
                if(isset($item['shop_attributelists']) and count($item['shop_attributelists'])){
                    foreach($item['shop_attributelists'] as $itm){
                        if(isset($plist[$itm['id']])){
                            $list[$itm['id']] = $itm['title'];
                            $list2[$itm['id']] = [
                                'title' => $itm['title'] , 
                                'value' => $itm['value']
                            ];
                        }
                    }
                }
                $attrib[]= [
                    'id' => $item['id'],
                    'title' => $item['title'],
                    'type' => $item['types'],
                    'value' => isset($item['shop_attributelists'][0]['value'])?$item['shop_attributelists'][0]['value']:'',
                    'data' => $list,
                    'data2' => $list2,
                ];
            }
        }
        return $attrib;
    }
    ////////////////////////////////////////////////////////////////////////////////
    public static function Meta($key = null , $id = null ){
        global $result;
        if(isset($result['id']))
            $id = $result['id'];

        if($id == null)
            global $id;

        ShopHelper::prepare($id);
        if(isset($result['shop_metas'][$key]))
            $key = $result['shop_metas'][$key];
        else
            $key = false;
        return $key;
    }
    ////////////////////////////////////////////////////////////////////////////////
    public static function addto_favorite($id = null,$options = [] ){
        if($id == null)
            global $id;

        return Router::url('/shop/profile/favorites/?add='.$id ,false);
    }
    ////////////////////////////////////////////////////////////////////////////////
    public static function get_favorite($id = null,$options = [] ){
        if($id == null)
            global $id;

        return TableRegistry::get('Shop.ShopFavorites')->find('all')
            ->where(['post_id'=> $id , 'user_id'=> Router::getRequest()->getSession()->read('Auth.User.id')])
            ->count();
    }
    ////////////////////////////////////////////////////////////////////////////////
    public static function Label($id = null, $options = [] ){
        global $result;
        if($id == null)
            global $id;
        ShopHelper::prepare($id);
        $data = null;
        if(isset($result['shop_metas']['label']) and $result['shop_metas']['label'] != ''){
            $lid = $result['shop_metas']['label'];
            $temp = TableRegistry::get('Shop.ShopLabels')->find('all')
                ->where(['id' => $lid])
                ->first();
            if($temp and isset($options['show'])){
                switch ($options['show']) {
                    case 'title':$data = $temp['title'];break;
                    case 'link':$data = Router::url('/product/label/'. $temp['title']);break;
                    default:break;
                }
            }
        }
        return $data;
    }
    ////////////////////////////////////////////////////////////////////////////////
}