<?php
namespace Lms\Controller;

use Cake\ORM\TableRegistry;
use Lms\Controller\AppController;

class CourseusersController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
    }
    
    public function index(){
        /* $this->paginate = [
            'contain' => ['LmsCourses', 'Users'],
        ]; */
        $lmsCourseusers = $this->paginate(
            $this->LmsCourseusers->find('all')->contain(['LmsCourses', 'Users'])
        );
        $this->set(compact('lmsCourseusers'));
    }
    private function _view2($course_id = null){
        $results = $this->LmsCourseusers->find('all')
            ->contain(['LmsCourses'=>['LmsCourseweeks'=>['LmsCoursefiles'=>['LmsCoursefilenotes','LmsCourseexams'=>['LmsExams']] ]]])
            ->where(['LmsCourseusers.lms_course_id' => $course_id ])
            ->order(['LmsCourseusers.id'=>'desc' ])
            ->first();

        /* $can = $this->LmsCoursefilecans
            ->find('list',['keyField'=>'lms_coursefile_id','valueField'=>'lms_coursefile_id'])
            ->order(['id'=>'asc'])
            ->where(['user_id' => $user_id ])
            ->toarray(); 

        $exam = $this->LmsExamresults
            //->find('all')
            ->find('list',['keyField'=>'lms_exam_id','valueField'=>'result'])
            ->order(['id'=>'asc'])
            ->where(['user_id' => $user_id ])
            ->toarray();

        $exam_all = $this->LmsExamresults
            ->find('all')
            ->order(['id'=>'asc'])
            ->where(['user_id' => $user_id ])
            ->toarray();

        $exam_result = $this->LmsExamresults
            ->find('list',['keyField'=>'lms_exam_id','valueField'=>'id'])
            ->order(['id'=>'desc'])
            ->where(['user_id' => $user_id ])
            ->toarray();

        $session = $this->LmsCoursesessions
            ->find('all')
            ->where(['user_id' => $user_id ])
            ->enablehydration(false)
            ->toarray(); */

        $this->set([
            /* 'session' => $session ,
            'can'=> $can,
            'exam_result'=>$exam_result,
            'exam'=> $exam,
            'exam_all' => $exam_all, */
            'results' => $results['LmsCourses']
        ]);
    }
    public function view( $course_id = null , $user_id = null) {

        if($user_id == null){
            $this->_view2($course_id);
            $this->render('view2');
        }
        else{
            if($this->request->getQuery('id')){
                $tmp = $this->LmsCoursefilecans->newEmptyEntity();
                $tmp = $this->LmsCoursefilecans->patchEntity($tmp,[
                    'lms_coursefile_id' => $this->request->getQuery('id'),
                    'lms_course_id' => $course_id,
                    'user_id' => $user_id,
                    'types'=>1,
                    'enable' => 1,
                ]);
                if($this->LmsCoursefilecans->save($tmp))
                    $this->Flash->success(__('Saved'));
                else
                    $this->Flash->error(__('Not Saved'));

                $this->redirect($this->referer());
            }
            elseif($this->request->getQuery('submit')){
                foreach($this->request->getQuery() as $k=>$val){ 
                    if(intval($k) != 0 and $val == 1):
                        $tmp = $this->LmsCoursefilecans->newEmptyEntity();
                        $tmp = $this->LmsCoursefilecans->patchEntity($tmp,[
                            'lms_coursefile_id' => $k,
                            'lms_course_id' => $course_id,
                            'user_id' => $user_id,
                            'types'=>1,
                            'enable' => 1,
                        ]);
                        if($this->LmsCoursefilecans->save($tmp))
                            $this->Flash->success(__('Saved'));
                        else
                            $this->Flash->error(__('Not Saved'));
                    endif;
                }
                $this->redirect($this->referer());
            }
            $results = $this->LmsCourseusers->find('all')
                ->contain(['Users','LmsCourses'=>['LmsCourseweeks'=>['LmsCoursefiles'=>['LmsCoursefilenotes','LmsCourseexams'=>['LmsExams']] ]]])
                ->where(['LmsCourseusers.lms_course_id' => $course_id , 'LmsCourseusers.user_id'=> $user_id])
                ->order(['LmsCourseusers.id'=>'desc' ])
                ->first();

            $can = $this->LmsCoursefilecans
                ->find('list',['keyField'=>'lms_coursefile_id','valueField'=>'lms_coursefile_id'])
                ->order(['id'=>'asc'])
                ->where(['user_id' => $user_id ])
                ->toarray(); 

            $exam = $this->LmsExamresults
                //->find('all')
                ->find('list',['keyField'=>'lms_exam_id','valueField'=>'result'])
                ->order(['id'=>'asc'])
                ->where(['user_id' => $user_id ])
                ->toarray();

            $exam_all = $this->LmsExamresults
                ->find('all')
                ->order(['id'=>'asc'])
                ->where(['user_id' => $user_id ])
                ->toarray();

            $exam_result = $this->LmsExamresults
                ->find('list',['keyField'=>'lms_exam_id','valueField'=>'id'])
                ->order(['id'=>'desc'])
                ->where(['user_id' => $user_id ])
                ->toarray();

            $session = $this->LmsCoursesessions
                ->find('all')
                ->where(['user_id' => $user_id ])
                ->enablehydration(false)
                ->toarray();

            $this->set([
                'session' => $session ,
                'can'=> $can,
                'exam_result'=>$exam_result,
                'exam'=> $exam,
                'exam_all' => $exam_all,
                'results' => $results,
            ]);
        }
        
    }
    public function add($id = null){
        $lmsCourseuser = $this->LmsCourseusers->newEmptyEntity();

        if ($this->request->is('post') and 
            $this->request->getQuery('type') and $this->request->getQuery('type')=='textarea') {

                $lists = $this->Func->newline($this->request->getData()['user_ids']);
                
                if($lists and $id != 0){
                    foreach($lists as $list){

                        $user = $this->getTableLocator()->get('Users')->find('all')->where(['username'=> $list])->first();
                        if($user){
                            $lmsCourseuser = $this->LmsCourseusers->newEmptyEntity();
                            $lmsCourseuser = $this->LmsCourseusers->patchEntity($lmsCourseuser, [
                                'user_id' => $user['id'],
                                'lms_course_id' => $id
                            ]);
                            $this->LmsCourseusers->save($lmsCourseuser);
                        }
                    }
                    $this->Flash->success(__('The lms courseuser has been saved.'));
                    if( isset($this->request->getQuery()['nonav']) and $this->request->getQuery()['nonav'] == 1)
                        echo '<script nonce="'.get_nonce.'">parent.location.reload();</script>';
                    else
                        return $this->redirect(['controller'=>'Courses','action' => 'view', $id]);
                }
           
        }
        else if ($this->request->is('post')) {
            if(count($this->request->getData()['user_id']) > 0){

                if(isset($this->request->getData()['lms_course_id']))
                    $id = $this->request->getData()['lms_course_id'];

                foreach($this->request->getData()['user_id'] as $user){
                    $lmsCourseuser = $this->LmsCourseusers->newEmptyEntity();
                    $lmsCourseuser = $this->LmsCourseusers->patchEntity($lmsCourseuser, [
                        'user_id' => $user,
                        'lms_course_id' => $id
                    ]);
                    $this->LmsCourseusers->save($lmsCourseuser);
                }

                $this->Flash->success(__('The lms courseuser has been saved.'));
                if( isset($this->request->getQuery()['nonav']) and $this->request->getQuery()['nonav'] == 1)
                    echo '<script nonce="'.get_nonce.'">parent.location.reload();</script>';
                else
                    return $this->redirect(['controller'=>'Courses','action' => 'view', $id]);
            }
        }
        $lmsCourses = $this->LmsCourseusers->LmsCourses->find('list');
        foreach($this->LmsCourseusers->Users->find('all') as $us){
            $users[$us['id']] = $us['username']. ($us['family']!=''?' ('.$us['family'].')':'');
        }
        $this->set(compact('lmsCourseuser', 'lmsCourses', 'users','id'));
    }
    public function edit($id = null, $user_id = null){
        $lmsCourseuser = $this->LmsCourseusers->get($id,['contain'=>'Users']);
        if ($this->request->is(['patch', 'post', 'put'])) {
            //$this->request = $this->request->withData('user_id', $user_id );

            $lmsCourseuser = $this->LmsCourseusers->patchEntity($lmsCourseuser, $this->request->getData());
            if ($this->LmsCourseusers->save($lmsCourseuser)) {
                $this->Flash->success(__('The lms courseuser has been saved.'));
                return $this->redirect($this->referer());
            }
            $this->Flash->error(__('The lms courseuser could not be saved. Please, try again.'));
        }
        $lmsCourses = $this->LmsCourseusers->LmsCourses->find('list');
        $users = $this->LmsCourseusers->Users->find('list');
        $this->set(compact('lmsCourseuser', 'lmsCourses', 'users'));
    }

    public function delete($id = null , $user_id = null)
    {
        if ($this->request->is(['post', 'delete'])) {
            if(isset($this->request->getData()['user_id']) and is_array($this->request->getData()['user_id'])){
                foreach($this->request->getData()['user_id'] as $user){
                    $this->delete_data( $user_id , $id);
                    $this->LmsCourseusers->deleteAll([
                        'lms_course_id' => $id,
                        'user_id' => $user ]);
                }
                $this->Flash->success(__('کاربران انتخاب شده از دوره حذف شدند.'));
            }

            if($user_id != null){
                $this->delete_data( $user_id , $id );
                if($this->LmsCourseusers->deleteAll(['lms_course_id' => $id,'user_id' => $user_id ])){
                    $this->Flash->success(__('حذف کاربر از دوره با موفقیت انجام شد'));
                }
                else {
                    $this->Flash->error(__('متاسفانه حذف کاربر از دوره انجام نشد'));
                }
            }
            if( isset($this->request->getQuery()['nonav']) and $this->request->getQuery()['nonav'] == 1)
                echo '<script nonce="'.get_nonce.'">parent.location.reload();</script>';
            else
                return $this->redirect($this->referer());
        }

        $lmsCourseuser = $this->LmsCourseusers->newEmptyEntity();
        $lmsCourses = $this->LmsCourseusers->LmsCourses->find('list');

        $temp = $this->LmsCourseusers->find('all')
            ->contain(['Users'])
            ->where(['LmsCourseusers.lms_course_id'=>$id]);
        $users = [];
        if($temp){
            foreach($temp as $us){
                $users[$us['user']['id']] = $us['user']['username']. ($us['user']['family']!=''?' ('.$us['user']['family'].')':'');
            }
        }
        $this->set(compact('lmsCourseuser', 'lmsCourses', 'users','id'));
    }
    private function delete_data($user_id = null , $course_id = null){

        $this->LmsExamresults = TableRegistry::getTableLocator()->get('Lms.LmsExamresults');
        $this->LmsExamresultlists = TableRegistry::getTableLocator()->get('Lms.LmsExamresultlists');
        $this->LmsUserfactors = TableRegistry::getTableLocator()->get('Lms.lmsUserfactors');
        TableRegistry::getTableLocator()->get('Lms.lmsCoursesessions')->deleteAll(['lms_course_id' => $course_id,'user_id' => $user_id ]);
        TableRegistry::getTableLocator()->get('Lms.lmsCoursefilecans')->deleteAll(['lms_course_id' => $course_id,'user_id' => $user_id ]);
        //$p = TableRegistry::getTableLocator()->get('Lms.lmsUserfactors')->deleteAll(['lms_course_id' => $course_id,'user_id' => $user_id ]);

        $userFactor = 
            $this->LmsUserfactors->find('all')
                ->contain(['LmsFactors'=>['LmsPayments'] ])
                ->where(['lms_course_id' => $course_id,'lmsUserfactors.user_id' => $user_id ])->first();
        if($userFactor){
            $fact = $userFactor['lms_factor'];
            foreach($fact['lms_payments'] as $payment){
                TableRegistry::getTableLocator()->get('Lms.lmsPayments')->deleteAll(['id' => $payment['id'],'user_id' => $user_id ]);
            }
            TableRegistry::getTableLocator()->get('Lms.lmsFactors')->deleteAll(['id' => $fact['id'],'user_id' => $user_id ]);
            $this->LmsUserfactors->deleteAll(['id' => $userFactor['id'],'user_id' => $user_id ]);
        }
            
        $lists = TableRegistry::getTableLocator()->get('Lms.lmsCourseexams')->find('all')
            ->where(['lms_course_id' => $course_id])
            ->toarray();

        foreach($lists as $list ){
            $user_exam = $this->LmsExamresults->find('all')
                ->where(['lms_coursefile_id' =>  $list['lms_coursefile_id'],'user_id' => $user_id ])
                ->toarray();

            foreach($user_exam as $ue){
                $this->LmsExamresultlists->deleteAll([
                    'lms_examresult_id'=> $ue->id ,
                    'user_id'=> $user_id]);

                $this->LmsExamresults->deleteAll([
                    'id'=> $ue->id,
                    'user_id' => $user_id ]);
            }
        }
    }
    
}