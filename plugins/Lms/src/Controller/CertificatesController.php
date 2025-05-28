<?php
namespace Lms\Controller;

use Cake\ORM\TableRegistry;
use Lms\Controller\AppController;


class CertificatesController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->LmsCertificates = TableRegistry::getTableLocator()->get('Lms.LmsCertificates');
    }
    public function index()
    {
        $this->paginate = [
            'contain' => ['Users', 'LmsCourses'],
        ];
        $lmsCertificates = $this->paginate($this->LmsCertificates);

        $this->set(compact('lmsCertificates'));
    }

    public function view($id = null){
        $lmsCertificate = $this->LmsCertificates->get($id, [
            'contain' => ['Users', 'LmsCourses'],
            'order'=>['LmsCertificates.id'=>'desc']
        ]);
        $this->set('lmsCertificate', $lmsCertificate);
    }

    public function add($id = null){

        if($id != null){
            $lmsCertificate = $this->LmsCertificates->get($id, [
                'contain' => [],
            ]);
        }else{
            $lmsCertificate = $this->LmsCertificates->newEmptyEntity(();
        }
        if ($this->request->is(['patch', 'post', 'put'])) {
            $lmsCertificate = $this->LmsCertificates->patchEntity($lmsCertificate, $this->request->getData());
            if ($this->LmsCertificates->save($lmsCertificate)) {
                $this->Flash->success(__('The lms certificate has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The lms certificate could not be saved. Please, try again.'));
        }
        $users = $this->LmsCertificates->Users->find('list');
        $lmsCourses = $this->LmsCertificates->LmsCourses->find('list');
        $this->set(compact('lmsCertificate', 'users', 'lmsCourses'));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $lmsCertificate = $this->LmsCertificates->get($id);
        if ($this->LmsCertificates->delete($lmsCertificate)) {
            $this->Flash->success(__('The lms certificate has been deleted.'));
        } else {
            $this->Flash->error(__('The lms certificate could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
