<?php
namespace Userslogs\Controller;

use Cake\ORM\TableRegistry;
use Userslogs\Controller\AppController;
class HomeController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->viewBuilder()->setLayout('Admin.default');
        //$this->loadModel('UsersLogs.UsersLogs');
        //$this->loadModel('UsersLogs.Users');
    }
    public function index($user_id = null, $limit = 15){
       
        if($user_id == null or $this->request->getAttribute('identity')->get('role_id')!= 1){
            $user_id = $this->request->getAttribute('identity')->get('id');
        }
        if($this->request->getQuery('last')){
            $user_id = null;
        }

        $table = TableRegistry::getTableLocator()->get('Userslogs.UsersLogs')->find('all')
                ->where([ $user_id != null? ['user_id' => $user_id] : false ])
                ->contain(['Users'])
                ->order(['UsersLogs.id'=>'desc']);
        $results = $this->paginate($table);
        
        $this->set(compact('results'));
        $this->set([
            'user' => $user_id!= null?
                TableRegistry::getTableLocator()->get('Userslogs.Users')->get($user_id) : false
        ]);
    }
}