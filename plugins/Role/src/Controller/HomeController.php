<?php
namespace Role\Controller;
use Role\Controller\AppController;
use Cake\ORM\TableRegistry;
class HomeController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->viewBuilder()->setLayout('Admin.default');
    }
    
    public function index(){
        $this->Role = $this->getTableLocator()->get('Role.Roles');
        $result = $this->Role->find('all')->order(['id'=>'desc']);
        $this->set('result', $result);
    }

    public function add($id = null){
        $this->Role = $this->getTableLocator()->get('Role.Roles');
        $roles = $this->Role->newEmptyEntity();
        $result= [];
        if($id != null){
            $roles = $this->Role->find('all')->where(['id' => $id])->order(['id'=>'desc'])->first();
            $roles['data'] = unserialize($roles['data']);
            $this->set([
                'result' =>$result,
                'roles' => $roles
            ]);
        }
        else{
            $this->set([
                //'result' =>$result,
                'roles' => $roles
            ]);
        }

        if ($this->request->is(['patch', 'post', 'put'])) {

            $role = \Admin\View\Helper\ModuleHelper::options_role();
            $role_list = [];
            foreach ($role as $datas):
                $plugin = strtolower($datas['plugin']);
                if(isset($datas['role']) and count($datas['role'])):
                    foreach($datas['role'] as $controller => $data): 
                        $controller = strtolower($controller);
                        foreach( $data['action'] as $action => $name):
                            $action = strtolower($action);

                            if(($this->request->getData()['data'][$plugin][$controller])){
                                $index = array_search($action , $this->request->getData()['data'][$plugin][$controller] );

                                if($this->request->getData()['data'][$plugin][$controller][$index] and
                                    $this->request->getData()['data'][$plugin][$controller][$index] == $action)
                                    $role_list[$plugin] [$controller] [$action] = $action;
                                else
                                    $role_list[$plugin] [$controller] [$action] = 0;
                            }
                            else
                                $role_list[$plugin] [$controller] [$action] = 0;
                                
                        endforeach;
                    endforeach;
                endif;
            endforeach;

            $this->request = $this->request->withData('data', serialize($role_list));
            $roles = $this->Role->patchEntity($roles, $this->request->getData());
            if ($this->Role->save($roles)) {
                $this->Flash->success(__d('Role','The role has been saved.'));
                return $this->redirect(['action'=> 'index']);
            }
            $this->Flash->error(__d('Role','The role could not be saved. Please, try again.'));
        }
    }

    public function delete($id = null){
        $this->request->allowMethod(['post', 'delete']);
        $this->Role = $this->getTableLocator()->get('Role.Roles');

        $count = $this->getTableLocator()->get('Admin.Users')
            ->find("all")
            ->where([ 'Users.role_id'=> $id ])
            ->count();
        if($count){
            $this->Flash->error(__d('Role','The role could not be deleted. some user use it'));
            return $this->redirect($this->referer());
        }

        $roles = $this->Role->get($id);
        if ($this->Role->delete($roles)) {
            $this->Flash->success(__d('Role','The role has been deleted.'));
        } else {
            $this->Flash->error(__d('Role','The role could not be deleted. Please, try again.'));
        }
        return $this->redirect($this->referer());
    }
}