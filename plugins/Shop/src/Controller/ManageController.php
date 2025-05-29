<?php
namespace Shop\Controller;

use Shop\Controller\AppController;
use Cake\Controller\Controller;
use Cake\Event\EventInterface;
use Cake\Core\Plugin;
use Cake\ORM\TableRegistry;
use Cake\Http\Exception\NotFoundException;
use Cake\I18n\Time;
use Cake\Routing\Router;
use Exception;
use \Shop\Export;
use \Shop\SSpost;
use Shop\View\Helper\CartHelper;
use Shop\View\Helper\ShopHelper;
use Sms\Sms;
use SoapClient;
use Throwable;

class ManageController extends AppController
{
    public $template;
    //-------------------------------------------------------------------------------
    public function initialize(): void
    {
        parent::initialize();
        $this->viewBuilder()->setLayout('Shop.default');
        $this->ShopAddresses = $this->getTableLocator()->get('Shop.ShopAddresses');
        $this->ShopOrders = $this->getTableLocator()->get('Shop.ShopOrders');
        $this->Orderattr = $this->getTableLocator()->get('Shop.ShopOrderattributes');
        $this->Labels = $this->getTableLocator()->get('Shop.ShopLabels');
        $this->ShopOrderproducts = $this->getTableLocator()->get('Shop.ShopOrderproducts');
        $this->ShopProfiles = $this->getTableLocator()->get('Shop.ShopProfiles');
    }
    //-------------------------------------------------------------------------------
    public function beforeFilter(EventInterface $event)
    {
        //$this->Auth->allow();
        $this->Authentication->addUnauthenticatedActions();
    }
    //-------------------------------------------------------------------------------
    public function cart(){
        if($this->request->getParam('product_action')){
            switch ($this->request->getParam('product_action')) {
                case 'remove':
                    $shop = CartHelper::remove($this->request->getParam('product_id'));
                    $this->Flash->success( "حذف با موفقیت انجام گردید" );
                    return $this->redirect($this->referer());
                break;

                case 'clear':
                    $shop = CartHelper::clear();
                    $this->Flash->success( "پاک کردن سبد خرید با موفقیت انجام گردید");
                    return $this->redirect($this->referer());
                break;

                case 'cartupdate':
                    if ($this->request->is('post')) {
                        foreach($this->request->getData() as $key => $value) {
                            CartHelper::update($key, $value);
                        }
                        CartHelper::cart();
                        $this->Flash->success( "بروزرسانی سبد خرید با موفقیت انجام گردید");
                        return $this->redirect($this->referer());
                    }
                break;
                default:
                    # code...
                    break;
            }
        }

        $shopAddress = $this->ShopAddresses->newEmptyEntity();
        $shop = CartHelper::getcart();

        if ($this->request->is('post')) {
            $save = true;
            
            if(! isset($this->request->getData()['shop_useraddress_id'])){
                $save = false;
                $this->Flash->error('لطفا آدرس تحویل مرسوله را مشخص کنید');
            }
            
            if(! isset($this->request->getData()['shipping']['types'])){
                $save = false;
                $this->Flash->error('لطفا روش ارسال مرسوله را مشخص کنید');
            }
            
            if($save == true){
                $this->request->getSession()->write('SaveOrder',$this->request->getData());
                return $this->redirect('/product/factor/');
            }
        }


        $this->set([
        'user_address' => $this->getTableLocator()->get('Shop.ShopUseraddresses')
            //->find('list',['keyField'=>'id','valueField'=>'billing_address'])
            ->find('all')
            ->where(['user_id'=> $this->request->getAttribute('identity')->get('id')])
            ->toarray(),

        'shop_profile' => $this->getTableLocator()->get('Shop.ShopProfiles')
            ->find('all')
            ->where(['user_id'=> $this->request->getAttribute('identity')->get('id')])
            ->first(),
        ]);
        
        $this->set(compact('shop','shopAddress'));
    }
    //-------------------------------------------------------------------------------
    public function factor(){ //item
        $SaveOrder = $this->request->getSession()->read('SaveOrder');
        if( ! $SaveOrder){
            return $this->redirect('/product/cart/');
        }
        if($this->setting['enable_guest_checkout'] == 0){
            if (!$this->Auth->user()){
                $this->Flash->error(__('برای ثبت سفارش می بایست در سایت وارد شوید'));
                return $this->render('login');
            }
        }

        $profile = $this->ShopProfiles->find('all')->where(['user_id'=>$this->request->getAttribute('identity')->get('id')])->toarray();
        if(count($profile) == 0){
            $this->Flash->error(__('لطفا مشخصات پایه اکانت خودتان را تکمیل نمایید.'));
            return $this->redirect('/shop/profile/my?redirect=factor');
        }
        $profile = isset($profile[0])?$profile[0]:[];

        $items = CartHelper::getcart();
        $card_price = 0;
        if(isset($items['Orderproducts'])):
            foreach( $items['Orderproducts'] as $item)
            {
                $card_price += $item['price'];
            }
        endif;
        $this->set(['card_price'=>$card_price]);

        $shop = CartHelper::getcart();
        if(!CartHelper::getcart()){
            $this->redirect('/product/cart/');
        }
        $this->set(compact('shop'));
        
        $shipping = array_values(array_filter($SaveOrder['shipping']['types']));
        $user_address = array_values(array_filter($SaveOrder['shop_useraddress_id']));
        if(isset($user_address[0] )){
            $user_address =$this->getTableLocator()->get('Shop.ShopUseraddresses')
                ->find('all')
                ->where(['user_id'=> $this->request->getAttribute('identity')->get('id') , 'id'=> $user_address[0] ])
                ->first();
        }
        else 
            $user_address = false;
        
        $ship = null;
        $ship_price = 0;
        if($user_address){
            $ship = CartHelper::ProductShipping([
                'full_price' => $card_price,
                'id'=> $shipping[0] ,
                'province_end'=>$user_address['billing_state'],
                'city_end'=>$user_address['billing_city'] ]);
            if(isset($ship['price'])){
                $ship_price = $ship['price'];
            }
        }

        /* $day_plus = 0;
        if($user_address){
            $day_plus = CartHelper::ProductScheduling([
                'full_price' => $card_price,
                'id'=> $shipping[0] ,
                'province_end'=>$user_address['billing_state'],
                'city_end'=>$user_address['billing_city'] ]);
        } */

        $this->set([
            'shipping' => $ship,
            //'day_plus' => $day_plus,
            'current_useraddress' => $user_address,
        ]);

        $shopAddress = $this->ShopAddresses->newEmptyEntity();

        if ($this->request->is('post') and CartHelper::getcart() != '') {
            if(! isset($this->request->getData()['shipping']['sendtime'])){
                $save = false;
                $this->Flash->error('لطفا زمانبندی ارسال مرسوله را مشخص کنید');
            }

            $getData = $this->request->getSession()->read('SaveOrder');
            $save = false;

            //Check User Address
            $tmp = array_values( array_filter( $getData['shop_useraddress_id']) );
            $user_address = $this->getTableLocator()->get('Shop.ShopUseraddresses')
                ->find('all')
                ->where(['user_id' => $this->request->getAttribute('identity')->get('id') ,'id' => isset($tmp[0])?$tmp[0]:false])
                ->first();

            $shopAddress = $this->ShopAddresses->patchEntity($shopAddress,  $getData );
            $shopAddress->user_id = $this->request->getAttribute('identity')->get('id');
            $shopAddress->shop_useraddress_id = isset($user_address['id'])?$user_address['id']:0;
            if(isset($this->request->getData()['another'])){
                $another = $this->request->getData()['another'];
                $shopAddress->first_name = isset($another['name'])?$another['name']:0;
                $shopAddress->last_name = isset($another['family'])?$another['family']:0;
                $shopAddress->phone = isset($another['phone'])?$another['phone']:0;
                $shopAddress->emails = isset($another['email'])?$another['email']:0;
                $shopAddress->nationalid = isset($another['nationalid'])?$another['nationalid']:0;

            }else{
                $shopAddress->first_name = isset($profile['name'])?$profile['name']:0;
                $shopAddress->last_name = isset($profile['family'])?$profile['family']:0;
                $shopAddress->phone = isset($profile['phone'])?$profile['phone']:0;
                $shopAddress->emails = isset($profile['email'])?$profile['email']:0;
                $shopAddress->nationalid = isset($profile['nationalid'])?$profile['nationalid']:0;
            }
            
            $mobile_number = $shopAddress->phone;
            if ($this->ShopAddresses->save($shopAddress)){
                $save = true;
            }
            else{
                $this->Flash->error('اطلاعات آدرس شما ثبت نشده است.');
            }
            
            //$tracker = $this->get_tracker();
            $shopOrder = $this->ShopOrders->newEmptyEntity();
            $shopOrder = $this->ShopOrders->patchEntity($shopOrder, [
                'user_id'=>  $this->Auth->user()?$this->request->getAttribute('identity')->get('id'):null,
                'trackcode' => "0",
                'currency' => shop_currency_name,
                'enable'=> 1,
                'shop_address_id' => $shopAddress->id,
                'status'=> "pending" ]);
            if ($this->ShopOrders->save($shopOrder)) {
                $tracker = $shopOrder->id + 10000 ;

                TableRegistry::get("Shop.shopOrders")->query()->update()
                    ->set(['trackcode' => $tracker ])
                    ->where(['id' => $shopOrder->id ])
                    ->execute();
                    
                $list = [];
                $items = CartHelper::getcart();
                foreach( $items['Orderproducts'] as $item){
                    $shopOrderproduct = $this->ShopOrderproducts->newEmptyEntity();
                    $shopOrderproduct = $this->ShopOrderproducts->patchEntity($shopOrderproduct,[
                        'shop_order_id' => $shopOrder->id ,
                        'post_id' => $item['product_id']  ,
                        'name' => $item['name'],
                        'price' => $item['price'],
                        'quantity' => $item['quantity'],
                        'subtotal' => $item['subtotal'],
                        'attrs' => implode(',',$item['attr'])  ]);
                    if ($this->ShopOrderproducts->save($shopOrderproduct)) {
                        $attrs = [];
                        foreach($item['attr'] as $kttr => $attr){
                            $attrs[] = [
                                'shop_orderproduct_id' => $shopOrderproduct->id,
                                'shop_attribute_id' => $kttr ,
                                'shop_attributelist_id' => $attr  ];
                        }
                        $temp = $this->Orderattr->newEmptyEntity();
                        $temp = $this->Orderattr->patchEntities($temp,$attrs);
                        $this->Orderattr->saveMany($temp);
                    }
                }

                if( $getData['shipping'] != ''){
                    $types = null;
                    foreach( $getData['shipping']['types'] as $temp){
                        if($temp != null) $types = $temp;
                    }
                    $sendtime = null;
                    foreach( $this->request->getdata()['shipping']['sendtime'] as $temp){
                        if($temp != null) $sendtime = $temp;
                    }

                    $this->Shippings = $this->getTableLocator()->get('Shop.ShopOrdershippings');
                    $temp = $this->Shippings->newEmptyEntity();
                    $temp = $this->Shippings->patchEntity($temp,[
                        'shop_order_id'=> $shopOrder->id,
                        'user_id' => $this->Auth->user()?$this->request->getAttribute('identity')->get('id'):null,
                        'types'=> $types,
                        'price' => $ship_price,
                        'sendtime' => $sendtime ]);
                    if($this->Shippings->save($temp)){
                    }
                    else
                        $this->Flash->error('ثبت روش ارسال انجام نشده است.');
                }

                if( $this->request->getData()['billing_desc']){
                    $this->ShopOrdertexts = $this->getTableLocator()->get('Shop.ShopOrdertexts');
                    $ShopOrdertext = $this->ShopOrdertexts->newEmptyEntity();
                    $ShopOrdertext = $this->ShopOrdertexts->patchEntity($ShopOrdertext,[
                        'shop_order_id'=> $shopOrder->id,
                        'user_id'=> $this->Auth->user()?$this->request->getAttribute('identity')->get('id'):null,
                        'text' =>  $this->request->getData()['billing_desc'],
                        'private' => 0,
                    ]);
                    if($this->ShopOrdertexts->save($ShopOrdertext)){
                    }
                    else
                        $this->Flash->error('ثبت توضیحات سفارش انجام نشده است');
                }

                if ($save == true) {
                    $this->Flash->success("سفارش با موفقیت ثبت شد. 
                        لطفا جهت تکمیل سفارش خود نسبت به پرداخت آن اقدام فرمایید.<br>
                        کد پیگیری سفارش شما : ".$tracker."<br>
                        برای پیگیری سفارش خود میتوانید به بخش پروفایل » سفارش‌های من مراجعه نمایید."
                        );
                    CartHelper::clear();

                    if($this->Func->is_connected()){
                        $sms = new Sms();
                        if($this->setting['admin_sendesms'] and $this->setting['default_mobile']!=''){
                            $sms->sendsingle([
                                'mobile' => $this->setting['default_mobile'],
                                'text' => $sms->create_text(
                                    $this->setting['admin_sendesms_order_save'],[
                                        'token'=>$tracker,
                                        'username'=>$this->request->getAttribute('identity')->get('username'),
                                        'mobile'=>$mobile_number ])
                                 ]);
                        }
                    
                        if($this->setting['customer_sendesms']){
                            $sms->sendsingle([
                                'mobile' => $mobile_number,
                                'text' => $sms->create_text(
                                    $this->setting['customer_sendesms_order_save'],[
                                        'token'=>$tracker,
                                        'username'=>$this->request->getAttribute('identity')->get('username'),
                                        'mobile'=>$mobile_number ])
                                    ]);
                        }
                    }

                    if($this->setting['order_savestatus'] == 'order_payment'){
                        return $this->redirect('/product/payment/'.$tracker);
                    }
                    return $this->redirect('/product/cart/'.$tracker);
                }
                else
                    $this->Flash->error(__('متاسفانه ثبت مشخصات آدرس شما انجام نشد'));
            }
            else
                $this->Flash->error(__('متاسفانه ثبت سفارش با موفقیت انجام نشد.'));
        }

        $this->set([
            'user_address' => $this->getTableLocator()->get('Shop.ShopUseraddresses')
                //->find('list',['keyField'=>'id','valueField'=>'billing_address'])
                ->find('all')
                ->where(['user_id'=> $this->request->getAttribute('identity')->get('id')])
                ->toarray(),

            'shop_profile' => $this->getTableLocator()->get('Shop.ShopProfiles')
                ->find('all')
                ->where(['user_id'=> $this->request->getAttribute('identity')->get('id')])
                ->first(),
            ]);
        $this->set(compact('shopAddress'));
    }
    //-------------------------------------------------------------------------------
    public function payment($token = null, $action = null){
        
        if($this->request->getParam('orderid'))
            $token = $this->request->getParam('orderid');
  
        $result = $this->ShopOrders->find('all')
            ->where(['trackcode'=>$token ])
            ->contain([
                'ShopOrdershippings',
                'ShopOrdertexts',
                'ShopAddresses',
                'ShopPayments',
                'ShopOrderproducts'=>[
                    'ShopOrderlogestics',
                    'Posts'=>['ShopProductMetas'],
                    'ShopOrderattributes'=>['ShopAttributes','ShopAttributelists']
                ],
            ]);

        if($this->request->getAttribute('identity')->get('role_id') != 1){
            $result->where(['ShopOrders.user_id'=> $this->request->getAttribute('identity')->get('id')]);
        }
        $result = $result->first();

        $this->set(['results'=> $result ]);
        if(! $result){
            $this->Flash->error(__('چنین سفارشی پیدا نشد -1'));
            $this->redirect('/');
        }
        if ($this->request->is(['post','get']) and $action == 'delete') {
            TableRegistry::get("Shop.shopOrders")->query()->update()
                ->set(['status' => "cancelled"])
                ->where(['id' => $result['id']])
                ->execute();

            $this->Flash->error(__('سفارش شما با موفقیت لغو شد'));
            return $this->redirect($this->referer());
        }
        elseif ($this->request->is('post')) {
            
            if(isset($this->request->getData()['payment']['terminal'])){
                $terminal = array_values(array_filter($this->request->getData()['payment']['terminal']));
                $terminal = $terminal[0];
            }
            elseif(isset($this->request->getData()['OrderId'])){
                $terminal = $this->getTableLocator()->get('Shop.shopPayments')->find('all')
                    ->where(['myrahid'=> $this->request->getData()['OrderId'] ])
                    ->first();
                $terminal = $terminal['terminalid'];
            }
            elseif(isset($this->request->getData()['token'])){
                $terminal = $this->getTableLocator()->get('Shop.shopPayments')->find('all')
                    ->where(['au'=> $this->request->getData()['token'] ])
                    ->first();
                $terminal = $terminal['terminalid'];
            }
            
            switch($terminal){
                case 'zarrinpal':
                    $this->getPayment_z($token , $action, $result);
                    $this->setPayment_z($token);
                    break;

                case 'mellat':
                    //$this->getPayment_m($token , $action, $result);
                    //$this->setPayment_m($token);
                    break;
                
                case 'parsian':
                    $this->getPayment_p($token , $action, $result);
                    $this->setPayment_p($token);
                    break;

                case 'fanava':
                    $this->getPayment_fanava($token , $action, $result);
                    $this->setPayment_fanava($token);
                    break;
            }
        }
        if ($action =='pdf') {
            $this->autoRender = false;
            return $this->response->withStringBody($this->cell('Shop.Exportpdf',[$token]));
        }
    }
    //-------------------------------------------------------------------------------
    public function logestics($id = null){
        if($this->request->getParam('orderid'))
            $id = $this->request->getParam('orderid');
  
        $result = $this->ShopOrderproducts->find('all')
            ->where([
                'ShopOrderproducts.id'=> $id,
                'ShopOrders.user_id'=> $this->request->getAttribute('identity')->get('id') ])
            ->contain([
                'ShopOrders',
                'ShopOrderlogestics'=>['ShopLogestics'],
                'Posts'=>['ShopProductMetas'],])
            ->first();
            
        if( !$result ){
            $this->Flash->error(__('چنین سفارشی پیدا نشد'));
            return $this->redirect($this->referer());
        }

        if(!isset($result['shop_order']['status']) or  $result['shop_order']['status'] != "completed"){
            $this->Flash->error(__('دسترسی به این محصول پیدا نشد'));
            return $this->redirect($this->referer());
        }

        if(!isset($result['post']['shop_product_metas'])){
            $this->Flash->error(__('دسترسی به این محصول پیدا نشد'));
            return $this->redirect($this->referer());
        }

        $metalist = $this->Func->MetaList($result['post']);
        if(!isset($metalist['logesticlists']) or $metalist['logesticlists'] == ""){
            $this->Flash->error(__('برای این محصول نمایندگی تعریف نشده است'));
            return $this->redirect($this->referer());
        }

        $my_logestic = '';
        $logesticlist = TableRegistry::getTableLocator()->get("Shop.ShopLogestics")->find('all');
        if( isset($result['shop_orderlogestics'][0]) ){
            $logesticlist = $logesticlist->where([
                'id'=>$result['shop_orderlogestics'][0]['shop_logestic']['id'],
            ]);
            $my_logestic = "current";
        }
        else{
            $logesticlist = $logesticlist->where([
                'enable' => 1,
                'shop_logesticlist_id' => $metalist['logesticlists']
            ]); 
            $my_logestic = "all";
        }

        $logesticlist = $logesticlist->toarray();
        if(!is_array($logesticlist) or count($logesticlist) == 0){
            $this->Flash->error(__('برای این محصول نمایندگی تعریف نشده است'));
            return $this->redirect($this->referer());
        }
        
        if ($this->request->is('post')) {
            $this->ShopOrderlogestics = $this->getTableLocator()->get('Shop.ShopOrderlogestics');
            $orderlogestics = $this->ShopOrderlogestics->newEmptyEntity();
            $orderlogestics = $this->ShopOrderlogestics->patchEntity($orderlogestics, [
                'shop_order_id'=>$result['shop_order']['id'],
                'shop_orderproduct_id'=> $id,
                'shop_logestic_id'=> $this->request->getQuery('id'),
                'user_id'=>$this->request->getAttribute('identity')->get('id'),
                'enable'=> 0,
            ]);

            if ($this->ShopOrderlogestics->save($orderlogestics)) {
                $this->Flash->success(__('ثبت نمایندگی برای سفارش شما با موفقیت انجام گردید'));
            }
            else{
                if(isset($orderlogestics->getErrors()['shop_order_id']['_isUnique']))
                    $this->Flash->error($orderlogestics->getErrors()['shop_order_id']['_isUnique']);
                else
                    $this->Flash->error(__('متاسفانه ثبت نمایندگی انجام نشد'));
            }

            return $this->redirect($this->referer());
        }

        $this->set(compact('logesticlist','result','my_logestic'));
    }
    //-------------------------------------------------------------------------------
    //------------------------ ZARRINPAL --------------------------------------------
    //-------------------------------------------------------------------------------
    private function setPayment_z(){
        if(isset($_GET['Authority'])){
            $Authority = $_GET['Authority'];
            $order = $this->getTableLocator()->get('Shop.ShopPayments')->find('all')
                ->where(['myrahid' => $this->request->getQuery('order_id')])
                ->contain(['shopOrders','ShopAddresses'])
                ->first();

            if ( $order and $_GET['Status'] == 'OK') {
                $api = $this->setting['terminal_id'] ;
                $amount= CartHelper::OrderTotalPrice($order['ShopOrders']['trackcode']);

                $client = new SoapClient('https://www.zarinpal.com/pg/services/WebGate/wsdl', ['encoding' => 'UTF-8']);
                $result = $client->PaymentVerification([
                    'MerchantID' => $api,
                    'Authority' => $Authority,
                    'Amount' => $amount ]);

                if ($result->Status == 100) {
                    TableRegistry::get("Shop.shopPayments")->query()->update()
                        ->set(['status' => 1])
                        ->where(['shopPayments.id' => $order['id']])
                        ->execute();

                    TableRegistry::get("Shop.shopOrders")->query()->update()
                        ->set(['status' => "paid"])
                        ->where(['id' => $order['shop_order_id']])
                        ->execute();


                    // اینجا ،پس از پرداخت، تعداد سفارش کاربر از موجودی محصول کاسته می شود
                    $this->decrease_stock_after_payment( $order['id'] );
                }

                $sms = new Sms();
                $mobile_number = $this->request->getData()['mobile'];
                if($this->setting['admin_sendesms'] and $this->setting['default_mobile']!=''){
                    $sms->sendsingle([
                        'mobile' => $this->setting['default_mobile'],
                        //'text' => $this->setting['admin_sendesms_order_paid'] 
                        'text' => $sms->create_text(
                            $this->setting['admin_sendesms_order_paid'],[
                                'token'=> $order['ShopOrders']['trackcode'],
                                'username'=>$this->request->getAttribute('identity')->get('username'),
                                'mobile'=>$mobile_number ])
                    ]);
                }

                if($this->setting['customer_sendesms']){
                    $sms->sendsingle([
                        'mobile' => $this->request->getData()['mobile'],
                        //'text' => $this->setting['customer_sendesms_order_paid'],
                        'text' => $sms->create_text(
                            $this->setting['customer_sendesms_order_paid'],[
                                'token'=> $order['ShopOrders']['trackcode'],
                                'username'=>$this->request->getAttribute('identity')->get('username'),
                                'mobile'=>$mobile_number ])
                             ]);
                }

                $this->Flash->success(__('خوشبختانه پرداخت با موفقیت انجام شد'));
                return $this->redirect([$order['ShopOrders']['trackcode']]);
            }
            else{
                TableRegistry::get("Shop.shopPayments")->query()->update()
                    ->set(['status' => 3])
                    ->where(['shopPayments.id' => $order['id']])
                    ->execute();

                $this->Flash->error(__('متاسفانه پرداخت انجام نشد'));
                return $this->redirect([$order['ShopOrders']['trackcode']]);
            }
        }
    }
    private function getPayment_z($token = null, $action = null, $result = null){
        $api = $this->setting['terminal_id'];
        $amount = CartHelper::OrderTotalPrice($token) ; //Tooman
        $terminalid = array_values(array_filter($this->request->getData()['payment']['terminal']));
        if($action == 'goto'){
            $name = '';
            $email = '';
            $mobile = '';
            if(isset($result['shop_addresses'][0])){
                $addr = $result['shop_addresses'][0];
                $name = $addr['first_name'].' '. $addr['last_name'];
                $email = $addr['emails'];
                $mobile = $addr['mobile'];
            }
            $product = "سفارش: ".$token;
            $myrah_id = rand(1000,9999) * date('dhis');
            $PaymentUrl = Router::url('/product/payment/'.$token.'?order_id='.$myrah_id,true);
            $client = new SoapClient('https://www.zarinpal.com/pg/services/WebGate/wsdl', ['encoding' => 'UTF-8']);

            $res = $client->PaymentRequest([
                'MerchantID' => $api,
                'Amount' => $amount,
                'Description' => "نام: ".$name." / ایمیل: ".$email." / محصول: ".$product." / کدرهگیری:".$myrah_id,
                'Email' => $email,
                'Mobile' => $mobile,
                'CallbackURL' => $PaymentUrl,
            ]);

            if ($res->Status == 100) {
                $au = $res->Authority; // dar database save conid b hamrahe order_id , amount
                $model_payments = $this->getTableLocator()->get('Shop.shopPayments');
                $pay = $model_payments->newEmptyEntity();
                $pay = $model_payments->patchEntity($pay,[
                    'shop_order_id'=> $result['id'],
                    'user_id'=> $result['user_id'],
                    'terminalid'=> $this->setting['terminal_list'],
                    'price'=>$amount,
                    'status'=>'',
                    'myrahid' => $myrah_id,
                    'au' => $au,
                    'status' => 2,
                    'terminalid' => $terminalid[0]
                ]);
                if($model_payments->save($pay)){
                    Header('Location: https://www.zarinpal.com/pg/StartPay/'.$res->Authority);
                    echo '<script nonce="'.get_nonce.'">window.location.replace("https://www.zarinpal.com/pg/StartPay/'.$res->Authority.'");</script>';
                    echo 'درحال انتقال به درگاه پرداخت.<br>لطفا صبر کنید ...';
                }
                else
                    return $this->Flash->error(__('متاسفانه اتصال به بانک مقصد انجام نشد'));
            }
            else{
                echo '<meta charset=utf-8><pre>';
                $res = array_map('urldecode',$res);
                //print_r($res);
            }
        }
    }
    //-------------------------------------------------------------------------------
    //------------------------- Parsian ---------------------------------------------
    //-------------------------------------------------------------------------------
    private function setPayment_p($token = null){
        if(isset($this->request->getData()['Token']) ){
            $Authority = $this->request->getData()['Token'];
            $order = $this->getTableLocator()->get('Shop.ShopPayments')->find('all')
                ->where(['au' => $this->request->getData()['Token']])
                ->contain(['ShopOrders'])
                ->first();
            if(!$order){
                $this->Flash->error('چنین سفارشی پیدا نشد -2');
                return $this->redirect('/');
            }
            elseif($order['paid'] == 1){
                $this->Flash->error('سفارش قبلا تایید شده است.');
                return $this->redirect([$order['ShopOrders']['trackcode']]);
            }
            $order_id = $order['shop_order_id'];
            $PIN = 'wPsXLh0FH6C60u33703B';
            $wsdl_url = "https://pec.shaparak.ir/NewIPGServices/Confirm/ConfirmService.asmx?WSDL";
            
            $Token = $_REQUEST ["Token"];
            $status = abs($_REQUEST ["status"]);
            /* $OrderId = $_REQUEST ["OrderId"];
            $TerminalNo = $_REQUEST ["TerminalNo"];
            $Amount = $_REQUEST ["Amount"]; */
            $RRN = isset($_REQUEST ["RRN"])?$_REQUEST ["RRN"]:0;
            if ($RRN > 0 && $status == 0) { 
                $params = array ("LoginAccount" => $PIN,"Token" => $Token );
                $client = new SoapClient ( $wsdl_url );
                try {
                    $result = $client->ConfirmPayment ( array ("requestData" => $params ) );
                    if ($result->ConfirmPaymentResult->Status != '0') {
                        //echo "(<strong> کد خطا : " . $result->ConfirmPaymentResult->Status . "</strong>) " .
                        $result->ConfirmPaymentResult->Message ;
                        $this->Flash->error( $result->ConfirmPaymentResult->Message);

                        TableRegistry::get("Shop.shopPayments")->query()->update()
                            ->set(['paid' => 3, 'status' => $result->ConfirmPaymentResult->Status ])
                            ->where(['shopPayments.id' => $order['id']])
                            ->execute();  
                    }else{
                        TableRegistry::get("Shop.shopPayments")->query()->update()
                            ->set(['status' => 0 , 'paid' => 1 ])
                            ->where(['shopPayments.id' => $order['id']])
                            ->execute();

                        TableRegistry::get("Shop.shopOrders")->query()->update()
                            ->set(['status' => "paid"])
                            ->where(['id' => $order_id ])
                            ->execute();

                        // اینجا ،پس از پرداخت، تعداد سفارش کاربر از موجودی محصول کاسته می شود
                        $this->decrease_stock_after_payment($order_id);

                        $sms = new Sms();
                        $mobile_number = $this->request->getData()['mobile'];
                        if($this->setting['admin_sendesms'] and $this->setting['default_mobile']!=''){
                            $sms->sendsingle([
                                'mobile' => $this->setting['default_mobile'],
                                //'text' => $this->setting['admin_sendesms_order_paid'],
                                'text' => $sms->create_text(
                                    $this->setting['admin_sendesms_order_paid'],[
                                        'token'=> $order['ShopOrders']['trackcode'],
                                        'username'=>$this->request->getAttribute('identity')->get('username'),
                                        'mobile'=>$mobile_number ])
                                ]);
                        }

                        if($this->setting['customer_sendesms']){
                            $sms->sendsingle([
                                'mobile' => $this->request->getData()['mobile'],
                                //'text' => $this->setting['customer_sendesms_order_paid'],
                                'text' => $sms->create_text(
                                    $this->setting['customer_sendesms_order_paid'],[
                                        'token'=> $order['ShopOrders']['trackcode'],
                                        'username'=>$this->request->getAttribute('identity')->get('username'),
                                        'mobile'=>$mobile_number ])
                                ]);
                        }

                        $this->Flash->success('پرداخت با موفقیت انجام گردید');
                    }
                } catch ( Exception $ex ) {
                    echo  $ex->getMessage()  ;
                    $this->Flash->error( $ex->getMessage());
                }
            }
            elseif($status) {
                //echo "کد خطای ارسال شده از طرف بانک $status " . "";
                TableRegistry::get("Shop.shopPayments")->query()->update()
                    ->set(['status' => $status, 'paid' => 5  ])
                    ->where(['shopPayments.id' => $order['id']])
                    ->execute();
                $this->Flash->error("متاسفانه پرداخت با موفقیت انجام نشد. Err-1");

            }
            else{
                TableRegistry::get("Shop.shopPayments")->query()->update()
                    ->set(['status' => $status,'paid' => 5 ])
                    ->where(['shopPayments.id' => $order['id']])
                    ->execute();
                $this->Flash->error("پاسخی از سمت بانک ارسال نشد ");
                //echo "پاسخی از سمت بانک ارسال نشد " ;
            }
            return $this->redirect('/product/payment/'.$token);

            //-----------------------------------------------------------------------

            /* if ( $order and $_GET['status'] == 0 ) {
                $api = $this->setting['terminal_id'] ;
                $amount= CartHelper::OrderTotalPrice($order['ShopOrders']['trackcode']);

                $client = new SoapClient('https://www.zarinpal.com/pg/services/WebGate/wsdl', ['encoding' => 'UTF-8']);
                $result = $client->PaymentVerification([
                    'MerchantID' => $api,
                    'Authority' => $Authority,
                    'Amount' => $amount ]);

                if ($result->Status == 100) {
                    TableRegistry::get("Shop.shopPayments")->query()->update()
                        ->set(['status' => 1])
                        ->where(['shopPayments.id' => $order['id']])
                        ->execute();

                    TableRegistry::get("Shop.shopOrders")->query()->update()
                        ->set(['status' => "paid"])
                        ->where(['id' => $order['shop_order_id']])
                        ->execute();
                }

                $sms = new Sms();
                if($this->setting['admin_sendesms'] and $this->setting['default_mobile']!=''){
                    $sms->sendsingle([
                        'mobile' => $this->setting['default_mobile'],
                        'text' => $this->setting['admin_sendesms_order_paid'] ]);
                }

                if($this->setting['customer_sendesms']){
                    $sms->sendsingle([
                        'mobile' => $this->request->getData()['mobile'],
                        'text' => $this->setting['customer_sendesms_order_paid'] ]);
                }

                $this->Flash->success(__('خوشبختانه پرداخت با موفقیت انجام شد'));
                return $this->redirect([$order['ShopOrders']['trackcode']]);
            }
            else{
                TableRegistry::get("Shop.shopPayments")->query()->update()
                    ->set(['status' => 3])
                    ->where(['shopPayments.id' => $order['id']])
                    ->execute();

                $this->Flash->error(__('متاسفانه پرداخت انجام نشد'));
                return $this->redirect([$order['ShopOrders']['trackcode']]);
            }  */


        }
    }
    private function getPayment_p($token = null, $action = null, $result = null){
        $PIN = $this->setting['terminal_id'];
        $amount = CartHelper::OrderTotalPrice($token) ; //Tooman
        if($action == 'goto'){

            if($result['status'] == 'paid'){
                $this->Flash->error('این سفارش قبلا پرداخت شده است.');
                return $this->redirect([$result['trackcode']]);
            }

            $wsdl_url = "https://pec.shaparak.ir/NewIPGServices/Sale/SaleService.asmx?WSDL";
            $site_call_back_url = str_replace('goto','',Router::url(null, true));
            $terminalid = array_values(array_filter($this->request->getData()['payment']['terminal']));
    
            switch (ShopHelper::Setting('currency')) {
                case 'IRT':
                    $amount = $amount * 10;
                    break;
                default:
                    $amount = $amount;
                    break;
            }

            
            $myrah_id = rand(1000,9999) * date('dhis');
            $params = array (
                "LoginAccount" => $PIN,
                "Amount" => $amount,
                "OrderId" => $myrah_id,
                "CallBackUrl" => $site_call_back_url,
            );
            $client = new SoapClient ( $wsdl_url );
            try {
                $res_pay = $client->SalePaymentRequest(array("requestData" => $params));
                
                if ($res_pay->SalePaymentRequestResult->Token && $res_pay->SalePaymentRequestResult->Status === 0) {

                    $model_payments = $this->getTableLocator()->get('Shop.shopPayments');
                    $pay = $model_payments->newEmptyEntity();
                    $pay = $model_payments->patchEntity($pay,[
                        'shop_order_id'=> $result['id'],
                        'user_id'=> $result['user_id'],
                        'terminalid'=> isset($terminalid[0])?$terminalid[0]:0, //$this->setting['terminal_list'],
                        'price'=>$amount,
                        'status'=>'',
                        'myrahid' => $myrah_id,
                        'au' => $res_pay->SalePaymentRequestResult->Token,
                        'status' => 2,
                    ]);
                    if($model_payments->save($pay)){
                        header ( "Location: https://pec.shaparak.ir/NewIPG/?Token=" . $res_pay->SalePaymentRequestResult->Token ); /* Redirect browser */
                        echo '<script nonce="'.get_nonce.'">window.location.replace("https://pec.shaparak.ir/NewIPG/?Token="' . $res_pay->SalePaymentRequestResult->Token.'");</script>';
                        exit ();
                    }
                }
                elseif ( $res_pay->SalePaymentRequestResult->Status  != '0') {
                    $err_msg = "(<strong> کد خطا : " . $res_pay->SalePaymentRequestResult->Status . "</strong>) " .
                    $res_pay->SalePaymentRequestResult->Message ;
                } 
            } catch ( Exception $ex ) {
                $err_msg =  $ex->getMessage()  ;
            }
        }
    }
    //-------------------------------------------------------------------------------
    //------------------------- FANAVA ----------------------------------------------
    //-------------------------------------------------------------------------------
    private function getPayment_fanava($token = null, $action = null, $result = null){
        $myrah_id = rand(1000,9999) * date('dhis');
        $amount = CartHelper::OrderTotalPrice($token) ; //Tooman
        $site_call_back_url = str_replace('goto','',Router::url(null, true));

        if($action == 'goto'){

            if($result['status'] == 'paid'){
                $this->Flash->error('این سفارش قبلا پرداخت شده است.');
                return $this->redirect([$result['trackcode']]);
            }
            ///////////////////////////////////////////////////////////
            switch (ShopHelper::Setting('currency')) {
                case 'IRT':
                    $amount = $amount * 10;
                    break;
                default:
                    $amount = $amount;
                    break;
            }
            ///////////////////////////////////////////////////////////
            $MID         = $this->setting['terminal_id'];
            $username    = $this->setting['usercode'];
            $password    = $this->setting['passcode'];
            $Amount      = $amount;
            $RedirectURL = $site_call_back_url;
            $ResNum      = date( 'imdHys' );
            $json_data = '{
                "WSContext":{"UserId":"'.$username.'","Password":"'.$password.'"},
                "TransType":"EN_GOODS",
                "ReserveNum":"'.$ResNum.'",
                "Amount":"'.$Amount.'",
                "RedirectUrl":"'.$RedirectURL.'",
                "UserId":"'.$username.'",
                "MobileNo":"'.(is_numeric($this->request->getAttribute('identity')->get('username'))?$this->request->getAttribute('identity')->get('username'):'').'",
                "Email":"'.$this->request->getAttribute('identity')->get('email').'"
                }'; 

	        $curl = curl_init();
            curl_setopt_array( $curl, array(
                CURLOPT_URL            => 'https://fcp.shaparak.ir/ref-payment/RestServices/mts/generateTokenWithNoSign/',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING       => '',
                CURLOPT_MAXREDIRS      => 10,
                CURLOPT_TIMEOUT        => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST  => 'POST',
                CURLOPT_POSTFIELDS     => $json_data,
                CURLOPT_HTTPHEADER     => array(
                    'Content-Type: application/json',
                ),
            ) );
            $response = curl_exec( $curl );
            $status_code = curl_getinfo( $curl )['http_code'] ?? 0;
            curl_close( $curl );

            if ( $status_code == 200 ) {
                $response = json_decode( $response );
                if ( ! empty( $response ) && isset( $response->Result ) && $response->Result == 'erSucceed' ) {

                    $token = $response->Token;
                    $finalURL = 'https://fcp.shaparak.ir/_ipgw_/payment/?lang=fa&token=' . $token;

                    $model_payments = $this->getTableLocator()->get('Shop.shopPayments');
                    $pay = $model_payments->newEmptyEntity();
                    $pay = $model_payments->patchEntity($pay,[
                        'shop_order_id'=> $result['id'],
                        'user_id'=> $result['user_id'],
                        'terminalid'=> $this->setting['terminal_list'],
                        'price'=>$amount,
                        'status'=>'',
                        'myrahid' => $myrah_id,
                        'au' => $token,
                        'status' => 2,
                    ]);
                    if($model_payments->save($pay)){
                        header( 'Location: ' . $finalURL );
                        exit ();
                    }
                } else {
                    $err = json_encode( $response );
                }
            } else {
                $err = '<br> error not 200, status code:' . $status_code;
            }
            var_dump( $err);
        }
    }
    private static function _sanitizeTextField($text)
    {
        $text = strip_tags($text); // حذف تگ‌های HTML
        $text = trim($text);       // حذف فاصله‌های اضافی
        $text = htmlspecialchars($text, ENT_QUOTES, 'UTF-8'); // تبدیل کاراکترهای خاص
        return $text;
    }
    
    private function setPayment_fanava($token = null){

        if (isset($_POST['State'])) { // && $_POST['State'] === 'OK'

            //pr($_POST);
            $order = $this->getTableLocator()->get('Shop.ShopPayments')->find('all')
                ->where(['au' => $this->request->getData()['token']])
                ->contain(['ShopOrders'])
                ->first();
            
            if(!$order){
                $this->Flash->error('چنین سفارشی پیدا نشد -2');
                return $this->redirect('/');
            }
            elseif($order['paid'] == 1){
                $this->Flash->error('سفارش قبلا تایید شده است.');
                return $this->redirect([$order['shop_order']['trackcode']]);
            }

            if( $_POST['State'] === 'OK'){

                $RefNum = $this->_sanitizeTextField($_POST['RefNum']);
                $nf_token = $this->_sanitizeTextField($_POST['token']);
                if (empty($nf_token) || empty($RefNum)) {
                    return;
                }
            
                $MID         = $this->setting['terminal_id'];
                $username    = $this->setting['usercode'];
                $password    = $this->setting['passcode'];
                $order_id = $order['shop_order_id'];

                $json_Verifydata = '{
                    "WSContext":{"UserId":"'.$username.'","Password":"'.$password.'"},
                    "Token": "' . $nf_token . '",
                    "RefNum": "' . $RefNum . '"
                }';

                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL            =>
                    'https://fcp.shaparak.ir/ref-payment/RestServices/mts/verifyMerchantTrans/',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING       => '',
                    CURLOPT_MAXREDIRS      => 10,
                    CURLOPT_TIMEOUT        => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST  => 'POST',
                    CURLOPT_POSTFIELDS     => $json_Verifydata,
                    CURLOPT_HTTPHEADER     => array(
                    'Content-Type: application/json',
                    ),
                ));
                $response = curl_exec($curl);
                $status = curl_getinfo($curl)['http_code'] ?? 0;
                curl_close($curl);

                if ($status == '200') {
                    $response = json_decode($response);
                                        
                    if (!empty($response) && isset($response->Result) && $response->Result == 'erSucceed') {

                        TableRegistry::get("Shop.shopPayments")->query()->update()
                            ->set([
                                'err_code'=>json_encode(['verify'=> $response]),
                                'err_text'=>'',
                                'return_data'=>json_encode($_POST),
                                'mobile_number'=>'',
                                'status' => 0 ,
                                'paid' => 1 ])
                            ->where(['shopPayments.id' => $order['id']])
                            ->execute();

                        TableRegistry::get("Shop.shopOrders")->query()->update()
                            ->set(['status' => "paid"])
                            ->where(['id' => $order_id ])
                            ->execute();

                        // اینجا ،پس از پرداخت، تعداد سفارش کاربر از موجودی محصول کاسته می شود
                        $this->decrease_stock_after_payment($order_id);

                        $sms = new Sms();
                        $mobile_number = $this->request->getAttribute('identity')->get('username');
                        if($this->setting['admin_sendesms'] and $this->setting['default_mobile']!=''){
                            try {
                                $sms->sendsingle([
                                    'mobile' => $this->setting['default_mobile'],
                                    //'text' => $this->setting['admin_sendesms_order_paid'],
                                    'text' => $sms->create_text(
                                        $this->setting['admin_sendesms_order_paid'],[
                                            'token'=> $order['shop_order']['trackcode'],
                                            'username'=>$this->request->getAttribute('identity')->get('username'),
                                            'mobile'=>$mobile_number ])
                                ]);
                            }catch ( Exception $ex ) {}
                        }

                        if($this->setting['customer_sendesms']){
                            try {
                                $sms->sendsingle([
                                    'mobile' => $this->request->getData()['mobile'],
                                    //'text' => $this->setting['customer_sendesms_order_paid'],
                                    'text' => $sms->create_text(
                                        $this->setting['customer_sendesms_order_paid'],[
                                            'token'=> $order['shop_order']['trackcode'],
                                            'username'=>$this->request->getAttribute('identity')->get('username'),
                                            'mobile'=>$mobile_number ])
                                    ]);
                            }catch ( Exception $ex ) {}
                        }
                        $this->Flash->success('پرداخت شما با موفقیت انجام گردید');
                    } 
                    else {
                        TableRegistry::get("Shop.shopPayments")->query()->update()
                            ->set([
                                'err_code'=>'',
                                'err_text'=>'',
                                'return_data'=>json_encode($_POST),
                                'mobile_number'=>'',
                                'paid' => 3,
                                'status' => "" ])
                            ->where(['shopPayments.id' => $order['id']])
                            ->execute();

                        $this->Flash->error('متاسفانه پرداخت شما موفقیت آمیز نبوده است');
                    }
                } 
            }
            else {
                TableRegistry::get("Shop.shopPayments")->query()->update()
                    ->set([
                        'err_code'=>'',
                        'err_text'=>$_POST['State'],
                        'return_data'=>json_encode($_POST),
                        'mobile_number'=>'',
                        'status' =>'', 
                        'paid' => 5
                        ])
                    ->where(['shopPayments.id' => $order['id']])
                    ->execute();
                $this->Flash->error("متاسفانه پرداخت با موفقیت انجام نشد.");
                //$this->Flash->error("پاسخی از سمت بانک ارسال نشد ");
            }
            
            return $this->redirect('/product/payment/'.$token);
        }
    }
    //-------------------------------------------------------------------------------
    //-------------------------------------------------------------------------------
    private function decrease_stock_after_payment($order_id = null){
        $orderlists = TableRegistry::get("Shop.shopOrderproducts")->find('all')
            ->where(['shop_order_id' => $order_id])
            ->toarray();
        foreach($orderlists as $orderlist){
            $stocks = TableRegistry::get("Shop.shopProductstocks")->find('all')
                ->where([
                    'post_id' => $orderlist['post_id'] , 
                    $orderlist['attrs'] == NULL ?['pattern IS NULL']:['pattern' => $orderlist['attrs']],
                    ])
                ->first();
            if($stocks){
                $count = $stocks['stock'] - $orderlist['quantity'];
                if(TableRegistry::get("Shop.shopProductstocks")->query()->update()
                    ->set(['stock' => $count ])
                    ->where(['id' => $stocks['id'] ])
                    ->execute()){

                        TableRegistry::getTableLocator()->get('Shop.ShopOrderlogs')->save(
                            TableRegistry::getTableLocator()->get('Shop.ShopOrderlogs')->newEmptyEntity(([
                            'shop_order_id' =>  $order_id ,
                            'user_id'=> $this->request->getAttribute('identity')->get('id'),
                            'status'=> 'موفق:  <b>'. $orderlist['quantity'] .'</b> عدد از موجودی کسر شد'
                        ]));
                    }
            }else{
                TableRegistry::getTableLocator()->get('Shop.ShopOrderlogs')->save(
                    TableRegistry::getTableLocator()->get('Shop.ShopOrderlogs')->newEmptyEntity(([
                    'shop_order_id' =>  $order_id ,
                    'user_id'=> $this->request->getAttribute('identity')->get('id'),
                    'status'=> 'متاسفانه، پس از پرداخت، کاهش موجودی محصول با موفقیت انجام نشد'
                ]));
            }
        }
    }
    //-------------------------------------------------------------------------------
    public function get_tracker(){
        $this->Order = TableRegistry::getTableLocator()->get('Shop.ShopOrders');
        $a = true;
        while($a == true){
            $token = $this->request->getAttribute('identity')->get('id').date('mh').rand(1000,9999);
            $temp = $this->Order->find('all')->where(['trackcode'=> $token])->count();
            if($temp == 0)
                $a = false;
        }
        return $token;
    }
    //-------------------------------------------------------------------------------
    public function add(){
        if ($this->request->is('post')) {
            $id = $this->request->getdata()['id'];

            if($this->request->getdata()['shop_qty'])
                $quantity = $this->request->getdata()['shop_qty'];
            else
                $quantity = 1;

            $attrs = [];
            foreach(Router::getRequest()->getdata() as $kta => $dta){
                if(substr( $kta, 0, 4 ) === "attr"){
                    $attrs[str_replace('attr','',$kta)] = $dta;
                }
            }

            $product = $this->Query->post('product', ['id'=>$id,'get_type'=>'first','contain'=>['PostMetas']]);
            if(empty($product)) {
                $this->Flash->error('Invalid request');
            }
            else{
                $message = CartHelper::add($id, $quantity, $attrs);
                if($this->setting['cart_redirect_after_add'] == 1){
                    $this->Flash->success( $message );
                    return $this->redirect('/product/cart/');
                }
                else{
                    $this->Flash->success( $message .
                    '<a class="btn btn-primary btn-sm float-left pb-0" href="'.Router::url('/product/cart').'">مشاهده سبدخرید</a>');
                }
            }
        }
        return $this->redirect($this->referer());
    }
    //-------------------------------------------------------------------------------
    public function compare($id = null){
        //Router::getRequest()->getSession()->delete('Compare');
        if($this->request->getQuery('delete')){
            $list = Router::getRequest()->getSession()->read('Compare');
            unset($list[$this->request->getQuery('delete')]);
            Router::getRequest()->getSession()->write('Compare', $list);
            $this->redirect($this->referer());
        }
        elseif ($id != null) {
            $list = Router::getRequest()->getSession()->read('Compare');
            $list[$id] = $id;
            Router::getRequest()->getSession()->write('Compare', $list);
            $this->redirect('/shop/compare/');
        }

        $result = [];
        if( ($list = Router::getRequest()->getSession()->read('Compare'))){
            $result = $this->Query->post('product',['id' => $list ]);
        }
        $this->set(['results' =>  $result]);
    }
    //-------------------------------------------------------------------------------
}