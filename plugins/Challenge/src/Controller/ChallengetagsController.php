<?php
namespace Challenge\Controller;

use Challenge\Controller\AppController;

/**
 * Challengetags Controller
 *
 * @property \Challenge\Model\Table\ChallengetagsTable $Challengetags
 *
 * @method \Challenge\Model\Entity\Challengetag[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ChallengetagsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $challengetags = $this->paginate($this->Challengetags);

        $this->set(compact('challengetags'));
    }

    /**
     * View method
     *
     * @param string|null $id Challengetag id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $challengetag = $this->Challengetags->get($id, [
            'contain' => ['Challenges'],
        ]);

        $this->set('challengetag', $challengetag);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $challengetag = $this->Challengetags->newEmptyEntity();
        if ($this->request->is('post')) {
            $challengetag = $this->Challengetags->patchEntity($challengetag, $this->request->getData());
            if ($this->Challengetags->save($challengetag)) {
                $this->Flash->success(__('The challengetag has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The challengetag could not be saved. Please, try again.'));
        }
        $challenges = $this->Challengetags->Challenges->find('list', ['limit' => 200]);
        $this->set(compact('challengetag', 'challenges'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Challengetag id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $challengetag = $this->Challengetags->get($id, [
            'contain' => ['Challenges'],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $challengetag = $this->Challengetags->patchEntity($challengetag, $this->request->getData());
            if ($this->Challengetags->save($challengetag)) {
                $this->Flash->success(__('The challengetag has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The challengetag could not be saved. Please, try again.'));
        }
        $challenges = $this->Challengetags->Challenges->find('list', ['limit' => 200]);
        $this->set(compact('challengetag', 'challenges'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Challengetag id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $challengetag = $this->Challengetags->get($id);
        if ($this->Challengetags->delete($challengetag)) {
            $this->Flash->success(__('The challengetag has been deleted.'));
        } else {
            $this->Flash->error(__('The challengetag could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
