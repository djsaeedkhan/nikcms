<?php
declare(strict_types=1);

namespace Challenge\Controller;

use Challenge\Controller\AppController;

/**
 * Challengestatuses Controller
 *
 * @property \Challenge\Model\Table\ChallengestatusesTable $Challengestatuses
 * @method \Challenge\Model\Entity\Challengestatus[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ChallengestatusesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $challengestatuses = $this->paginate($this->Challengestatuses);

        $this->set(compact('challengestatuses'));
    }

    /**
     * View method
     *
     * @param string|null $id Challengestatus id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $challengestatus = $this->Challengestatuses->get($id, [
            'contain' => ['Challenges'],
        ]);

        $this->set(compact('challengestatus'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $challengestatus = $this->Challengestatuses->newEmptyEntity();
        if ($this->request->is('post')) {
            $challengestatus = $this->Challengestatuses->patchEntity($challengestatus, $this->request->getData());
            if ($this->Challengestatuses->save($challengestatus)) {
                $this->Flash->success(__('The challengestatus has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The challengestatus could not be saved. Please, try again.'));
        }
        $this->set(compact('challengestatus'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Challengestatus id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $challengestatus = $this->Challengestatuses->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $challengestatus = $this->Challengestatuses->patchEntity($challengestatus, $this->request->getData());
            if ($this->Challengestatuses->save($challengestatus)) {
                $this->Flash->success(__('The challengestatus has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The challengestatus could not be saved. Please, try again.'));
        }
        $this->set(compact('challengestatus'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Challengestatus id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $challengestatus = $this->Challengestatuses->get($id);
        if ($this->Challengestatuses->delete($challengestatus)) {
            $this->Flash->success(__('The challengestatus has been deleted.'));
        } else {
            $this->Flash->error(__('The challengestatus could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
