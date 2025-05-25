<?php
namespace Seo\Controller;

use Seo\Controller\AppController;
use Cake\ORM\TableRegistry;
class HomeController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->viewBuilder()->setLayout('Admin.default');
    }
   
    public function google($id = null)
    {

    }
    public function index($id = null)
    {
        $result = $this->Func->OptionGet('seo_plugin');
        $this->set('result', $result);
    }

    public function add($id = null){
        if($id != null) $result = $this->Tinyurls->get($id);
        else $result = $this->Tinyurls->newEntity();

        if ($this->request->is(['patch', 'post', 'put'])) {
            $result = $this->Tinyurls->patchEntity($result, $this->request->getData());
            if ($this->Tinyurls->save($result)) {
                $this->Flash->success(__d('Seo','The Seo has been saved.'));
                return $this->redirect(['action'=>'index']);
            }
            $this->Flash->error(__d('Seo','The Seo could not be saved. Please, try again.'));
        }
        $this->set([
            'result' => $result,
            'action' => $id,
            ]);
    }
    public function delete($id = null){
        $this->request->allowMethod(['post', 'delete']);
        $data = $this->Tinyurls->get($delete);
        if ($this->Tinyurls->delete($data)) {
            $this->Flash->success(__d('Seo','The Seo has been deleted.'));
        }
        else
            $this->Flash->error(__d('Seo','The Seo could not be deleted. Please, try again.'));
        return $this->redirect($this->referer());
    }
}