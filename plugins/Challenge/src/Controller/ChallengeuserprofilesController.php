<?php
namespace Challenge\Controller;

use Challenge\Controller\AppController;

/**
 * Challengeuserprofiles Controller
 *
 * @property \Challenge\Model\Table\ChallengeuserprofilesTable $Challengeuserprofiles
 *
 * @method \Challenge\Model\Entity\Challengeuserprofile[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ChallengeuserprofilesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $challengeuserprofiles = $this->paginate(
            $this->Challengeuserprofiles->find('all')
                ->contain(['Users'])
        );

        $this->set(compact('challengeuserprofiles'));
    }

    /**
     * View method
     *
     * @param string|null $id Challengeuserprofile id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $challengeuserprofile = $this->Challengeuserprofiles->get($id, [
            'contain' => ['Users', 'Challengetopics'],
        ]);

        $this->set('challengeuserprofile', $challengeuserprofile);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $challengeuserprofile = $this->Challengeuserprofiles->newEmptyEntity();
        if ($this->request->is('post')) {
            $challengeuserprofile = $this->Challengeuserprofiles->patchEntity($challengeuserprofile, $this->request->getData());
            if ($this->Challengeuserprofiles->save($challengeuserprofile)) {
                $this->Flash->success(__('The challengeuserprofile has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The challengeuserprofile could not be saved. Please, try again.'));
        }
        $users = $this->Challengeuserprofiles->Users->find('list', ['limit' => 200]);
        $challengetopics = $this->Challengeuserprofiles->Challengetopics->find('list', ['limit' => 200]);
        $this->set(compact('challengeuserprofile', 'users', 'challengetopics'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Challengeuserprofile id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $challengeuserprofile = $this->Challengeuserprofiles->get($id, [
            'contain' => ['Challengetopics'],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $challengeuserprofile = $this->Challengeuserprofiles->patchEntity($challengeuserprofile, $this->request->getData());
            if ($this->Challengeuserprofiles->save($challengeuserprofile)) {
                $this->Flash->success(__('The challengeuserprofile has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The challengeuserprofile could not be saved. Please, try again.'));
        }
        $users = $this->Challengeuserprofiles->Users->find('list', ['limit' => 200]);
        $challengetopics = $this->Challengeuserprofiles->Challengetopics->find('list', ['limit' => 200]);
        $this->set(compact('challengeuserprofile', 'users', 'challengetopics'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Challengeuserprofile id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $challengeuserprofile = $this->Challengeuserprofiles->get($id);
        if ($this->Challengeuserprofiles->delete($challengeuserprofile)) {
            $this->Flash->success(__('The challengeuserprofile has been deleted.'));
        } else {
            $this->Flash->error(__('The challengeuserprofile could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
