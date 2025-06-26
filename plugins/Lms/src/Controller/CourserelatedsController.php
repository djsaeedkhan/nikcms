<?php
namespace Lms\Controller;

use Lms\Controller\AppController;

class CourserelatedsController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
    }
    
    /* public function index()
    {
        $this->paginate = [
            'contain' => ['LmsCourses'],
        ];
        $lmsCourserelateds = $this->paginate($this->LmsCourserelateds);

        $this->set(compact('lmsCourserelateds'));
    } */

    /* public function view($id = null)
    {
        $lmsCourserelated = $this->LmsCourserelateds->get($id, [
            'contain' => ['LmsCourses'],
        ]);

        $this->set('lmsCourserelated', $lmsCourserelated);
    } */

    public function add($id = null){
        $lmsCourserelated = $this->LmsCourserelateds->newEmptyEntity();
        if ($this->request->is('post')) {
            $this->request = $this->request->withData('lms_course_id', $id);

            $lmsCourserelated = $this->LmsCourserelateds->patchEntity($lmsCourserelated, $this->request->getData());
            if ($this->LmsCourserelateds->save($lmsCourserelated)) {
                $this->Flash->success(__('ثبت دوره مرتبط با موفقیت انجام شد'));
                return $this->redirect(['controller' => 'Courses','action'=>'view',$id]);
            }
            $this->Flash->error(__('متاسفانه ثبت دوره مرتبط انجام نشد'));
        }
        $lmsCourses = $this->LmsCourserelateds->LmsCourses->find('list',[
            'conditions'=>['id != '=>$id]
        ]);
        $this->set(compact('lmsCourserelated', 'lmsCourses'));
    }

    /* public function edit($id = null)
    {
        $lmsCourserelated = $this->LmsCourserelateds->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $lmsCourserelated = $this->LmsCourserelateds->patchEntity($lmsCourserelated, $this->request->getData());
            if ($this->LmsCourserelateds->save($lmsCourserelated)) {
                $this->Flash->success(__('The lms courserelated has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The lms courserelated could not be saved. Please, try again.'));
        }
        $lmsCourses = $this->LmsCourserelateds->LmsCourses->find('list');
        $this->set(compact('lmsCourserelated', 'lmsCourses'));
    } */

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $lmsCourserelated = $this->LmsCourserelateds->get($id);
        if ($this->LmsCourserelateds->delete($lmsCourserelated)) {
            $this->Flash->success(__('حذف دوره مرتبط با موفقیت انجام شد'));
        } else {
            $this->Flash->error(__('متاسفانه حذف دوره مرتبط انجام نشد'));
        }

        return $this->redirect($this->referer());
    }
}