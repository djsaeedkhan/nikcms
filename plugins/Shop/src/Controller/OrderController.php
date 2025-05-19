<?php
namespace Shop\Controller;

use Cake\Core\Configure;
use Shop\Controller\AppController;
use Cake\ORM\TableRegistry;
use Sms\Sms;
use Cake\Log\Log;
use Cake\Event\Event;
use Shop\View\Helper\CartHelper;

class OrderController extends AppController
{
    public function initialize(){
        parent::initialize();
        $this->ViewBuilder()->setLayout('Admin.default');
    }
    //-----------------------------------------------------------
    public function beforeFilter(Event $event){
        $this->Auth->allow(['checkToken']);
    }
    //-----------------------------------------------------------
    public function index($id = null){

        $data = TableRegistry::get('Shop.ShopOrders')->find('all')
            ->order(['ShopOrders.id'=>'desc'])
            ->contain([
                'shopOrdershippings',
                'ShopAddresses'=>['ShopUseraddresses'],
                'ShopOrderproducts','ShopPayments']);
        
        if($this->request->getQuery('status')){
            $data->where(['status' => $this->request->getQuery('status') ]);
        }
        if($this->request->getQuery('trackcode')){
            $data->where(['OR' =>[
                'ShopOrders.trackcode LIKE ' => '%'.$this->request->getQuery('trackcode') .'%' ,
                'ShopOrders.shipmentcode LIKE ' =>'%'. $this->request->getQuery('trackcode') .'%' ,
            ]]);
        }

        if($this->request->getQuery('province')){
            $prv = $this->request->getQuery('province');
            $data->matching('ShopAddresses.ShopUseraddresses', function ($q) use ($prv) {
                return $q->where(['ShopUseraddresses.billing_state' => $prv]);
            });
        }

        if($this->request->getQuery('date')){
            $date = $this->request->getQuery('date');
            try {
                if (preg_match ("/^([0-9]{4})\/([0-9]{2})\/([0-9]{2})$/", $date) ) {
                    $date2 = strtotime($this->Func->shm_to_mil($date,'/'));
                    $date2 = date('Y/m/d 00:00:00',$date2); 
                    $data->where(function (\Cake\Database\Expression\QueryExpression $exp) use($date2) {
                        $from = (new \DateTime($date2))->setTime(0, 0, 0);
                        $to = (new \DateTime($date2))->setTime(23, 59, 59);
                        return $exp->between('ShopOrders.created', $from, $to, 'datetime');
                    });
                } else {
                    $this->Flash->error('فرمت تاریخ سفارش اشتباه می باشد');
                }
            } catch (\Throwable $th) {} 
        }
        $results = $this->paginate($data);
        $this->set(compact('results'));
    }
    //-----------------------------------------------------------
    public function view($id = null){
        $this->set(['result'=> $p =
            TableRegistry::get('Shop.ShopOrders')->find('all')
            ->contain([
                'Users',
                'ShopAddresses'=>['ShopUseraddresses'],
                'shopOrdershippings',
                'ShopOrderproducts'=>['Posts','ShopOrderattributes'=>['ShopAttributes','ShopAttributelists']],
                'ShopPayments',
                'ShopOrderlogs'=>'Users'])
            ->where(['ShopOrders.id' => $id])
            ->first(),
            'ShippingList' => TableRegistry::get('Shop.ShopOrders')->find('all')
        ]);
        if ($this->request->getQuery('print') =='box') {
            $this->autoRender = false;
            return $this->response->withStringBody($this->cell('Shop.Exportpdf2',[$p['trackcode'] ]));
        }
    }
    //-----------------------------------------------------------
    public function status($id = null){
        if($this->request->getQuery('action')){
            $list = [];
            foreach($this->request->getQuery() as $k => $v){
                if($v == 'on') $list[$k] = $k;
            }
            switch($this->request->getQuery('action')){
                case 'post_print';
                    $this->autoRender = false;
                    return $this->response->withStringBody($this->cell('Shop.Exportpdf2',[ $list ]));
                    break;

                case 'status':
                    return $this->create_status($list);
                    break;

                case 'delete':
                    foreach($list as $ls){
                        $this->_delete_order($ls,'trackcode');
                    }
                    return $this->redirect(['action' => 'index']);
                    break;
            }
        }
        else{
            return $this->create_status($id);
        }
    }
    //-----------------------------------------------------------
    private function create_status($id = null){

        $this->ShopOrders = TableRegistry::get('Shop.ShopOrders');
        if($id != null){
            if(is_array($id))
                $order = $this->ShopOrders->find('all')->where(['ShopOrders.trackcode IN '=> $id])->toarray();
            else
                $order = $this->ShopOrders->get($id,['contain'=>'ShopAddresses']);
        }
        else
            $order = $this->ShopOrders->newEntity();

        $mobile_number = false;
        
        if(isset($order->shop_address->phone) and $order->shop_address->phone != '')
            $mobile_number = $order->shop_address->phone;

        if ($this->request->is(['patch', 'post', 'put'])) {

            $old_status = $order->status;
            $new_status = $this->request->getData()['status'];

            if(isset($this->request->getData()['order_id'])){
                foreach($this->request->getData()['order_id'] as $value){
                    $order = $this->ShopOrders->get($value);
                    $order = $this->ShopOrders->patchEntity($order, [
                        'status' => $this->request->getData()['status']
                    ]);

                    if($this->request->getData()['status'] == "processing"){
                        if($order->token == ''){
                            $order->token = $order->user_id. date('md').rand(100,999);
                        }
                    }

                    if ($this->ShopOrders->save($order)) {

                        if($this->request->getData()['status'] == "processing" and $mobile_number != false){
                            $sms = new Sms();
                            $sms->sendsingle([
                                'mobile' => $mobile_number,
                                'text' => "سفارش شما نیاز به تایید دارد<br>".$order->token ]);
    
                            TableRegistry::getTableLocator()->get('Shop.ShopOrderlogs')->save(
                                TableRegistry::getTableLocator()->get('Shop.ShopOrderlogs')->newEntity([
                                'shop_order_id' =>  $value ,
                                'user_id'=> $this->Auth->user('id'),
                                'status'=>'ارسال پیامک صحت سنجی<br>کد: '. $order->token .'<br>شماره موبایل: '.$mobile_number
                            ]));
                        }
                        
                        if($old_status != $new_status and $mobile_number != false){
                            if(isset($this->setting['sms_'.$new_status]) and $this->setting['sms_'.$new_status] !=''){
                                $sms = new Sms();
                                $sms->sendsingle([
                                    'mobile' => $mobile_number,
                                    'text' => $this->setting['sms_'.$new_status] ]);

                                TableRegistry::getTableLocator()->get('Shop.ShopOrderlogs')->save(
                                    TableRegistry::getTableLocator()->get('Shop.ShopOrderlogs')->newEntity([
                                    'shop_order_id' =>  $value ,
                                    'user_id'=> $this->Auth->user('id'),
                                    'status'=>'ارسال پیامک تغییر وضعیت سفارش به شماره '.$mobile_number
                                ]));   
                            }
                        }

                        TableRegistry::getTableLocator()->get('Shop.ShopOrderlogs')->save(
                            TableRegistry::getTableLocator()->get('Shop.ShopOrderlogs')->newEntity([
                            'shop_order_id' =>  $value ,
                            'user_id'=> $this->Auth->user('id'),
                            'status'=>'سفارش - تغییر وضعیت به "'. CartHelper::Predata('order_status',$this->request->getData()['status']).'"'
                        ]));
                        $this->Flash->success('سفارش '.$order->trackcode .' با موفقیت به روز شد');
                    }else{
                        $this->Flash->error('متاسفانه سفارش '.$order->trackcode .' به روز نشد');
                    }
                }
                return $this->redirect(['action' =>'index' ]);
            }else{

                $order = $this->ShopOrders->patchEntity($order,$this->request->getData());
                if($this->request->getData()['status'] == "processing"){
                    if($order->token == ''){
                        $order->token = $order->user_id. date('md').rand(100,999);
                    }
                }

                if ($this->ShopOrders->save($order)) {

                    if($this->request->getData()['status'] == "processing" and $mobile_number != false){
                        $sms = new Sms();
                        $sms->sendsingle([
                            'mobile' => $mobile_number,
                            'text' => "سفارش شما نیاز به تایید دارد<br>".$order->token ]);

                        TableRegistry::getTableLocator()->get('Shop.ShopOrderlogs')->save(
                            TableRegistry::getTableLocator()->get('Shop.ShopOrderlogs')->newEntity([
                            'shop_order_id' =>  $order->id ,
                            'user_id'=> $this->Auth->user('id'),
                            'status'=>'ارسال پیامک صحت سنجی<br>کد: '. $order->token .'<br>شماره موبایل: '.$mobile_number
                        ]));
                    }
                    
                    if($old_status != $new_status and $mobile_number != false){
                        if(isset($this->setting['sms_'.$new_status]) and $this->setting['sms_'.$new_status] !=''){
                            $sms = new Sms();
                            $sms->sendsingle([
                                'mobile' => $mobile_number,
                                'text' => $this->setting['sms_'.$new_status] ]);
                        }
                        TableRegistry::getTableLocator()->get('Shop.ShopOrderlogs')->save(
                            TableRegistry::getTableLocator()->get('Shop.ShopOrderlogs')->newEntity([
                            'shop_order_id' =>   $id,
                            'user_id'=> $this->Auth->user('id'),
                            'status'=>'ارسال پیامک تغییر وضعیت سفارش به شماره '.$mobile_number
                        ]));
                    }

                    TableRegistry::getTableLocator()->get('Shop.ShopOrderlogs')->save(
                        TableRegistry::getTableLocator()->get('Shop.ShopOrderlogs')->newEntity([
                        'shop_order_id' => $id,
                        'user_id'=> $this->Auth->user('id'),
                        'status'=>'سفارش - تغییر وضعیت به "'. CartHelper::Predata('order_status',$this->request->getData()['status']).'"'
                    ]));
                    $this->Flash->success(__('The shop status has been saved.'));
                    return $this->redirect(['action' =>'view', $order->id]);
                }
            }
            $this->Flash->error(__('The shop status could not be saved. Please, try again.'));
        }
        $this->set(compact('order'));
    }
    //-----------------------------------------------------------
    public function logs($id = null){
        $this->set(['result'=>
            TableRegistry::get('Shop.ShopOrders')->find('all')
            ->contain([
                'Users',
                'ShopAddresses'=>['ShopUseraddresses'],
                'shopOrdershippings',
                'ShopOrderproducts'=>['ShopOrderattributes'=>['ShopAttributes','ShopAttributelists']],
                'ShopPayments'])
            ->where(['ShopOrders.id' => $id])
            ->first(),
            'ShippingList' => TableRegistry::get('Shop.ShopOrders')->find('all')
        ]);
    }
    //-----------------------------------------------------------
    public function delete($id = null){
        $this->request->allowMethod(['post', 'delete']);
        $this->_delete_order($id);
        return $this->redirect(['action' => 'index']);
    }
    //-----------------------------------------------------------
    private function _delete_order($id = null , $field = null){
        $this->ShopOrders = TableRegistry::get('Shop.ShopOrders');
        
        if($field == null)
            $shopOrder = $this->ShopOrders->get($id);
        else
            $shopOrder = $this->ShopOrders->find('all')->where([$field => $id])->first();

        if($shopOrder){
            $id = $shopOrder['id'];
            foreach(TableRegistry::get('Shop.ShopOrderproducts')->find('all')->where(['shop_order_id' => $id])->toarray() as $tmp ){
                TableRegistry::get('Shop.ShopOrderattributes')->deleteAll(['shop_orderproduct_id' => $tmp['id'] ]);
            }
            TableRegistry::get('Shop.ShopOrderproducts')->deleteAll(['shop_order_id' => $id ]);
            TableRegistry::get('Shop.ShopOrdertokens')->deleteAll(['shop_order_id' => $id ]);
            TableRegistry::get('Shop.ShopOrdertexts')->deleteAll(['shop_order_id' => $id ]);
            TableRegistry::get('Shop.ShopOrdershippings')->deleteAll(['shop_order_id' => $id ]);
            TableRegistry::get('Shop.ShopPayments')->deleteAll(['shop_order_id' => $id ]);
        }
        if ($this->ShopOrders->delete($shopOrder)) {
            $this->Flash->success(__('حذف سفارش با موفقیت انجام شد'));
        } else {
            $this->Flash->error(__('متاسفانه حذف سفارش انجام نشد. لطفا دوباره تلاش کنید'));
        }
    }
    //-----------------------------------------------------------
    public function checkToken($id = null){
        $this->autoRender = false;
        //Configure::write('debug', 0);
        //Log::write('debug', $this->request);

        /* $this->opt = TableRegistry::get('Options');
        $text = $this->opt->patchEntity($this->opt->newEntity(),
        [
            'name'=>'1',
            'value'=> serialize(($this->request->getQuery())),
            'types'=>'3',
        ]);
        $this->opt->save($text); */

        if($this->request->getQuery('body') and $this->request->getQuery('body')!= null){
            $token = intval($this->request->getQuery('body'));
            $this->Orders = TableRegistry::get('Shop.ShopOrders');
            $temp = $this->Orders->find('all')->where(['token'=> $token])->toarray();
            if(is_array($temp) and count($temp) == 1){

                TableRegistry::get("Shop.ShopOrders")->query()->update()
                    ->set(['token' => 1])
                    ->where(['ShopOrders.id' => $temp[0]['id']])
                    ->execute();

                    $sms = new Sms();
                    $sms->sendsingle([
                        'mobile' => $this->request->getQuery('from'),
                        'text' => "تایید سفارش شما با موفقیت انجام شد"]);
                        
            }

            /* $text = $this->model->patchEntity($this->opt->newEntity(),[
                'name'=>'1',
                'value'=> serialize(($this->request->getQuery())),
                'types'=>'3',
            ]);
            $this->opt->save($text); */
            

        }
        return $this->response->withStringBody("ok");
    }
    //-----------------------------------------------------------
}