<?php
namespace Lms\Controller;
use Lms\Controller\AppController;

class CoursesController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
    }
    //-----------------------------------------------------------------------------------
    public function index()
    {
        $this->paginate = [
            'contain' => ['Users','LmsCourseusers','LmsCourseweeks'],
            'order'=>['LmsCourses.id'=>'desc']
        ];
        $lmsCourses = $this->paginate($this->LmsCourses);
        $this->set(compact('lmsCourses'));
    }
    //-----------------------------------------------------------------------------------
    public function view($id = null){
        if($this->request->getQuery('export')){
            $u = $this->LmsCourseusers->find('all')
            ->where(['lms_course_id'=>$id])
            ->contain([
                'Users'=>[
                    'LmsCoursefilecans' =>['lmsCoursefiles'=>['LmsCourseweeks' , 'LmsCourseexams']]], 
                ])->toarray();

            $this->set([
                'id' => $id,
                'results'=> $u
                ]);
            $this->render('view_report');
        }
        
        elseif($this->request->getQuery('coursefile')){
            $u = $this->LmsCoursefiles->find('all')
                ->where(['LmsCoursefiles.lms_course_id'=>$id])
                ->order(['LmsCoursefiles.priority'=>'ASC'])
                ->contain([
                    //'LmsCourses',
                    'LmsCourseweeks',
                    /* 'Users'=>[
                        'LmsCoursefilecans' =>['lmsCoursefiles'=>['LmsCourseweeks' , 'LmsCourseexams']]], */
                        
                    ])
                ->toarray();

            $this->set([
                'id' => $id,
                'results'=> $u
                ]);
            $this->render('view_coursefile');
        }
        //-----------------------------
        $lmsCourse = $this->LmsCourses->get($id, [
            'contain' => [
                'Users', 
                //'LmsCoursefiles'=>['LmsCourseweeks','LmsCoursefilecans'], 
                'LmsCourserelateds'=>['LmsCourses','LmsCoursess'], 
                'LmsCourseusers'=>['Users'],
                'LmsCourseweeks'=>[
                    'sort' => ['LmsCourseweeks.priority'=>'ASC'],
                    'LmsCoursefiles'=>['LmsCoursefilenotes', 'LmsCourseexams'=>['LmsExams']]
                    ]
                ],
        ]);
        $this->set('lmsCourse', $lmsCourse);
    }
    //-----------------------------------------------------------------------------------
    public function add($id = null,$action = null)
    {
        if($id == null)
            $lmsCourse = $this->LmsCourses->newEmptyEntity(();
        else
            $lmsCourse = $this->LmsCourses->get($id);
          
        if($this->request->is(['post']) and $action == 'duplicate'){
            $this->duplicate($id);
        }
        elseif ($this->request->is(['patch', 'post', 'put'])) {

            if($this->request->getData()['date_start']!= ''){
                $time = explode(' ', $this->request->getData()['date_start'] );
                if($this->Func->Optionget('admin_calender') !=1 
                    and is_array($time) and count($time) == 2 and isset($time[0]) and isset($time[1])){
                        $time = date('Y-m-d', strtotime($this->Func->shm_to_mil($time[0],'/'))). ' ' .$time[1];
                        $this->request = $this->request->withData('date_start', $time);
                }
            }else{
                $this->request = $this->request->withData('date_start', date('Y-m-d H:i:s'));
            }
            //$this->request = $this->request->withData('price_renew',0);

            if($this->request->getData()['date_end']!= ''){
                $time = explode(' ', $this->request->getData()['date_end'] );
                if($this->Func->Optionget('admin_calender') !=1 
                    and is_array($time) and count($time) == 2 and isset($time[0]) and isset($time[1])){
                        $time = date('Y-m-d', strtotime($this->Func->shm_to_mil($time[0],'/'))). ' ' .$time[1];
                        $this->request = $this->request->withData('date_end', $time);
                }
                
            }else{
                $this->request = $this->request->withData('date_end', date('Y-m-d H:i:s'));
            }


            if(isset($this->request->getData()['options'])){
                $this->request = $this->request->withData('options', 
                json_encode($this->request->getData()['options']));
            }

            $this->request = $this->request->withData('user_id', $this->request->getAttribute('identity')->get('id') );
            $lmsCourse = $this->LmsCourses->patchEntity($lmsCourse, $this->request->getData());

            if ($this->LmsCourses->save($lmsCourse)) {
                $this->Flash->success(__('The lms course has been saved.'));
                return $this->redirect($this->referer());
            }
            $this->Flash->error(__('The lms course could not be saved. Please, try again.'));
        }

        $lmsCoursecategories = $this->LmsCourses->LmsCoursecategories->find('list', ['limit' => 200]);

        $this->set(compact('lmsCourse','lmsCoursecategories'));
    }
    //-----------------------------------------------------------------------------------
    public function delete($id = null){
        $this->request->allowMethod(['post', 'delete']);
        $lmsCourse = $this->LmsCourses->get($id);

        if(! $lmsCourse){
            $this->Flash->error(__('Not Found'));
            return $this->redirect($this->referer());
        }

        $list= $this->LmsCoursefiles->find('list',['keyField'=>'id'])->where(['lms_course_id' => $id])->toarray();
        if($list)
            $this->LmsCoursefilenotes->deleteAll(['lms_coursefile_id IN ' => $list]);

        $this->LmsCoursefiles->deleteAll(['lms_course_id' => $id ]);
        $this->LmsCoursefilecans->deleteAll(['lms_course_id' => $id ]);
        $this->LmsCourseweeks->deleteAll(['lms_course_id' => $id ]);
        $this->LmsCourseusers->deleteAll(['lms_course_id' => $id ]);
        $this->LmsCoursesessions->deleteAll(['lms_course_id' => $id ]);
        $this->LmsCourseexams->deleteAll(['lms_course_id' => $id ]);
        
        if ($this->LmsCourses->delete($lmsCourse)) {
            $this->Flash->success(__('The lms course has been deleted.'));
        } else {
            $this->Flash->error(__('The lms course could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
    //-----------------------------------------------------------------------------------
    private function duplicate($id = null){
        if($id == null) $this->redirect($this->referer());

        $lmsCourse = $this->LmsCourses->find('all')
            ->where(['id'=>$id])
            ->contain(['LmsCourseweeks'=>['LmsCoursefiles']])//=>['LmsCoursefilenotes', 'LmsCourseexams'=>['LmsExams']]
            ->enablehydration(false)
            ->first();

        $temp = $this->LmsCourses->newEmptyEntity(();
        $temp = $this->LmsCourses->patchEntity($temp, [
            'title'=> 'کپی شده >> '. $lmsCourse['title'],
            'user_id'=> $this->request->getAttribute('identity')->get('id'),
            'text'=> $lmsCourse['text'],
            'image'=> $lmsCourse['image'],
            'date_start'=> $lmsCourse['date_start'],
            'date_end'=> $lmsCourse['date_end'],
            'show_in_list'=> $lmsCourse['show_in_list'],
            'can_add'=> $lmsCourse['can_add'],
            'enable'=> $lmsCourse['enable'],
            'priority'=> $lmsCourse['priority'],
        ]);
        if ($this->LmsCourses->save($temp)) {

            foreach($lmsCourse['lms_courseweeks'] as $week){
                $temp2 = $this->LmsCourseweeks->newEmptyEntity(();
                $temp2 = $this->LmsCourseweeks->patchEntity($temp2, [
                    'lms_course_id'=> $temp['id'],
                    'title'=> $week['title'],
                    'priority'=> $week['priority'],
                ]);
                if ($this->LmsCourseweeks->save($temp2)) {

                    foreach($week['lms_coursefiles'] as $file){
                        $temp3 = $this->LmsCoursefiles->newEmptyEntity(();
                        $temp3 = $this->LmsCoursefiles->patchEntity($temp3, [
                            'title'=> $file['title'],
                            'lms_course_id'=> $temp['id'],
                            'lms_courseweek_id'=> $temp2['id'],
                            'days'=> $file['days'],
                            'filesrc_1'=> $file['filesrc_1'],
                            'filesrc_2'=> $file['filesrc_2'],
                            'filesrc_3'=> $file['filesrc_3'],
                            'filesrc_4'=> $file['filesrc_4'],
                            'content'=> $file['content'],
                            'priority'=> $file['priority'],
                            'image'=> $file['image'],
                            'enable'=> $file['enable'],
                        ]);
                        $this->LmsCoursefiles->save($temp3);
                    }
                }
            }
            $this->redirect(['action'=> 'view', $temp['id']]);
        }
    }
    //-----------------------------------------------------------------------------------
}