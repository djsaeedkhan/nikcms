<?php
namespace Shop\Controller;

use Shop\Controller\AppController;
use Cake\ORM\TableRegistry;

/**
 * ShopLogesticusers Controller
 *
 * @property \Shop\Model\Table\ShopLogesticusersTable $ShopLogesticusers
 *
 * @method \Shop\Model\Entity\ShopLogesticuser[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class LogesticusersController extends AppController
{
    public function initialize(){
        parent::initialize();
        $this->ViewBuilder()->setLayout('Admin.default');
        $this->ShopLogesticusers = TableRegistry::getTableLocator()->get('Shop.ShopLogesticusers');
    }

    public function index($id = null)
    {
        if($id == null){
            $this->Flash->error(__('واحد نمایندگی پیدا نشد'));
            return $this->redirect($this->referer()); 
        }

        $this->paginate = [
            'contain' => ['ShopLogestics', 'Users'],
            'conditions'=>['shop_logestic_id'=> $id]
        ];
        $shopLogesticusers = $this->paginate($this->ShopLogesticusers);

        $this->set(compact('shopLogesticusers','id'));
    }

    
    public function add($id = null)
    {
        if($id ==  null){
            $this->Flash->error(__('واحد نمایندگی پیدا نشد'));
            return $this->redirect($this->referer()); 
        }
        $shopLogesticuser = $this->ShopLogesticusers->newEntity();
            
        if ($this->request->is('post')) {
            
            $this->request = $this->request->withData('shop_logestic_id', $id);
            $shopLogesticuser = $this->ShopLogesticusers->patchEntity($shopLogesticuser, $this->request->getData());
            if ($this->ShopLogesticusers->save($shopLogesticuser)) {
                $this->Flash->success(__('The shop logesticuser has been saved.'));
                return $this->redirect(['action' => 'index',$id]);
            }
            $this->Flash->error(__('متاسفانه ثبت اطلاعات انجام نشد'));
        }
        $users = $this->ShopLogesticusers->Users->find('list', ['keyField'=>'id','valueField'=>'username']);
        $this->set(compact('shopLogesticuser', 'users'));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $shopLogesticuser = $this->ShopLogesticusers->get($id);
        if ($this->ShopLogesticusers->delete($shopLogesticuser)) {
            $this->Flash->success(__('The shop logesticuser has been deleted.'));
        } else {
            $this->Flash->error(__('The shop logesticuser could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index', $shopLogesticuser['shop_logestic_id']]);
    }
}
