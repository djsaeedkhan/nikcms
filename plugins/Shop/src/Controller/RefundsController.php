<?php
namespace Shop\Controller;

use Admin\View\Helper\ModuleHelper;
use Cake\Core\Configure;
use Shop\Controller\AppController;
use Cake\ORM\TableRegistry;
use Shop\View\Helper\CartHelper;

class RefundsController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->viewBuilder()->setLayout('Admin.default');
    }
    //-----------------------------------------------------------
    public function index($id = null){
        $data = $this->getTableLocator()->get('Shop.ShopOrderrefunds')->find('all')
            ->order(['ShopOrderrefunds.id'=>'desc'])
            ->contain(['shopOrders','Users']);
        
        if($this->request->getQuery('status')){
            $data->where(['status' => $this->request->getQuery('status') ]);
        }
        $results = $this->paginate($data);
        $this->set(compact('results'));
    }
    //-----------------------------------------------------------
    public function edit($id = null){
        $this->Refunds = $this->getTableLocator()->get('Shop.ShopOrderrefunds');
        if($id != null)
            $refund = $this->Refunds->get($id);
        else
            $refund = $this->Refunds->newEntity();

        if ($this->request->is(['patch', 'post', 'put'])) {
            $refund = $this->Refunds->patchEntity($refund, $this->request->getData());
            if ($this->Refunds->save($refund)) {
                TableRegistry::getTableLocator()->get('Shop.ShopOrderlogs')->save(
                    TableRegistry::getTableLocator()->get('Shop.ShopOrderlogs')->newEntity([
                    'shop_order_id' => $refund->shop_order_id,
                    'user_id'=> $this->request->getAttribute('identity')->get('id'),
                    'status'=>'مرجوعی - تغییر وضعیت به "'. CartHelper::Predata('order_refundtype',$this->request->getData()['status']).'"'
                ]));

                $this->Flash->success(__('The shop address has been saved.'));
                return $this->redirect($this->referer());
            }
            $this->Flash->error(__('The shop address could not be saved. Please, try again.'));
        }
        $this->set(compact('refund'));
    }
    //-----------------------------------------------------------
}