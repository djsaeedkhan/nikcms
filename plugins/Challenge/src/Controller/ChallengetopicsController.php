<?php
namespace Challenge\Controller;

use Challenge\Controller\AppController;

/**
 * Challengetopics Controller
 *
 * @property \Challenge\Model\Table\ChallengetopicsTable $Challengetopics
 *
 * @method \Challenge\Model\Entity\Challengetopic[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ChallengetopicsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $challengetopics = $this->paginate($this->Challengetopics);

        $this->set(compact('challengetopics'));
    }

    public function add()
    {
        $challengetopic = $this->Challengetopics->newEmptyEntity(();
        if ($this->request->is('post')) {
            $challengetopic = $this->Challengetopics->patchEntity($challengetopic, $this->request->getData());
            if ($this->Challengetopics->save($challengetopic)) {
                $this->Flash->success(__('The challengetopic has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The challengetopic could not be saved. Please, try again.'));
        }
        $challenges = $this->Challengetopics->Challenges->find('list', ['limit' => 200]);
        $this->set(compact('challengetopic', 'challenges'));
    }

    public function edit($id = null)
    {
        $challengetopic = $this->Challengetopics->get($id, [
            'contain' => ['Challenges'],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $challengetopic = $this->Challengetopics->patchEntity($challengetopic, $this->request->getData());
            if ($this->Challengetopics->save($challengetopic)) {
                $this->Flash->success(__('The challengetopic has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The challengetopic could not be saved. Please, try again.'));
        }
        $challenges = $this->Challengetopics->Challenges->find('list', ['limit' => 200]);
        $this->set(compact('challengetopic', 'challenges'));
        $this->render('add');
    }

    /**
     * Delete method
     *
     * @param string|null $id Challengetopic id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $challengetopic = $this->Challengetopics->get($id);
        if ($this->Challengetopics->delete($challengetopic)) {
            $this->Flash->success(__('The challengetopic has been deleted.'));
        } else {
            $this->Flash->error(__('The challengetopic could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
