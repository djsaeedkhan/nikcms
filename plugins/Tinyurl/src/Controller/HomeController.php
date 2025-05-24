<?php
namespace Tinyurl\Controller;

use Tinyurl\Controller\AppController;
use Cake\ORM\TableRegistry;
class HomeController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $this->loadModel('Tinyurl.Tinyurls');
        $this->viewBuilder()->setLayout('Admin.default');
    }
    
    public function index($id = null)
    {
        $results = $this->paginate(
            $this->Tinyurls->find('all')
            ->order(['id'=>'desc']));
        $this->set(compact('results'));
    }
    public function add($id = null){
        if($id != null) $result = $this->Tinyurls->get($id);
        else $result = $this->Tinyurls->newEntity();

        if ($this->request->is(['patch', 'post', 'put'])) {
            $result = $this->Tinyurls->patchEntity($result, $this->request->getData());
            if ($this->Tinyurls->save($result)) {
                $this->Flash->success(__d('Tinyurl','لینک با موفقیت ثبت شد'));
                return $this->redirect(['action'=>'index']);
            }
            $this->Flash->error(__d('Tinyurl','متاسفانه لینک با موفقیت ثبت نشد'));
        }
        $this->set([
            'result' => $result,
            'action' => $id,
            ]);
    }
    public function delete($id = null){
        $this->request->allowMethod(['post', 'delete']);
        $data = $this->Tinyurls->get($id);
        if ($this->Tinyurls->delete($data)) {
            $this->Flash->success(__d('Tinyurl','لینک با موفقیت حذف شد'));
        }
        else
            $this->Flash->error(__d('Tinyurl','متاسفانه لینک حذف نشد'));
        return $this->redirect($this->referer());
    }
}