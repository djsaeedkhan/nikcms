<?php
namespace Shop\Controller;

use Shop\Controller\AppController;
use Cake\Controller\Controller;
use Cake\Core\Configure;
use Cake\Event\EventInterface;
use Cake\Core\Plugin;
use Cake\ORM\TableRegistry;
use Cake\Http\Exception\NotFoundException;
use Cake\I18n\I18n;
use Cake\Routing\Router;
use \Shop\Export;
use Shop\ProvinceCity;
use Shop\View\Helper\CartHelper;
use Sms\Sms;
use SoapClient;

class ProfileController extends AppController
{
    public $template;
    //-------------------------------------------------------------------------------
    public function initialize(): void
    {
        parent::initialize();
        $this->viewBuilder()->setLayout('Shop.profile');
        $this->ShopAddresses =  $this->getTableLocator()->get('Shop.ShopUseraddresses');
    }
    //-------------------------------------------------------------------------------
    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);
        $this->Authentication->addUnauthenticatedActions();
        if(!$this->request->getAttribute('identity')->get('id')){
            return $this->redirect('/users/login');
        }
    }
    //-------------------------------------------------------------------------------
    public function index($page = null){
        if(!$this->request->getAttribute('identity')->get('id')){
            $this->Flash->error(__('لطفا در سایت وارد شوید'));
            return $this->redirect('/');
        }

        $this->set(['current'=>$page]);
        switch ($page) {
            case 'favorites':
                $this->favorites();
                $this->render('favorites');
                break;

            case 'my':
                $this->completeProfile();
                $this->render('complete_profile');
                break;

            case 'addresses':
                $this->addresses();
                break;

            case 'notifications':
                $this->notifications();
                $this->render('notifications');
                break;

            case 'user-history':
                $this->userhistory();
                $this->render('userhistory');
                break;

            case 'personal-info':
                $this->personalinfo();
                $this->render('personalinfo');
                break;

            default:
                $this->orders();
                $this->render('orders');
                break;
        }
    }
    //-------------------------------------------------------------------------------
    public function logestics($id = null)
    {
        if($id == null){
            $logestics = TableRegistry::getTableLocator()->get('Shop.ShopLogesticusers')->find('all')
                ->where([ 'user_id' => $this->request->getAttribute('identity')->get('id') ])
                ->contain(['ShopLogestics'=>[
                    /* 'ShopOrderlogestics' => function ($q) {
                        return $q->order(['id'=>'desc']);
                    }, */
                    'ShopLogesticlists']])
                ->toarray();
            $this->set(compact('logestics'));
            $this->render('logestics');
        }
        else
        {
            $logestics = TableRegistry::getTableLocator()->get('Shop.ShopLogesticusers')->find('all')
                ->where([
                    'shop_logestic_id' => $id,
                    'ShopLogestics.id'=>$id,
                    'user_id' => $this->request->getAttribute('identity')->get('id')
                    ])
                ->contain([
                    'ShopLogestics'=>[
                        'ShopOrderlogestics' => function ($q) {
                            return $q
                            ->contain(['Users','ShopOrders'=>['Users','ShopOrderproducts'=>'Posts']])
                            ->order(['ShopOrderlogestics.id'=>'desc']);
                        },
                        /* 'ShopOrderlogestics'=>[
                            ], */
                        'ShopLogesticlists'
                    ]])
                ->first();
            if(!$logestics){
                $this->Flash->error(__('متاسفانه چنین نمایندگی پیدا نشد'));
                return $this->redirect($this->referer());
            }
            $this->set(compact('logestics')); 
            $this->render('logestics_order');
        }
    }
    //-------------------------------------------------------------------------------
    public function logdetail($id = null, $order_id = null)
    {
        $logestics = TableRegistry::getTableLocator()->get('Shop.ShopLogesticusers')->find('all')
            ->where([
                'ShopLogesticusers.shop_logestic_id' => $id,
                'ShopLogesticusers.user_id' => $this->request->getAttribute('identity')->get('id')
            ])
            ->contain(['ShopLogestics'=>['ShopLogesticlists']])
            ->first();
        if(!$logestics){
            $this->Flash->error(__('متاسفانه چنین نمایندگی پیدا نشد'));
            return $this->redirect($this->referer());
        }

        $order_detail = TableRegistry::getTableLocator()->get('Shop.ShopOrderlogestics')
            ->find('all')
            ->where([
                'ShopOrderlogestics.shop_logestic_id' => $id,
                'ShopOrderlogestics.shop_order_id' => $order_id 
                ])
            ->contain([
                'ShopOrderlogesticlogs' => function ($q) {
                    return $q
                        ->contain(['Users'])
                        ->order(['ShopOrderlogesticlogs.id'=>'desc']);
                },
                'ShopOrders'=>['ShopAddresses'=>'ShopUseraddresses'],
                'ShopOrderproducts',
                'Users'
                ])
            ->first();  
        if( $order_detail == null ){
            $this->Flash->error(__('متاسفانه چنین سفارشی پیدا نشد'));
            return $this->redirect($this->referer());
        }

        if ($this->request->is('post') and isset($this->request->getData()['descr']) and $order_detail['enable'] < 1) {
            $this->ShopOrderlogesticlogs = TableRegistry::getTableLocator()->get('Shop.ShopOrderlogesticlogs');
            $shopOrderlogesticlog = $this->ShopOrderlogesticlogs->newEntity();
            $shopOrderlogesticlog = $this->ShopOrderlogesticlogs->patchEntity($shopOrderlogesticlog,[
                'descr'=> $this->request->getData()['descr'],
                'shop_logestic_id'=>$id,
                'shop_order_id'=>$order_id,
                'shop_orderlogestic_id'=>$order_detail['id'],
                'user_id'=> $this->request->getAttribute('identity')->get('id'),
            ]);
            if ($this->ShopOrderlogesticlogs->save($shopOrderlogesticlog)) {
                $this->Flash->success(__('ثبت وضعیت با موفقیت انجام شد'));
                return $this->redirect($this->referer());
            }
            $this->Flash->error(__('متاسفانه ثبت وضعیت انجام نشد'));
        }

        if ($this->request->is('post') and isset($this->request->getData()['action'])) {
            $temp = TableRegistry::get("Shop.ShopOrderlogestics")->query()->update()
                    ->set(['enable' => 1 ])
                    ->where(['id' => $order_detail->id ])
                    ->execute();
            if ($temp) {
                $this->Flash->success(__('ثبت وضعیت با موفقیت انجام شد'));
                return $this->redirect($this->referer());
            }
            $this->Flash->error(__('متاسفانه ثبت وضعیت انجام نشد'));
        }
        $this->set(compact('order_id','order_detail'));
        $this->render('logestics_detail');
        
    }
    //-------------------------------------------------------------------------------
    private function completeProfile(){
        
        $this->ShopProfiles = $this->getTableLocator()->get('Shop.ShopProfiles');
        $temps = $this->ShopProfiles->find('all')
            ->where(['user_id'=>$this->request->getAttribute('identity')->get('id')])
            ->first();
        if($temps)
            $shop_profile = $temps;
        else
            $shop_profile = $this->ShopProfiles->newEntity();

        if ($this->request->is(['patch', 'post', 'put'])) {
            $shop_profile = $this->ShopProfiles->patchEntity($shop_profile,$this->request->getData());
            $shop_profile->user_id = $this->Auth->user()?$this->request->getAttribute('identity')->get('id'):null;
            if ($this->ShopProfiles->save($shop_profile)){
                $this->Flash->success(__('ثبت اطلاعات با موفقیت انجام شد'));
                if($this->request->getQuery('redirect') and $this->request->getQuery('redirect') == 'factor')
                    return $this->redirect('/product/factor/');
            }      
            else{
                $this->Flash->error(__('متاسفانه ثبت اطلاعات با موفقیت انجام نشد'));
            }
        }
        $this->set('shop_profile',$shop_profile);
    }
    //-------------------------------------------------------------------------------
    private function orders(){
        $results = $this->getTableLocator()->get('Shop.ShopOrders')->find('all')
            ->where(['ShopOrders.user_id'=> $this->request->getAttribute('identity')->get('id')])
            ->order(['ShopOrders.id'=>'desc'])
            ->contain(['ShopOrderproducts','ShopPayments','ShopOrderrefunds'])
            ->toarray();
        $this->set('results',$results);
    }
    //-------------------------------------------------------------------------------
    private function favorites(){
        $this->ShopFavorites = $this->getTableLocator()->get('Shop.ShopFavorites');
        if($this->request->is('post') and $this->request->getQuery('delete')){

            $this->request->allowMethod(['post', 'delete']);
            $temp = $this->ShopFavorites->find('all')
                ->where([
                    'id' => $this->request->getQuery('delete'),
                    'user_id' => $this->request->getAttribute('identity')->get('id')])
                ->first();

            if ($this->ShopFavorites->delete($temp)) {
                $this->Flash->success(__('حذف از علاقه مندی ها انجام شد'));
            } else {
                $this->Flash->error(__('متاسفانه حذف انجام نشد'));
            }
            return $this->redirect($this->referer());
        }

        if($this->request->getQuery('add') and $this->request->getQuery('add') != ''){

            if( $this->ShopFavorites->find('all')
                ->where(['post_id'=> $this->request->getQuery('add') , 'user_id'=>$this->request->getAttribute('identity')->get('id')])
                ->count() > 0){

                    $temp = $this->ShopFavorites->find('all')
                        ->where([
                            'post_id' => $this->request->getQuery('add'),
                            'user_id' => $this->request->getAttribute('identity')->get('id')])
                        ->first();

                    if ($this->ShopFavorites->delete($temp)) {
                        $this->Flash->success(__('حذف از علاقه مندی ها انجام شد'));
                    } else {
                        $this->Flash->error(__('متاسفانه حذف انجام نشد'));
                    }

                    return $this->redirect($this->referer());
                }
            $temp = $this->ShopFavorites->patchEntity($this->ShopFavorites->newEntity(),[
                'user_id' => $this->request->getAttribute('identity')->get('id'),
                'post_id' => $this->request->getQuery('add'),
            ]);
            if ($this->ShopFavorites->save($temp)) {
                $this->Flash->success(__('ثبت اطلاعات با موفقیت انجام شد'));
            } else {
                $this->Flash->error(__('متاسفانه ثبت اطلاعات انجام نشد'));
            }
            return $this->redirect($this->referer());
        }

        $results = $this->ShopFavorites->find('all')
            ->where(['user_id'=> $this->request->getAttribute('identity')->get('id')])
            ->order(['id'=>'desc'])
            ->toarray();

        $this->set('results',$results);
    }
    //-------------------------------------------------------------------------------
    private function addresses(){
        $results = $this->ShopAddresses->find('all')
            ->where(['user_id' => $this->request->getAttribute('identity')->get('id')])
            ->order(['id' => 'desc'])
            ->toarray();
        $this->set('results',$results);
        
        if($this->request->is('ajax') and $this->request->getQuery('province') ) {
            $this->autoRender = false;
            Configure::write('debug', 0);
            $pp = new ProvinceCity();
            $temp = $pp->getlist($this->request->getQuery('province'));
            $response = $this->response->withType('application/json')->withStringBody(json_encode($temp));
            echo $response;
            return false;
        }
        elseif($this->request->getQuery('action') == 'add'){
            $this->address_add();
            return $this->render('addresses_add');
        }
        elseif($this->request->is('post')){

            if($this->request->getQuery('delete')){
                $this->request->allowMethod(['post', 'delete']);
                $temp = $this->ShopAddresses->find('all')
                    ->where([
                        'id' => $this->request->getQuery('delete'),
                        'user_id' => $this->request->getAttribute('identity')->get('id')])
                    ->first();
                if ($this->ShopAddresses->delete($temp)) {
                    $this->Flash->success(__('حذف از آدرس ها انجام شد'));
                } else {
                    $this->Flash->error(__('متاسفانه حذف انجام نشد'));
                }
            }
            else{

                $temp = $this->ShopAddresses->find('all')
                    ->where([
                        'id' => $this->request->getQuery('delete'),
                        'user_id' => $this->request->getAttribute('identity')->get('id')])
                    ->first();
                if ($this->ShopAddresses->delete($temp)) {
                    $this->Flash->success(__('حذف از آدرس ها انجام شد'));
                } else {
                    $this->Flash->error(__('متاسفانه حذف انجام نشد'));
                }
            }
            return $this->redirect($this->referer());
        }
        $this->render('addresses');
        
    }
    //-------------------------------------------------------------------------------
    private function address_add(){

        if($this->request->getQuery('edit'))
            $shopAddress = $this->ShopAddresses->find('all')
                ->where(['id' => $this->request->getQuery('edit') ,
                    'user_id'=> $this->request->getAttribute('identity')->get('id')])
                ->first();
        else
            $shopAddress = $this->ShopAddresses->newEntity();
        if ($this->request->is(['patch', 'post', 'put'])) {
            $shopAddress = $this->ShopAddresses->patchEntity($shopAddress, $this->request->getData());
            $shopAddress['user_id'] = $this->request->getAttribute('identity')->get('id');
            if ($this->ShopAddresses->save($shopAddress)) {
                $this->Flash->success(__('ثبت اطلاعات با موفقیت انجام شد'));

                if( isset($this->request->getQuery()['nonav']) and $this->request->getQuery()['nonav'] == 1)
                    echo '<script nonce="'.get_nonce.'">parent.location.reload();</script>';
                else
                    return $this->redirect('/shop/profile/addresses');
            } else {
                $this->Flash->error(__('متاسفانه ثبت اطلاعات انجام نشد'));
            }
        }

        $this->set([
            'shopAddress' => $shopAddress,
        ]);
    }
    //-------------------------------------------------------------------------------
    public function addrefund($id = null){
        if(!$this->request->getAttribute('identity')->get('id')){
            $this->Flash->error(__('لطفا در سایت وارد شوید'));
            return $this->redirect('/');
        }
        
        $this->Orderrefunds = $this->getTableLocator()->get('Shop.ShopOrderrefunds');
        $p = $this->getTableLocator()->get('Shop.ShopOrders')->find('all')
            ->where([
                'user_id'=>$this->request->getAttribute('identity')->get('id') ,
                'trackcode'=> $this->request->getParam('trackcode')])
            ->first();
        if(!$p){
            $this->Flash->error(__('چنین سفارشی برای شما پیدا نشد'));
            return $this->redirect($this->referer());
        }
        
        $p2 = $this->Orderrefunds->find('all')
            ->where([
                'user_id'=>$this->request->getAttribute('identity')->get('id') ,
                'shop_order_id' => $p['id'] ])
            ->first();
        if($p2){
            $this->Flash->error(__('برای این سفارش قبلا درخواست مرجوعی ثبت شده است'));
            return $this->redirect($this->referer());
        }

        $refunds = $this->Orderrefunds->newEntity();
        if($this->request->is('post')){
            $refunds = $this->Orderrefunds->patchEntity($refunds, $this->request->getData());
            $refunds['user_id'] = $this->request->getAttribute('identity')->get('id');
            $refunds['shop_order_id'] = $p->id;
            $refunds['enable'] = 1;
            $refunds['status'] = 1;
            if ($this->Orderrefunds->save($refunds)) {
                $this->Flash->success(__('ثبت اطلاعات با موفقیت انجام شد'));
                return $this->redirect('/shop/profile/addresses');
            } else {
                $this->Flash->error(__('متاسفانه ثبت اطلاعات انجام نشد'));
            }
        }

        $this->set([
            'refunds' => $refunds,
        ]);
    }
    //-------------------------------------------------------------------------------
    private function notifications(){
    }
    //-------------------------------------------------------------------------------
    private function userhistory(){
    }
    //-------------------------------------------------------------------------------
    private function personalinfo(){
    }
    //-------------------------------------------------------------------------------



}