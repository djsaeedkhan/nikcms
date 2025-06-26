<?php
namespace Lms\Controller;
use Lms\Controller\AppController;

class CoursefilesController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
    }
    
    public function index() {
        /* $this->paginate = [
            'contain' => ['LmsCourses', 'LmsCourseweeks'],
        ]; */
        $lmsCoursefiles = $this->paginate(
            $this->LmsCoursefiles->find('all')->contain(['LmsCourses', 'LmsCourseweeks'])
        );
        $this->set(compact('lmsCoursefiles'));
    }

    public function view($id = null) {
        $lmsCoursefile = $this->LmsCoursefiles->get($id, [
            'contain' => ['LmsCourses', 'LmsCourseweeks', 'LmsCoursefilecans', 'LmsCoursefilenotes', 'LmsCourseusernotes'],
        ]);
        $this->set('lmsCoursefile', $lmsCoursefile);
    }

    public function add($id = null, $weekid = null) {
        $lmsCoursefile = $this->LmsCoursefiles->newEmptyEntity();
        if ($this->request->is('post')) {
            
            if($id != null)
                $this->request = $this->request->withData('lms_course_id', $id );
            
            if($weekid != null)
                $this->request = $this->request->withData('lms_courseweek_id', $weekid );

            $lmsCoursefile = $this->LmsCoursefiles->patchEntity($lmsCoursefile, $this->request->getData());
            if ($this->LmsCoursefiles->save($lmsCoursefile)) {
                $this->Flash->success(__('The lms coursefile has been saved.'));

                if( isset($this->request->getQuery()['nonav']) and $this->request->getQuery()['nonav'] == 1)
                    echo '<script nonce="'.get_nonce.'">parent.location.reload();</script>';
                else
                    return $this->redirect(['controller'=>'courses','action'=>'view',$lmsCoursefile->lms_course_id ]);
            }
            else
            $this->Flash->error(__('The lms coursefile could not be saved. Please, try again.'));
        }
        $lmsCourses = $this->LmsCoursefiles->LmsCourses->find('list');
        $lmsCourseweeks = $this->LmsCoursefiles->LmsCourseweeks->find('list');
        $this->set(compact('lmsCoursefile', 'lmsCourses', 'lmsCourseweeks','id','weekid'));
    }

    public function edit($id = null) {
        $lmsCoursefile = $this->LmsCoursefiles->get($id, [
            'contain' => [],
        ]);
        $weekid = $lmsCoursefile->lms_courseweek_id;
        if ($this->request->is(['patch', 'post', 'put'])) {
            $lmsCoursefile = $this->LmsCoursefiles->patchEntity($lmsCoursefile, $this->request->getData());
            if ($this->LmsCoursefiles->save($lmsCoursefile)) {
                $this->Flash->success(__('The lms coursefile has been saved.'));

                if( isset($this->request->getQuery()['nonav']) and $this->request->getQuery()['nonav'] == 1)
                    echo '<script nonce="'.get_nonce.'">parent.location.reload();</script>';
                else
                    return $this->redirect(['controller'=>'courses','action'=>'view',$lmsCoursefile->lms_course_id ]);
            }
            else
            $this->Flash->error(__('The lms coursefile could not be saved. Please, try again.'));
        }
        $lmsCourses = $this->LmsCoursefiles->LmsCourses->find('list');
        $lmsCourseweeks = $this->LmsCoursefiles->LmsCourseweeks->find('list');

        $this->set(compact('lmsCoursefile', 'lmsCourses', 'lmsCourseweeks','id','weekid'));
        $this->render('add');
    }

    public function delete($id = null) {
        $this->request->allowMethod(['post', 'delete']);
        $lmsCoursefile = $this->LmsCoursefiles->get($id);
        if ($this->LmsCoursefiles->delete($lmsCoursefile)) {
            $this->Flash->success(__('The lms coursefile has been deleted.'));
        } else {
            $this->Flash->error(__('The lms coursefile could not be deleted. Please, try again.'));
        }

        return $this->redirect($this->referer());
    }
}
