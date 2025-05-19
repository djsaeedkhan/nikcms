<?php
namespace Challenge\Controller;

use Challenge\Controller\AppController;

class ChallengepartnersController extends AppController
{
    public function add($id = null){
        $challengepartner = $this->Challengepartners->newEntity();
        if ($this->request->is('post')) {
            $this->request = $this->request->withData('challenge_id',$id );
            $challengepartner = $this->Challengepartners->patchEntity($challengepartner, $this->request->getData());
            if ($this->Challengepartners->save($challengepartner)) {
                $this->Flash->success(__('The challengepartner has been saved.'));

                return $this->redirect(['controller'=>'Admin','action' => 'view',$id]);
            }
            $this->Flash->error(__('The challengepartner could not be saved. Please, try again.'));
        }
        $challenges = $this->Challengepartners->Challenges->find('list', ['limit' => 200]);
        $this->set(compact('challengepartner', 'challenges'));
    }

    public function edit($id = null)
    {
        $challengepartner = $this->Challengepartners->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $challengepartner = $this->Challengepartners->patchEntity($challengepartner, $this->request->getData());
            if ($this->Challengepartners->save($challengepartner)) {
                $this->Flash->success(__('The challengepartner has been saved.'));

                return $this->redirect(['controller'=>'Admin','action' => 'view',$challengepartner['challenge_id']]);
            }
            $this->Flash->error(__('The challengepartner could not be saved. Please, try again.'));
        }
        $challenges = $this->Challengepartners->Challenges->find('list', ['limit' => 200]);
        $this->set(compact('challengepartner', 'challenges'));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $challengepartner = $this->Challengepartners->get($id);
        if ($this->Challengepartners->delete($challengepartner)) {
            $this->Flash->success(__('The challengepartner has been deleted.'));
        } else {
            $this->Flash->error(__('The challengepartner could not be deleted. Please, try again.'));
        }

        return $this->redirect(['controller'=>'Admin','action' => 'view',$challengepartner['challenge_id']]);
    }
}
