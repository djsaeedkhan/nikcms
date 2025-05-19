<?php
namespace Lms\Controller;
use Lms\Controller\AppController;

class CourseexamsController extends AppController
{
    public function initialize(){
        parent::initialize();
    }
    
    /* public function index()
    {
        $this->paginate = [
            'contain' => ['LmsCoursefiles', 'LmsExams'],
        ];
        $lmsCourseexams = $this->paginate($this->LmsCourseexams);

        $this->set(compact('lmsCourseexams'));
    } */

    public function add($id = null)
    {
        $lmsCourseexam = $this->LmsCourseexams->newEntity();
        if ($this->request->is('post')) {
            if($id != null){
                $this->request = $this->request->withData('lms_coursefile_id', $id );

                $course_id = $this->LmsCoursefiles->find('all')->where(['id'=>$id])->first()['lms_course_id'];
                $this->request = $this->request->withData('lms_course_id', $course_id );
            }

            $lmsCourseexam = $this->LmsCourseexams->patchEntity($lmsCourseexam, $this->request->getData());
            if ($this->LmsCourseexams->save($lmsCourseexam)) {
                $this->Flash->success(__('The lms courseexam has been saved.'));

                if( isset($this->request->getQuery()['nonav']) and $this->request->getQuery()['nonav'] == 1)
                    echo '<script nonce="'.get_nonce.'">parent.location.reload();</script>';
                else
                    return $this->redirect($this->referer());
            }
            else 
            $this->Flash->error(__('The lms courseexam could not be saved. Please, try again.'));
        }
        $lmsCoursefiles = $this->LmsCourseexams->LmsCoursefiles->find('list');
        $lmsExams = $this->LmsCourseexams->LmsExams->find('list');
        $this->set(compact('lmsCourseexam', 'lmsCoursefiles', 'lmsExams','id'));
    }

    
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        if($this->LmsCourseexams->deleteAll(['lms_coursefile_id' => $id ])){
        /* $lmsCourseexam = $this->LmsCourseexams->get($id);
        if ($this->LmsCourseexams->delete($lmsCourseexam)) {*/
            $this->Flash->success(__('The lms courseexam has been deleted.'));
        } else {
            $this->Flash->error(__('The lms courseexam could not be deleted. Please, try again.'));
        } 
        return $this->redirect($this->referer());
    }
}
