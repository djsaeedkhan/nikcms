<?php
namespace Lms\Controller;

use Cake\ORM\TableRegistry;
use Lms\Controller\AppController;
use Cake\I18n\Time;
use \Sms\Sms;

class UserController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
    }
    /* public $paginate = array(
        'maxLimit' => 1000000,
    ); */
    
    public function index(){

        if ($this->request->getQuery('nofactor_newuser')){
            //try {
                $this->sms = new Sms();
                $time = Time::now();
                $day = is_numeric($this->request->getQuery('nofactor_newuser'))?$this->request->getQuery('nofactor_newuser'):10;
                $time->addDays("-". $day);
                $factors = TableRegistry::getTableLocator()
                    ->get('Lms.Users')
                    ->find('all')
                    ->enablehydration(false)
                    ->where([
                        'Users.created LIKE ' => "%".$time->format('Y-m-d')."%",
                        'Users.enable'=> 1,
                        ])
                    ->contain(['LmsFactors'])
                    ->toarray();
    
                foreach($factors as $factor){
                    if(isset($factor['lms_factors']) and is_array($factor['lms_factors']) and count($factor['lms_factors']) == 0){
                        var_dump($factor['username']);
                    }
                }
                die();
            /* } catch (\Throwable $th) {
               echo "<br>nofactor_newuser  Error<br>";
            } */
        }

        $user = $this->Users->find('all')
            ->contain([
                'Roles',
                'LmsPayments'=>['LmsFactors'],
                'LmsFactors',
                'LmsExamresults'=>[
                    'LmsExams',
                    'LmsCoursefiles'=>['LmsCourses']
                ],
                'Profiles',
                'UserMetas',
                'LmsCourseusers'=>['LmsCourses']
            ]);
        
        if($this->request->getQuery('sort') and 
            in_array( $this->request->getQuery('sort') ,['username','family','role_id','created'])){

            $user->order(['Users.'. $this->request->getQuery('sort') =>
                $this->request->getQuery('direction')?$this->request->getQuery('direction'):'desc'
                ]);
        }
        else
            $user->order(['Users.created'=> 'desc']);
            
        if($this->request->getQuery('text')){
            $user->where(['OR'=>[
                'family LIKE ' => '%'.$this->request->getQuery('text').'%',
                'username LIKE ' => '%'.$this->request->getQuery('text').'%',
                'email LIKE ' => '%'.$this->request->getQuery('text').'%',
            ]]);
        }

        if($this->request->getQuery('course_id')){
            $temp = TableRegistry::getTableLocator()->get('Lms.LmsCourseusers')->find('list',['keyField' =>'user_id','valueField'=>'user_id'])
                ->where(['lms_course_id' => $this->request->getQuery('course_id')])
                ->toarray();
            $user->where(['Users.id IN '=>  $temp]);
        }

        //'limit'=>100
        $users = $this->paginate($user,[
            ($this->request->getQuery('limit')?[
                'maxLimit' => $this->request->getQuery('limit'),
                'limit' => $this->request->getQuery('limit')
                ]:false),
        ]);
        $this->set(compact('users'));
    }
    //-----------------------------------------------------
    public function view($id = null){
        $user = $this->Users->get($id, [
            'contain' => ['Roles', 
            'LmsCourses', 'LmsCoursesessions', 'LmsCourseusers', 'LmsExams', 
            'LmsExamresults'=> ['LmsExams'],
             'LmsExamusers', 'LmsUsernotes', 'LmsUserprofiles',  'Profiles' ,'UserMetas'],
        ]);
        $this->set('user', $user);
    }
    //-----------------------------------------------------
    public function group(){
        if($this->request->getQuery('action') and $this->request->getQuery('action') == 'delete'){
            $this->set('users',$p = TableRegistry::getTableLocator()->get('Lms.Users')->find('list',['keyField' =>'id','valueField'=>'Fname'])
                ->where([
                    is_array($this->request->getQuery('user_id'))?
                        ['id IN' =>$this->request->getQuery('user_id')]:
                        ['id' =>$this->request->getQuery('user_id')]
                    
                    ])
                ->toarray());

            if ($this->request->is('post')) {
                $this->request->allowMethod(['post', 'delete']);

                foreach($this->request->getData()['user_id'] as $user){
                    $temp = TableRegistry::getTableLocator()->get('Lms.Users')->get($user);
                    if(TableRegistry::getTableLocator()->get('Lms.Users')->delete($temp))
                        $this->Flash->success(__('کاربر '.$temp['username'].'با موفقیت حذف شد'));
                    else
                        $this->Flash->success(__('متاسفانه کاربر '.$temp['family'].'حذف نشد'));
                }
                $this->redirect(['action'=>'index']);
            }
            return $this->render('group_delete');

        }
        elseif($this->request->getQuery('action') and $this->request->getQuery('action') == 'disable'){
            $this->LmsUsers = TableRegistry::getTableLocator()->get('Lms.Users');
            foreach($this->request->getQuery('user_id') as $user){
                $temp = $this->LmsUsers->get($user);

                $temp->enable = false;
                if($this->LmsUsers->save($temp)){
                    $this->Flash->success(__('کاربر '.$temp['username'].' با موفقیت غیرفعال شد'));
                } else {
                    $this->Flash->success(__('متاسفانه کاربر '.$temp['family'].' غیرفعال نشد'));
                }
            }
            $this->redirect(['action'=>'index']);
        }
        elseif($this->request->getQuery('action') and $this->request->getQuery('action') == 'enable'){
            $this->LmsUsers = TableRegistry::getTableLocator()->get('Lms.Users');
            foreach($this->request->getQuery('user_id') as $user){
                $temp = $this->LmsUsers->get($user);
                $temp->enable = true;
                if($this->LmsUsers->save($temp)){
                    $this->Flash->success(__('کاربر '.$temp['username'].' با موفقیت فعال شد'));
                } else {
                    $this->Flash->success(__('متاسفانه کاربر '.$temp['family'].' فعال نشد'));
                }
            }
            $this->redirect(['action'=>'index']);
        }
    }
}
