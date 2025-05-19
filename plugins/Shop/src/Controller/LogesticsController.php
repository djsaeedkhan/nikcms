<?php
namespace Shop\Controller;

use Shop\Controller\AppController;
use Cake\ORM\TableRegistry;

class LogesticsController extends AppController
{
    public function initialize(){
        parent::initialize();
        $this->ViewBuilder()->setLayout('Admin.default');
        $this->ShopLogestics = TableRegistry::getTableLocator()->get('Shop.ShopLogestics');
    }

    public function index()
    {
        $this->paginate = [
            'contain' => ['ShopLogesticlists'],
        ];
        $shopLogestics = $this->paginate($this->ShopLogestics);
        $this->set(compact('shopLogestics'));
    }

    public function view($id = null)
    {
        $shopLogestic = $this->ShopLogestics->get($id, [
            'contain' => ['ShopLogesticlists'],
        ]);
        $this->set('shopLogestic', $shopLogestic);
    }

    public function add($id = null)
    {
        if($id == null)
            $shopLogestic = $this->ShopLogestics->newEntity();
        else
            $shopLogestic = $this->ShopLogestics->get($id, [
                'contain' => [],
            ]);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $shopLogestic = $this->ShopLogestics->patchEntity($shopLogestic, $this->request->getData());
            if ($this->ShopLogestics->save($shopLogestic)) {
                $this->Flash->success(__('The shop logestic has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The shop logestic could not be saved. Please, try again.'));
        }
        $shopLogesticlists = $this->ShopLogestics->ShopLogesticlists->find('list', ['limit' => 200]);
        $this->set(compact('shopLogestic', 'shopLogesticlists'));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $shopLogestic = $this->ShopLogestics->get($id);
        if ($this->ShopLogestics->delete($shopLogestic)) {
            $this->Flash->success(__('The shop logestic has been deleted.'));
        } else {
            $this->Flash->error(__('The shop logestic could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
