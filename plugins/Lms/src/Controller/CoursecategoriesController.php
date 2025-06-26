<?php
namespace Lms\Controller;

use Lms\Controller\AppController;

class CoursecategoriesController extends AppController
{
    public function index()
    {
        $lmsCoursecategories = $this->paginate($this->LmsCoursecategories);

        $this->set(compact('lmsCoursecategories'));
    }

    /**
     * View method
     *
     * @param string|null $id Lms Coursecategory id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $lmsCoursecategory = $this->LmsCoursecategories->get($id, [
            'contain' => [],
        ]);

        $this->set('lmsCoursecategory', $lmsCoursecategory);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add($id = null)
    {
        if( $id == null)
            $lmsCoursecategory = $this->LmsCoursecategories->newEmptyEntity();
        else
            $lmsCoursecategory = $this->LmsCoursecategories->get($id, [
                'contain' => [],
            ]);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $lmsCoursecategory = $this->LmsCoursecategories->patchEntity($lmsCoursecategory, $this->request->getData());
            if ($this->LmsCoursecategories->save($lmsCoursecategory)) {
                $this->Flash->success(__('The lms coursecategory has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The lms coursecategory could not be saved. Please, try again.'));
        }
        $this->set(compact('lmsCoursecategory'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Lms Coursecategory id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            $lmsCoursecategory = $this->LmsCoursecategories->patchEntity($lmsCoursecategory, $this->request->getData());
            if ($this->LmsCoursecategories->save($lmsCoursecategory)) {
                $this->Flash->success(__('The lms coursecategory has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The lms coursecategory could not be saved. Please, try again.'));
        }
        $this->set(compact('lmsCoursecategory'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Lms Coursecategory id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $lmsCoursecategory = $this->LmsCoursecategories->get($id);
        if ($this->LmsCoursecategories->delete($lmsCoursecategory)) {
            $this->Flash->success(__('The lms coursecategory has been deleted.'));
        } else {
            $this->Flash->error(__('The lms coursecategory could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
