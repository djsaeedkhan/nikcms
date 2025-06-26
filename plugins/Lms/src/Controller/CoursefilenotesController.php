<?php
namespace Lms\Controller;
use Lms\Controller\AppController;

class CoursefilenotesController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
    }
    
    public function index()
    {
        /* $this->paginate = [
            'contain' => ['LmsCoursefiles'],
        ]; */
        $lmsCoursefilenotes = $this->paginate(
            $this->LmsCoursefilenotes->find('all')->contain(['LmsCoursefiles'])
        );

        $this->set(compact('lmsCoursefilenotes'));
    }

    public function view($id = null)
    {
        $lmsCoursefilenote = $this->LmsCoursefilenotes->get($id, [
            'contain' => ['LmsCoursefiles'],
        ]);

        $this->set('lmsCoursefilenote', $lmsCoursefilenote);
    }

    public function add($id = null)
    {
        $lmsCoursefilenote = $this->LmsCoursefilenotes->newEmptyEntity();
        if ($this->request->is('post')) {
            if($id != null)
                $this->request = $this->request->withData('lms_coursefile_id', $id );

            $lmsCoursefilenote = $this->LmsCoursefilenotes->patchEntity($lmsCoursefilenote, $this->request->getData());
            if ($this->LmsCoursefilenotes->save($lmsCoursefilenote)) {
                $this->Flash->success(__('The lms coursefilenote has been saved.'));

                if( isset($this->request->getQuery()['nonav']) and $this->request->getQuery()['nonav'] == 1)
                    echo '<script nonce="'.get_nonce.'">parent.location.reload();</script>';
                else
                    return $this->redirect(['action' => 'index']);
            }
            else
            $this->Flash->error(__('The lms coursefilenote could not be saved. Please, try again.'));
        }
        $lmsCoursefiles = $this->LmsCoursefilenotes->LmsCoursefiles->find('list');
        $this->set(compact('lmsCoursefilenote', 'lmsCoursefiles','id'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Lms Coursefilenote id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $lmsCoursefilenote = $this->LmsCoursefilenotes->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $lmsCoursefilenote = $this->LmsCoursefilenotes->patchEntity($lmsCoursefilenote, $this->request->getData());
            if ($this->LmsCoursefilenotes->save($lmsCoursefilenote)) {
                $this->Flash->success(__('The lms coursefilenote has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The lms coursefilenote could not be saved. Please, try again.'));
        }
        $lmsCoursefiles = $this->LmsCoursefilenotes->LmsCoursefiles->find('list');
        $this->set(compact('lmsCoursefilenote', 'lmsCoursefiles'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Lms Coursefilenote id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $lmsCoursefilenote = $this->LmsCoursefilenotes->get($id);
        if ($this->LmsCoursefilenotes->delete($lmsCoursefilenote)) {
            $this->Flash->success(__('The lms coursefilenote has been deleted.'));
        } else {
            $this->Flash->error(__('The lms coursefilenote could not be deleted. Please, try again.'));
        }

        return $this->redirect($this->referer());
    }
}
