<?php
namespace Challenge\Controller;

use Challenge\Controller\AppController;

/**
 * Challengecats Controller
 *
 * @property \Challenge\Model\Table\ChallengecatsTable $Challengecats
 *
 * @method \Challenge\Model\Entity\Challengecat[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ChallengecatsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $challengecats = $this->paginate($this->Challengecats);
        $this->set(compact('challengecats'));
    }

    /**
     * View method
     *
     * @param string|null $id Challengecat id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $challengecat = $this->Challengecats->get($id, [
            'contain' => ['Challenges'],
        ]);

        $this->set('challengecat', $challengecat);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $challengecat = $this->Challengecats->newEmptyEntity();
        if ($this->request->is('post')) {
            $challengecat = $this->Challengecats->patchEntity($challengecat, $this->request->getData());
            if ($this->Challengecats->save($challengecat)) {
                $this->Flash->success(__('The challengecat has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The challengecat could not be saved. Please, try again.'));
        }
        $challenges = $this->Challengecats->Challenges->find('list', ['limit' => 200]);
        $this->set(compact('challengecat', 'challenges'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Challengecat id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $challengecat = $this->Challengecats->get($id, [
            'contain' => ['Challenges'],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $challengecat = $this->Challengecats->patchEntity($challengecat, $this->request->getData());
            if ($this->Challengecats->save($challengecat)) {
                $this->Flash->success(__('The challengecat has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The challengecat could not be saved. Please, try again.'));
        }
        $challenges = $this->Challengecats->Challenges->find('list', ['limit' => 200]);
        $this->set(compact('challengecat', 'challenges'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Challengecat id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $challengecat = $this->Challengecats->get($id);
        if ($this->Challengecats->delete($challengecat)) {
            $this->Flash->success(__('The challengecat has been deleted.'));
        } else {
            $this->Flash->error(__('The challengecat could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
