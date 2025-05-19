<?php
namespace Challenge\Controller;

use Challenge\Controller\AppController;


class ChallengefieldsController extends AppController
{

    public function index()
    {
        $challengefields = $this->paginate($this->Challengefields);

        $this->set(compact('challengefields'));
    }

    public function add()
    {
        $challengefield = $this->Challengefields->newEntity();
        if ($this->request->is('post')) {
            $challengefield = $this->Challengefields->patchEntity($challengefield, $this->request->getData());
            if ($this->Challengefields->save($challengefield)) {
                $this->Flash->success(__('The challengefield has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The challengefield could not be saved. Please, try again.'));
        }
        $this->set(compact('challengefield'));
    }

    public function edit($id = null)
    {
        $challengefield = $this->Challengefields->get($id, [
            'contain' => ['Challenges'],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $challengefield = $this->Challengefields->patchEntity($challengefield, $this->request->getData());
            if ($this->Challengefields->save($challengefield)) {
                $this->Flash->success(__('The challengefield has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The challengefield could not be saved. Please, try again.'));
        }
        
        $this->set(compact('challengefield'));
        $this->render('add');
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $challengefield = $this->Challengefields->get($id);
        if ($this->Challengefields->delete($challengefield)) {
            $this->Flash->success(__('The challengefield has been deleted.'));
        } else {
            $this->Flash->error(__('The challengefield could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
