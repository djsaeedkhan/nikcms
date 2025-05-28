<?php
namespace Shop\Controller;

use Shop\Controller\AppController;
use Cake\ORM\TableRegistry;

class LogesticlistsController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->viewBuilder()->setLayout('Admin.default');
        $this->ShopLogesticlists = TableRegistry::getTableLocator()->get('Shop.ShopLogesticlists');
    }
    
    public function index()
    {
        $shopLogesticlists = $this->paginate($this->ShopLogesticlists);
        $this->set(compact('shopLogesticlists'));
    }

    public function view($id = null)
    {
        $shopLogesticlist = $this->ShopLogesticlists->get($id, [
            'contain' => ['ShopLogestics'],
        ]);
        $this->set('shopLogesticlist', $shopLogesticlist);
    }

    public function add($id = null)
    {
        if($id == null)
            $shopLogesticlist = $this->ShopLogesticlists->newEmptyEntity(();
        else
            $shopLogesticlist = $this->ShopLogesticlists->get($id, [
                'contain' => [],
            ]);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $shopLogesticlist = $this->ShopLogesticlists->patchEntity($shopLogesticlist, $this->request->getData());
            if ($this->ShopLogesticlists->save($shopLogesticlist)) {
                $this->Flash->success(__('The shop logesticlist has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The shop logesticlist could not be saved. Please, try again.'));
        }
        $this->set(compact('shopLogesticlist'));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $shopLogesticlist = $this->ShopLogesticlists->get($id);
        if ($this->ShopLogesticlists->delete($shopLogesticlist)) {
            $this->Flash->success(__('The shop logesticlist has been deleted.'));
        } else {
            $this->Flash->error(__('The shop logesticlist could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
