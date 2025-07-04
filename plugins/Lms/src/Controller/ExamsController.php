<?php
namespace Lms\Controller;

use Cake\ORM\TableRegistry;
use Lms\Controller\AppController;

class ExamsController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
    }
    
    public function index()
    {
        /* $this->paginate = [
            'contain' => ['Users'],
            'order'=>['id'=>'desc']
        ]; */
        $lmsExams = $this->paginate(
            $this->LmsExams->find('all')
                ->contain(['Users'])
                ->order(['LmsExams.id'=>'desc'])
        );
        $this->set(compact('lmsExams'));
    }

    public function view($id = null)
    {
        $lmsExam = $this->LmsExams->get($id, [
            'contain' => [
                'Users', 
                'LmsExamquests'=>['sort' => ['LmsExamquests.priority'=>'ASC']], 
                'LmsExamresults', 
                'LmsExamusers'
            ],
        ]);
        $this->set('lmsExam', $lmsExam);
    }

    public function add($id = null)
    {
        if($id == null)
            $lmsExam = $this->LmsExams->newEmptyEntity();
        else
            $lmsExam = $this->LmsExams->get($id);

        if ($this->request->is(['patch', 'post', 'put'])) {
            if($this->request->is(['post'])) {
                $this->request = $this->request->withData('user_id', $this->request->getAttribute('identity')->get('id'));
            }

            if(isset($this->request->getData()['options'])){
                $this->request = $this->request->withData('options', 
                json_encode($this->request->getData()['options']));
            }

            $lmsExam = $this->LmsExams->patchEntity($lmsExam, $this->request->getData());

            if ($this->LmsExams->save($lmsExam)) {
                $this->Flash->success(__('The lms exam has been saved.'));

                return $this->redirect($this->referer());
            }
            $this->Flash->error(__('The lms exam could not be saved. Please, try again.'));
        }
        
        $users = $this->LmsExams->Users->find('list');
        $this->set(compact('lmsExam', 'users'));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $lmsExam = $this->LmsExams->get($id);
        if ($this->LmsExams->delete($lmsExam)) {
            TableRegistry::getTableLocator()->get('Lms.LmsExamusers')->deleteAll(['lms_exam_id' => $id ]);
            TableRegistry::getTableLocator()->get('Lms.LmsExamquests')->deleteAll(['lms_exam_id' => $id ]);
            TableRegistry::getTableLocator()->get('Lms.LmsExamresults')->deleteAll(['lms_exam_id' => $id ]);
            TableRegistry::getTableLocator()->get('Lms.LmsExamresultlists')->deleteAll(['lms_exam_id' => $id ]);
            $this->Flash->success(__('The lms exam has been deleted.'));
        } else {
            $this->Flash->error(__('The lms exam could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function duplicate($id = null){
        if($id == null) $this->redirect($this->referer());

        $exam = $this->LmsExams->find('all')
            ->where(['id'=>$id])
            ->contain(['LmsExamquests'=>['sort' => ['LmsExamquests.priority'=>'ASC']] ])
            ->enablehydration(false)
            ->first();
        unset( $exam['id'],$exam['created'] );
        $exam['user_id'] = $this->request->getAttribute('identity')->get('id');
        $exam['title'] = 'کپی شده >> '.$exam['title'];
        $temp = $this->LmsExams->newEmptyEntity();
        $temp = $this->LmsExams->patchEntity($temp, $exam);
        if ($this->LmsExams->save($temp)) {
            $this->Flash->success('کپی از آزمون با موفقیت انجام گردید. <br>لطفا قبل از استفاده، سوالات آزمون را بررسی کنید');
            $this->redirect(['action'=> 'view', $temp['id']]);
        }
    }
}