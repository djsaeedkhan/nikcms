<?php
namespace Shop\Controller;

use Cake\ORM\TableRegistry;
//use Shop\Controller\AppController;
use App\Controller\AppController as BaseController;

class CustomersController extends AppController
{
    public function initialize(){
        parent::initialize();
        $this->ViewBuilder()->setLayout('Admin.default');
        $this->ShopAddresses = TableRegistry::get('Shop.ShopAddresses');
        $this->ShopUserAddresses = TableRegistry::get('Shop.ShopUseraddresses');
    }
    //-----------------------------------------------------------
    public function index2(){
    }
    //-----------------------------------------------------------
    public function index(){
        $data = $this->ShopUserAddresses->find('all')
            ->contain(['Users'=>['ShopOrders']])
            ->order(['ShopUseraddresses.id'=>'desc']);
        if($this->request->getQuery('province')){
            $data->where(['ShopUseraddresses.billing_state' => $this->request->getQuery('province') ]);
        }
        $results = $this->paginate($data);
        $this->set(compact('results'));
    }
    //-----------------------------------------------------------

    public function view($id = null){
        $shopAddress = $this->ShopUserAddresses->get($id, [
            'contain' => ['Users'=>['ShopOrders'=>['ShopAddresses']],],
        ]);
        /* $useaddr = [];
        if($shopAddress['user_id']){
            $useaddr = TableRegistry::get('Shop.ShopUseraddresses')
                ->find('all')
                ->where(['user_id' => $shopAddress['user_id']])
                ->toArray();
        } */
        $this->set([
            //'useaddr'=> $useaddr, 
            'result'=> $shopAddress]);
    }
    //-----------------------------------------------------------

    public function add($id = null)
    {
        if($id != null)
            $shopAddress = $this->ShopAddresses->get($id);
        else
            $shopAddress = $this->ShopAddresses->newEntity();

        if ($this->request->is(['patch', 'post', 'put'])) {
            $shopAddress = $this->ShopAddresses->patchEntity($shopAddress, $this->request->getData());
            if ($this->ShopAddresses->save($shopAddress)) {
                $this->Flash->success(__('The shop address has been saved.'));

                return $this->redirect(['action' =>'view', $shopAddress->id]);
            }
            $this->Flash->error(__('The shop address could not be saved. Please, try again.'));
        }
        $users = $this->ShopAddresses->Users->find('list', ['keyField'=>'id','valueField'=>'username']);
        $shopUseraddresses = $this->ShopAddresses->ShopUseraddresses->find('list', ['limit' => 200]);
        $this->set(compact('shopAddress', 'users', 'shopUseraddresses'));
    }
    //-----------------------------------------------------------

    public function delete($id = null){
        $this->request->allowMethod(['post', 'delete']);
        $shopAddress = $this->ShopAddresses->get($id);
        if ($this->ShopAddresses->delete($shopAddress)) {
            $this->Flash->success(__('The shop address has been deleted.'));
        } else {
            $this->Flash->error(__('The shop address could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}