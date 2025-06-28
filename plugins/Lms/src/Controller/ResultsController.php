<?php
namespace Lms\Controller;

use Cake\ORM\TableRegistry;
use Lms\Checker;
use Lms\Controller\AppController;
class ResultsController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
    }
    
    public function index()
    {
        /* $this->paginate = [
            'contain' => ['Users', 'LmsExams','LmsCoursefiles'=>['LmsCourses']],
            'order'=>['id'=>'desc']
        ]; */

        $result = $this->LmsExamresults->find('all')
            ->order(['LmsExamresults.id'=>'desc'])
            ->contain(['Users', 'LmsExams','LmsCoursefiles'=>['LmsCourses']]);

        if($this->request->getQuery('exam_id')){
            $result->where(['LmsExamresults.lms_exam_id' => $this->request->getQuery('exam_id')]) ;
            $result->order(['LmsExamresults.user_id' => 'desc']) ;
        }

        if($this->request->getQuery('user_id')){
            $result->where(['LmsExamresults.user_id' => $this->request->getQuery('user_id')]) ;
            $result->order(['LmsExamresults.lms_exam_id' => 'desc']) ;
        }

        if($this->request->getQuery('text')){
            $text = $this->request->getQuery('text');
            $user = $this->Users->find('list')
                ->select(['id'])
                ->where(['OR'=>[
                    'username LIKE ' => '%'.$text.'%',
                    'family LIKE ' => '%'.$text.'%']])
                ->toarray();

            if($user){
                $result->where(['OR'=>
                    ['LmsExamresults.user_id IN'=> $user]
                ]);
            }
            elseif(is_numeric($text) and strlen($text)<12 ){
                $result->where(['OR'=>[
                    'LmsExamresults.token' => $text,
                ]]);
            }
        }
        if($this->request->getQuery('sort')){
            $result = $result->order(['LmsExamresults.'.$this->request->getQuery('sort') =>$this->request->getQuery('direction')]) ;
        }
        else{
            $result = $result->order(['LmsExamresults.id'=>'desc']);
        }

        $lmsExamresults = $this->paginate($result);
        $this->set(compact('lmsExamresults'));
    }

    public function view($id = null)
    {
        $lmsExamresult = $this->LmsExamresults->get($id, [
            'contain' => ['Users', 'LmsExams','LmsCoursefiles'=>['LmsCourses'], 'LmsExamresultlists'=>['LmsExamquests']],
            
        ]);
        $this->set('lmsExamresult', $lmsExamresult);
    }

    public function add()
    {
        $lmsExamresult = $this->LmsExamresults->newEmptyEntity();
        if ($this->request->is('post')) {
            $lmsExamresult = $this->LmsExamresults->patchEntity($lmsExamresult, $this->request->getData());
            if ($this->LmsExamresults->save($lmsExamresult)) {
                $this->Flash->success(__('The lms examresult has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            else
                $this->Flash->error(__('The lms examresult could not be saved. Please, try again.'));
        }
        $users = $this->LmsExamresults->Users->find('list');
        $lmsExams = $this->LmsExamresults->LmsExams->find('list');
        $this->set(compact('lmsExamresult', 'users', 'lmsExams'));
    }

    public function edit($id = null){
        $lmsExamresult = $this->LmsExamresults->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $lmsExamresult = $this->LmsExamresults->patchEntity($lmsExamresult, $this->request->getData());
            if ($this->LmsExamresults->save($lmsExamresult)) {

                if($lmsExamresult['result'] == 3 and $this->request->getData()['result'] == 2){
                    $checks = new Checker();
                    $next = $checks->find_next($lmsExamresult['lms_coursefile_id'] );
                    if($checks->enablefile($lmsExamresult['user_id'], $next ) == 1)
                        $this->Flash->success('سطح بعدی دوره برای کاربر فعال گردید');
                    else{
                        $this->Flash->error('با وجود تلاش برای فعال سازی سطح بعدی، این کار انجام نشد');
                    }
                }
                
                $this->Flash->success(__('The lms examresult has been saved.'));

                if( isset($this->request->getQuery()['nonav']) and $this->request->getQuery()['nonav'] == 1)
                    echo '<script nonce="'.get_nonce.'">parent.location.reload();</script>';
                else
                    return $this->redirect($this->referer());
            }
            else
                $this->Flash->error(__('The lms examresult could not be saved. Please, try again.'));
        }
        $this->set(compact('lmsExamresult'));
    }

    public function editq($id = null){
        
        $lmsExamresultlist = $this->LmsExamresultlists->get($id, [
            'contain' => ['LmsExamquests'],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $lmsExamresultlist = $this->LmsExamresultlists->patchEntity($lmsExamresultlist, $this->request->getData());
            if ($this->LmsExamresultlists->save($lmsExamresultlist)) {
                $this->Flash->success(__('The lms examresult has been saved.'));
                
                if( isset($this->request->getQuery()['nonav']) and $this->request->getQuery()['nonav'] == 1)
                    echo '<script nonce="'.get_nonce.'">parent.location.reload();</script>';
                else
                    return $this->redirect($this->referer());
            }
            else
                $this->Flash->error(__('The lms examresult could not be saved. Please, try again.'));
        }
        $this->set(compact('lmsExamresultlist'));
    }
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $lmsExamresult = $this->LmsExamresults->get($id);
        if ($this->LmsExamresults->delete($lmsExamresult)) {
            TableRegistry::getTableLocator()->get('Lms.LmsExamresultlists')->deleteAll(['lms_examresult_id' => $id ]);
            $this->Flash->success(__('The lms examresult has been deleted.'));
        } else {
            $this->Flash->error(__('The lms examresult could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
