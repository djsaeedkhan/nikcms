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

class CartHelper extends Helper
{
    public $helpers = ['Html','Form','Session'];
    protected $_defaultConfig = [];
    ////////////////////////////////////////////////////////////////////////////////
    public static function getcart(){
        return Router::getRequest()->getSession()->read('Shop');
    }
    ////////////////////////////////////////////////////////////////////////////////
    public static function cart() {
        $shop = CartHelper::getcart();
        $quantity = 0;
        $subtotal = 0;
        $total = 0;
        $order_item_count = 0;
        // $order = $shop['Order'];
        if (count($shop['Orderproducts']) > 0) {
            foreach ($shop['Orderproducts'] as $item) {
                $quantity += $item['quantity'];
                $subtotal += $item['subtotal'];
                $total += $item['subtotal'];
                $order_item_count++;
            }
            $order['order_item_count'] = $order_item_count;
            $order['quantity'] = $quantity;
            $order['subtotal'] = sprintf('%01.2f', $subtotal);
            $order['total'] = sprintf('%01.2f', $total);
            Router::getRequest()->getSession()->write('Shop.Order', $order);
            //return true;
        }
        else {
            CartHelper::clear();
            //return false;
        }
    }
    ////////////////////////////////////////////////////////////////////////////////
    public static function add($id, $quantity = 0, $attrs = [] )
    {
        $Func = new FuncHelper(new \Cake\View\View());
        $Query = new QueryHelper(new \Cake\View\View());

        if($quantity == 0)
            return ;

        if(!is_numeric($quantity) || $quantity < 1) {
            $quantity = 1;
        }

        $attrlist = [];
        if(count($attrs)){
            foreach( $attrs as $k => $attr){
                $attrlist [ 
                    $this->getTableLocator()->get('Shop.ShopAttributes')->find('list',['keyField'=>'title','valueField'=>'title'])
                        ->where(['id'=> $k])->first()
                    ] =
                    $this->getTableLocator()->get('Shop.ShopAttributelists')->find('list',['keyField'=>'title','valueField'=>'title'])
                        ->where(['id'=> $attr])->first();
            }
        }
        $quantity = abs($quantity);
        $product = $this->getTableLocator()->get('Admin.Posts')->get($id , ['contain' => ['PostMetas']]);
        $stock = ShopHelper::getStock($product->id , implode(',',$attrs));

        if($stock < $quantity)
            $quantity = $stock > 1 ? 1 : 0;

        if(ShopHelper::Meta('maximum_order') != null and $quantity > ShopHelper::Meta('maximum_order')){
            if($stock > ShopHelper::Meta('maximum_order'))
                $quantity = ShopHelper::Meta('maximum_order');
        }
        if(ShopHelper::Meta('minimum_order') != null and $quantity < ShopHelper::Meta('minimum_order')){
            if($stock > ShopHelper::Meta('minimum_order'))
                $quantity = ShopHelper::Meta('minimum_order');
        }
        if(ShopHelper::Meta('sold_individually') == 1 and $quantity > 1)
            $quantity = 1;

        $price = 0;
        $price = ShopHelper::PriceCalc([
            'id'=> $id,
            'qty'=> $quantity,
            'attrs'=>implode(',',$attrs)]);
        $price = preg_replace('/[^0-9]/', '',$price);
            
        $image = null;
        if($img = $Query->postimage('thumbnail',$product)){
            $image = $img;
        }

        if( $quantity == 0){
            //CartHelper::cart();
            return 'به دلیل عدم موجودی، محصول به سبد خرید اضافه نشد';
        }

        $data = [
            'product_id' => $product->id,
            'name' => $product->title,
            'slug' => $product->slug,
            'image' => $image,
            'price' => sprintf('%01.2f', $price),
            'quantity' => $quantity,
            'descr' => '',
            'subtotal' => sprintf('%01.2f',$price * $quantity),
            'attr'=> $attrs,
            'attrlist'=> $attrlist,
        ];
        Router::getRequest()->getSession()->write('Shop.Orderproducts.' . $id . '_' . implode('_',$attrs), $data);

        CartHelper::cart();
        return 'محصول با موفقیت به سبد خرید شما اضافه گردید';
    }
    ////////////////////////////////////////////////////////////////////////////////
    public static function update($id, $quantity = 1){
        $id = str_replace('qty','',$id);
        if(!is_numeric($quantity) || $quantity < 1) {
            $quantity = 1;
        }

        $data = Router::getRequest()->getSession()->read('Shop.Orderproducts.' .$id);

        $stock = ShopHelper::getStock($data['product_id'] , implode(',',$data['attr']));

        if($stock < $quantity){
            return;
            //$quantity = $stock > 1 ? 1 : 0;
        }
            

        if(ShopHelper::Meta('maximum_order') != null and $quantity > ShopHelper::Meta('maximum_order')){
            if($stock > ShopHelper::Meta('maximum_order'))
                $quantity = ShopHelper::Meta('maximum_order');
        }
        if(ShopHelper::Meta('minimum_order') != null and $quantity < ShopHelper::Meta('minimum_order')){
            if($stock > ShopHelper::Meta('minimum_order'))
                $quantity = ShopHelper::Meta('minimum_order');
        }
        if(ShopHelper::Meta('sold_individually') == 1 and $quantity > 1){
            //$quantity = 1;
            return;
        }
            

        $price = 0;
        $price = ShopHelper::PriceCalc([
            'id' => $data['product_id'],
            'qty' => $quantity,
            'attrs' => implode(',',$data['attr'])]);
            
        $data['price'] = preg_replace('/[^0-9]/', '',$price);
        $data['quantity'] = intval($quantity);
        $data['subtotal'] = sprintf('%01.2f',$data['price'] * $quantity);
        Router::getRequest()->getSession()->write('Shop.Orderproducts.' . $id, $data);

        CartHelper::cart();
        return 'سبدخرید با موفقیت بروز رسانی گردید';
    }
    ////////////////////////////////////////////////////////////////////////////////
    public static function remove($id) {
        if( Router::getRequest()->getSession()->read('Shop.Orderproducts.' . $id)) {
            $product =  Router::getRequest()->getSession()->read('Shop.Orderproducts.' . $id);
            Router::getRequest()->getSession()->delete('Shop.Orderproducts.' . $id);
            CartHelper::cart();
            return $product;
        }
        return false;
    }
    ////////////////////////////////////////////////////////////////////////////////
    public static function clear() {
        Router::getRequest()->getSession()->delete('Shop');
    }
    ////////////////////////////////////////////////////////////////////////////////
    public static function Cartcount(){
        if(Router::getRequest()->getSession()->read('Shop.Order.order_item_count'))
            return Router::getRequest()->getSession()->read('Shop.Order.order_item_count');
        else
            return 0;
    }
    ////////////////////////////////////////////////////////////////////////////////
    public static function Link($type = null){
        switch (strtolower($type)) {
            case 'cart':
                return Router::url('/product/cart',true); break;
            case 'profile':
                return Router::url('/shop/profile',true); break;
            case 'favorite':
                return Router::url('/shop/profile/favorite',true); break;    
            case 'compare':
                return Router::url('/shop/compare',true); break;
                
            default:
                # code...
                break;
        }
    }
    ////////////////////////////////////////////////////////////////////////////////
    public static function CreatePrice($price = null){
        global $result;
        if($result != ''){
            $Func = new FuncHelper(new \Cake\View\View());
            $metalist =  $Func->MetaList($result);
            $price = isset($metalist['product_price'])?$metalist['product_price']:0;
        }
        return number_format(intval($price));
    }
    ////////////////////////////////////////////////////////////////////////////////
    public static function Predata($input = null , $id = null){
        $temp = [];
        if($input == 'enable'){
            $temp = [
                1 => 'فعال',
                0 => 'غیرفعال',
            ];
        }
        if($input == 'order_refund'){
            $temp = [
                1 => 'مشکلات فنی / معیوب بودن کالا',
                2 => 'کالای استفاده شده',
                3 => 'کالای غیر اصل (تقلبی)',
                4 => 'آسیب فیزیکی کالا با بسته‌بندی سالم',
                5 => 'اتمام مدت گارانتی / اشکال در مدت گارانتی',
                6 => 'خراش قابل مشاهده',
                7 => 'کالای قاچاق',
                8 => 'عدم وجود فاکتور',
            ];
        }
        if($input == 'order_refundtype'){
            $temp = [
                1 => 'ثبت شده',
                2 => 'در حال بررسی',
                3 => 'درخواست مورد تایید ',
                4 => 'درخواست رد شده',
            ];
        }
        if($input == 'order_status'){
            $temp = [
                "pending" => 'در انتظار پرداخت',
                "paid" => 'پرداخت شده / منتظر بررسی',
                "processing" => 'در حال انجام',
                "on-hold" => 'در انتظار بررسی',
                "completed" => 'تکمیل شده',
                "cancelled" => 'لغو شده',
                "refunded" => 'مسترد شده',
                "failed" => 'ناموفق'
            ];
        }

        if($input == 'order_actions'){
            $temp = [
                'post_print'=>'پرینت  جمعی مرسوله ها',
                'status' =>'تغییر وضعیت سفارش ها',
                'delete'=>'حذف سفارش ها',
            ];
        }
        if($input == 'pay_status'){
            $temp = [
                1 => 'پرداخت شده',
                2 => 'منتظر پرداخت',
                3 => 'پرداخت نشده',
                4 => 'تکمیل شده',
                5 => 'لغو شده',
                6 => 'مسترد شده',
                7 => 'ناموفق'
            ];
        }

        if($input == 'currency_list'){
            $temp = [
                'IRR' =>'ریال',
                'IRT' =>'تومان',
                //'IRHR' => 'هزار ریال',
                //'IRHT' => 'هزار تومان',
                //'EUR'=>'یورو (€)',
                //'IQD' => 'دینار عراق (ع.د)',
                //'RUB' => 'روبل روسیه (₽)',
                //'USD' => 'دلار آمریکا ($)',
            ];
        }

        if($input == 'currency'){
            $temp = [
                'IRR' =>'ریال',
                //'IRHR' => 'هزار ریال',
                //'IRHT' => 'هزار تومان',
                'IRT' =>' تومان',
                'EUR'=>' €',
                'IQD' => ' دینار',
                'RUB' => ' ₽',
                'USD' => ' $',
            ];
        }

        if($input == 'order_savestatus'){
            $temp = [
                'order_save' =>'فقط ثبت سفارش',
                'order_cheque' => 'پرداخت هنگام دریافت',
                'order_cod' => 'پرداخت با چک',
                'order_payment' => 'ثبت سفارش  و پرداخت اینترنتی '
            ];
        }
        
        if($input == 'terminal_list'){
            $temp = [
                'mellat'=>'بانک ملت',
                'zarrinpal' => 'زرین پال',
                'parsian' => 'پارسیان',
                'fanava' => 'فن آوا',
            ];
        }

        if($id === null) 
            return $temp;
        elseif($id !== null and isset($temp[$id])) 
            return $temp[$id];
        else
            return '-';
    }
    ////////////////////////////////////////////////////////////////////////////////
    public static function OrderTotalPrice($token = null) {
        $price = 0;
        $result= $this->getTableLocator()->get('Shop.ShopOrders')->find('all')
            ->where([ 'OR'=>['ShopOrders.trackcode'=>$token , 'ShopOrders.id'=> $token] ])
            ->contain(['ShopOrderproducts','shopOrdershippings'])
            ->first();

        if(isset($result['shop_orderproducts'])){
            foreach($result['shop_orderproducts'] as $pr){
                $price += $pr['subtotal'];
            }
        }

        if(isset($result['shop_ordershippings'])){
            foreach($result['shop_ordershippings'] as $pr){
                $price += $pr['price'];
            }
        }

        return $price;
    }
    ////////////////////////////////////////////////////////////////////////////////
    public static function ShippingList($type = null,$options = null){
        $result = $this->getTableLocator()->get('Admin.Options')
            ->find('list',['keyField'=>'name','valueField'=>'value'])
            ->where(['name' => 'plugin_transport'])
            ->toArray();
    
        if(isset($result['plugin_transport']) and count($result)):
            $list = [];
            $unserialize = unserialize($result['plugin_transport']);
            switch ($type ) {
                case 'id':
                    foreach($unserialize as $lists ){
                        if($lists['title'] != '')
                            $list[$lists['slug']] = $lists;
                    }
                    if(isset($list[$options['id']]))
                        return $list[$options['id']];
                    else
                        return false;
                    break;

                case 'enabled':
                    foreach($unserialize as $lists ){
                        if($lists['title'] != '')
                            $list[$lists['slug']] = $lists;
                    }
                    return $list;
                    break;
                    
                case 'list':
                    foreach($unserialize as $lists )
                        $list[$lists['slug']] = $lists['title'];
                    return array_filter($list);
                    break;
                
                default:
                    return $unserialize;
                    break;
            }
        else: 
            return [];
        endif;
    }
    ////////////////////////////////////////////////////////////////////////////////
    public static function ProductShipping($options = []){
        $id = isset($options['id'])?$options['id']:null;
        $val = self::ShippingList('id',['id'=> $id ]);
        $price = $temp = null;
        if($val['enable'] == 1):
            switch ($val['type']) {
                case 'fixed':
                    $price = $val['fixed_price'];break;

                case 'percent':
                    $full_price = isset($options['full_price'])?$options['full_price']:null;
                    if($full_price != null){
                        $price = ($full_price * $val['percent_price']) / 100;
                    }
                    else $price = 0;
                    break;

                case 'province':
                    if(isset($options['province_end'])){
                        $en = true;
                        for($j=1;$j<6;$j++):
                            $p_j = 'province_exc'.$j.'province';
                            $c_j = 'province_exc'.$j.'city';
                            if(isset($val[$p_j]) and $val[$p_j] == $options['province_end'] and 
                                isset($val[$c_j]) and $val[$c_j] == $options['city_end']){
                                    $price = $val['province_exc'.$j.'price'];
                                    $en = false;
                                }
                        endfor;
                        if($en == true){
                            $start = self::postInsidePart_diff(ShopHelper::Setting('store_province'));
                            $end = self::postInsidePart_diff($options['province_end']);
                            if($start != 0){
                                $nei = self::postInsidePart($start);
                                if(intval($start) == intval($end)){
                                    $price = $val['province_inside']; //pr("Inside");
                                }elseif(in_array($end , $nei)){
                                    $price = $val['province_near']; //pr("Near");
                                }else{
                                    $price = $val['province_other']; //pr("Other");
                                }
                            }
                            else $price = 0;
                        }
                    }
                    else 
                        $price = 0; 
                    break;
                default:
                    $price = 0;break;
            }

            $temp = [
                'price' => ($price!= null)?$price : false,
                'title' =>$val['title'],
                'image' =>$val['image'],
                'slug' =>$val['slug'],
            ];
        endif;

        return $temp;
    }
    ////////////////////////////////////////////////////////////////////////////////
    public static function ProductScheduling($options = []){
        $result = $this->getTableLocator()->get('Admin.Options')
            ->find('list',['keyField'=>'name','valueField'=>'value'])
            ->where(['name' => 'plugin_schedule'])
            ->toArray();
        $day = 0;
        pr($result );
        $setting = [];
        if(isset($result['plugin_schedule']) and count($result)):
            $setting = unserialize($result['plugin_schedule']);
        endif;

        if(isset($setting['province'])){
            $setting = $setting['province'];
            $start = self::postInsidePart_diff(ShopHelper::Setting('store_province'));
            $end = self::postInsidePart_diff($options['province_end']);
            if($start != 0){
                $nei = self::postInsidePart($start);
                if(intval($start) == intval($end)){
                    $day = $setting['province_inside']; //pr("Inside");
                }elseif(in_array($end , $nei)){
                    $day = $setting['province_near']; //pr("Near");
                }else{
                    $day = $setting['province_other']; //pr("Other");
                }
            }
            else $day = 0;
        }
        return $day;
    }
    ////////////////////////////////////////////////////////////////////////////////
    public static function postInsidePart_diff($id = null){
        $list = [
            8 => 1, //'تهران'
            25=>2 ,  //'گیلان'
            1=>3 ,  //آذربایجان شرقی
            13=>4 ,  //خوزستان
            17=>5 ,  //فارس
            4=>6 ,  //اصفهان
            11=>7 ,  //خراسان رضوی
            18=>8 ,  //قزوین
            15=>9 ,  //سمنان
            19=>10 ,  //قم
            28=>11 ,  //مرکزی
            14=>12 ,  //زنجان
            27=>13 ,  //مازندران
            24=>14 ,  //گلستان
            3=>15 ,  //اردبیل
            2=>16 ,  //آذربایجان غربی
            30=>17 ,  //همدان
            20=>18 ,  //کردستان
            22=>19 ,  //کرمانشاه
            26=>20 ,  //لرستان
            7=>21 ,  //بوشهر
            21=>22 ,  //کرمان
            29=>23 ,  //هرمزگان
            9=>24 ,  //چهارمحال و بختیاری
            31=>25 ,  //یزد
            16=>26 ,  //سیستان و بلوچستان
            6=>27 ,  //ایلام
            23=>28 ,  //کهگلویه و بویراحمد
            12=>29 ,  //خراسان شمالی
            10=>30 ,  //خراسان جنوبی
            5=>31 ,  //البرز
        ];
        if(isset($list[$id])) 
            return $list[$id];
        else 
            return 0;
    }
    ////////////////////////////////////////////////////////////////////////////////
    public static function postInsidePart($sourcePartId = 1){
        $result = array();
        switch ($sourcePartId) {
            case 1:$result = array(13,31,11,10,9);break;
            case 2:$result = array(15,12,8,13);break;
            case 3:$result = array(15,12,16);break;
            case 4:$result = array(27,20,24,28,21);break;
            case 5:$result = array(21,28,6,25,22,23);break;
            case 6:$result = array(5,25,9,10,11,20,24,28);break;
            case 7:$result = array(29,9,30,25);break;
            case 8:$result = array(2,12,17,11,31,13);break;
            case 9:$result = array(6,25,7,29,14,13,1,10);break;
            case 10:$result = array(1,6,9,11);break;
            case 11:$result = array(6,10,1,31,8,17,20);break;
            case 12:$result = array(3,16,15,2,8,17,18);break;
            case 13:$result = array(14,2,1,31,8,9);break;
            case 14:$result = array(29,9,13);break;
            case 15:$result = array(3,2,12);break;
            case 16:$result = array(3,12,18);break;
            case 17:$result = array(18,19,12,8,11,20);break;
            case 18:$result = array(17,19,12,16);break;
            case 19:$result = array(18,17,20,27);break;
            case 20:$result = array(11,17,19,27,6,24,4);break;
            case 21:$result = array(23,5,28,4);break;
            case 22:$result = array(26,23,5,25,30);break;
            case 23:$result = array(26,22,5,21);break;
            case 24:$result = array(6,28,4,20);break;
            case 25:$result = array(30,6,5,22,9,7);break;
            case 26:$result = array(23,22,30);break;
            case 27:$result = array(4,20,19);break;
            case 28:$result = array(6,24,4,21,5);break;
            case 29:$result = array(14,9,7);break;
            case 30:$result = array(26,22,25,7);break;
            case 31:$result = array(13,8,1,11);break;
            default:$result = 0;break;
        }
        return $result;
    }
    ////////////////////////////////////////////////////////////////////////////////
    public static function ShippingScheduleCheck($time = null , $i = null, //$day_plus = 0, 
        $current_useraddress = null,$shipping = null){

        $setting_tra = $this->getTableLocator()->get('Admin.Options')
            ->find('list',['keyField'=>'name','valueField'=>'value'])
            ->where(['name' => 'plugin_transport'])
            ->toArray();
            $setting_tra = unserialize($setting_tra['plugin_transport']);
            $cr_setting_tra = [];
            foreach($setting_tra as $tra){
                if($tra['slug'] == $shipping['slug'])
                    $cr_setting_tra = $tra;
            }

        $setting_sch = $this->getTableLocator()->get('Admin.Options')
            ->find('list',['keyField'=>'name','valueField'=>'value'])
            ->where(['name' => 'plugin_schedule'])
            ->toArray();
        $holiday = [];
        if(isset($setting_sch['plugin_schedule'])){
            $setting_sch = unserialize($setting_sch['plugin_schedule']);
            foreach($setting_sch['holiday'] as $tmp){if($tmp['title'] != ''){
                $holiday[$tmp['date']] = $tmp['title'];
            }}
        }
        else
            $setting_sch = [];
        
        $label = '';
        $enable = true;
        $date = $time->format('Y-m-d');
        $day_number = intval(jdate('w',strtotime($date),'','','en'));
        $day_pass = intval(jdate('z',strtotime($date),'','','en'));

        $day_plus = null;
        if($day_plus == null and $cr_setting_tra['day'] != ''){
            $day_plus = $cr_setting_tra['day'];
        }
        for($j=1;$j<10;$j++):
            if(isset($cr_setting_tra['province_exc'.$j.'province']) and $cr_setting_tra['province_exc'.$j.'province'] != '' and 
                $cr_setting_tra['province_exc'.$j.'province'] == $current_useraddress['billing_state'] and 
                $cr_setting_tra['province_exc'.$j.'city'] == $current_useraddress['billing_city']){
                    if($cr_setting_tra['province_exc'.$j.'day'] != "" )
                        $day_plus = $cr_setting_tra['province_exc'.$j.'day'];
            }
        endfor;

        if( (($i-1) - $day_plus) < 0){ //بر حسب مکان کاربر
            //because $i start from 1 , used ($i-1) to start from zero
            $enable = false; echo "<!-- 0 -->";//pr("0");
        }

        if($day_number == 6){ //جمعه نباشد
            $enable = false; echo "<!-- 1 -->";//pr("1");
        }
        
        if($enable == true){ // حداکثر تعداد سفارش روزانه

            $total_plus = null;
            if($total_plus == null and $cr_setting_tra['count'] != ''){
                $total_plus = $cr_setting_tra['count'];
            }
            for($j=1;$j<10;$j++):
                if(isset($cr_setting_tra['province_exc'.$j.'province']) and $cr_setting_tra['province_exc'.$j.'province'] != '' and 
                    $cr_setting_tra['province_exc'.$j.'province'] == $current_useraddress['billing_state'] and 
                    $cr_setting_tra['province_exc'.$j.'city'] == $current_useraddress['billing_city']){
                        if($cr_setting_tra['province_exc'.$j.'count'] > 0 )
                            $total_plus = $cr_setting_tra['province_exc'.$j.'count'];
                }
            endfor;
            $p = $this->getTableLocator()->get('Shop.shopOrdershippings')->find('all')
                ->where(['sendtime'=> $date])->count();
            if(isset($total_plus) and $p >= intval($total_plus)){
                $enable = false;
                echo "<!-- 2 -->";//pr("2");
            }
        }

        if($enable == true and isset($setting_sch['work'])){ // پایان ساعت کاری نرسیده باشد
            if( (strtotime($time->now()->format('H:m')) > strtotime(date('H:m',strtotime($setting_sch['work'][$day_number]['end'])))) and ($i == 1)){
                echo "<!-- 3 -->";//pr("3");
                $enable = false; 
            } 
        }

        if($enable == true){ // روز تعطیلی رسمی نباشد
            if(isset($holiday[$day_pass])){
                echo "<!-- 4 -->";//pr("4");
                $enable = false; 
                $label = $holiday[$day_pass];
            }
        }

        return [
            'label'=>$label ,
            'enable' => $enable
        ];
    }
    ////////////////////////////////////////////////////////////////////////////////
}