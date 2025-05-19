<?php
namespace Lms\Controller;
use Lms\Controller\AppController;

class CourseweeksController extends AppController
{
    public function initialize(){
        parent::initialize();
    }
    
    /* public function index()
    {
        $this->paginate = [
            'contain' => ['LmsCourses'],
        ];
        $lmsCourseweeks = $this->paginate($this->LmsCourseweeks);

        $this->set(compact('lmsCourseweeks'));
    } */

    /* public function view($id = null)
    {
        $lmsCourseweek = $this->LmsCourseweeks->get($id, [
            'contain' => ['LmsCourses', 'LmsCoursefiles'],
        ]);
        $this->set('lmsCourseweek', $lmsCourseweek);
    } */

    public function add($id = null , $ids = null)
    {
        if($ids != null)
            $lmsCourseweek = $this->LmsCourseweeks->get($ids, ['contain' => [],]);
        else 
            $lmsCourseweek = $this->LmsCourseweeks->newEntity();

        if ($this->request->is(['patch', 'post', 'put'])) {
            if($id != null)
                $this->request = $this->request->withData('lms_course_id', $id );
            
            $lmsCourseweek = $this->LmsCourseweeks->patchEntity($lmsCourseweek, $this->request->getData());
            if ($this->LmsCourseweeks->save($lmsCourseweek)) {
                $this->Flash->success(__('The lms courseweek has been saved.'));

                if( $this->request->getQuery('nonav') and $this->request->getQuery('nonav') == 1)
                    echo '<script nonce="'.get_nonce.'">parent.location.reload();</script>';
                else
                    return $this->redirect($this->referer());
            }
            else 
            $this->Flash->error(__('The lms courseweek could not be saved. Please, try again.'));
        }
        $lmsCourses = $this->LmsCourseweeks->LmsCourses->find('list');
        $this->set(compact('lmsCourseweek', 'lmsCourses','id'));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);

        $file = $this->LmsCoursefiles->find('all')
            ->where(['lms_courseweek_id'=>$id])
            ->count();
        if( $file > 0){
            $this->Flash->error('برای این هفته، '.$file.'فایل وجود دارد. ابتدا نسبت به حذف آنها اقدام کنید');
            return $this->redirect($this->referer()); 
        }

        $lmsCourseweek = $this->LmsCourseweeks->get($id);
        if ($this->LmsCourseweeks->delete($lmsCourseweek)) {
            $this->Flash->success(__('The lms courseweek has been deleted.'));
        } else {
            $this->Flash->error(__('The lms courseweek could not be deleted. Please, try again.'));
        }
        return $this->redirect($this->referer());
    }
}
