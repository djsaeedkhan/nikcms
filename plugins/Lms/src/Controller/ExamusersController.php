<?php
namespace Lms\Controller;
use Lms\Controller\AppController;

class ExamusersController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
    }
    
    public function index()
    {
        /* $this->paginate = [
            'contain' => ['Users', 'LmsExams'],
        ]; */
        $lmsExamusers = $this->paginate(
            $this->LmsExamusers->find('all')
                ->contain(['Users', 'LmsExams'])
        );

        $this->set(compact('lmsExamusers'));
    }

    public function view($id = null)
    {
        $lmsExamuser = $this->LmsExamusers->get($id, [
            'contain' => ['Users', 'LmsExams'],
        ]);

        $this->set('lmsExamuser', $lmsExamuser);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $lmsExamuser = $this->LmsExamusers->newEmptyEntity();
        if ($this->request->is('post')) {
            $lmsExamuser = $this->LmsExamusers->patchEntity($lmsExamuser, $this->request->getData());
            if ($this->LmsExamusers->save($lmsExamuser)) {
                $this->Flash->success(__('The lms examuser has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The lms examuser could not be saved. Please, try again.'));
        }
        $users = $this->LmsExamusers->Users->find('list');
        $lmsExams = $this->LmsExamusers->LmsExams->find('list');
        $this->set(compact('lmsExamuser', 'users', 'lmsExams'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Lms Examuser id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $lmsExamuser = $this->LmsExamusers->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $lmsExamuser = $this->LmsExamusers->patchEntity($lmsExamuser, $this->request->getData());
            if ($this->LmsExamusers->save($lmsExamuser)) {
                $this->Flash->success(__('The lms examuser has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The lms examuser could not be saved. Please, try again.'));
        }
        $users = $this->LmsExamusers->Users->find('list');
        $lmsExams = $this->LmsExamusers->LmsExams->find('list');
        $this->set(compact('lmsExamuser', 'users', 'lmsExams'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Lms Examuser id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $lmsExamuser = $this->LmsExamusers->get($id);
        if ($this->LmsExamusers->delete($lmsExamuser)) {
            $this->Flash->success(__('The lms examuser has been deleted.'));
        } else {
            $this->Flash->error(__('The lms examuser could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
