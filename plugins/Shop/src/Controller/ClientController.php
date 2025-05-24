<?php
namespace Shop\Controller;
use Cake\Core\Configure;
use Shop\Controller\AppController;
use Cake\ORM\TableRegistry;
class ClientController extends AppController
{
    public function initialize(){
        parent::initialize();
        $this->viewBuilder()->setLayout('Admin.default');
    }
    //-----------------------------------------------------------
    public function index(){
    }
    //-----------------------------------------------------------
    public function search(){
    }
    //-----------------------------------------------------------
    public function orders(){
        $results = $this->paginate($this->getTableLocator()->get('Shop.ShopOrders'),[
            'where'=>['user_id'=>$this->request->getAttribute('identity')->get('id')],
            'order'=>['id'=>'desc'],
            'contain'=>['ShopOrderproducts']
        ]);
        $this->set(compact('results'));
    }
    //-----------------------------------------------------------
    
}