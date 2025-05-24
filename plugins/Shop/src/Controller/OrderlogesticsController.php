<?php
namespace Shop\Controller;

use Shop\Controller\AppController;
use Cake\ORM\TableRegistry;

/**
 * ShopOrderlogestics Controller
 *
 * @property \Shop\Model\Table\ShopOrderlogesticsTable $ShopOrderlogestics
 *
 * @method \Shop\Model\Entity\ShopOrderlogestic[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class OrderlogesticsController extends AppController
{
    public function initialize(){
        parent::initialize();
        $this->viewBuilder()->setLayout('Admin.default');
        $this->ShopOrderlogestics = TableRegistry::getTableLocator()->get('Shop.ShopOrderlogestics');
    }

    public function index($id = null)
    {
        $logestic = null;
        if($id != null){
            $logestic = TableRegistry::getTableLocator()->get('Shop.ShopLogestics')->find('all')->where(['id' => $id])->first();
        }
        $this->paginate = [
            'contain' => ['ShopOrders', 'ShopOrderproducts', 'ShopLogestics', 'Users'],
            'conditions'=>[$id != null ?['shop_logestic_id'=> $id]:[]],
            'order'=>['ShopOrderlogestics.id'=>'desc']
        ];
        $shopOrderlogestics = $this->paginate($this->ShopOrderlogestics);

        $this->set(compact('shopOrderlogestics','logestic'));
    }

    public function view($id = null)
    {
        $shopOrderlogestic = $this->ShopOrderlogestics->get($id, [
            'contain' => [
                'ShopOrders', 'ShopOrderproducts', 'ShopLogestics', 'Users', 
                'ShopOrderlogesticlogs'=> function ($q) {
                    return $q
                        ->contain('Users')
                        ->order(['ShopOrderlogesticlogs.id'=>'desc']);
                }
                ],
        ]);

        $this->set('shopOrderlogestic', $shopOrderlogestic);
    }

    
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $shopOrderlogestic = $this->ShopOrderlogestics->get($id);
        if ($this->ShopOrderlogestics->delete($shopOrderlogestic)) {
            $this->Flash->success(__('The shop orderlogestic has been deleted.'));
        } else {
            $this->Flash->error(__('The shop orderlogestic could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
