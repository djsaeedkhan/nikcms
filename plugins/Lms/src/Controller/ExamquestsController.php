<?php
namespace Lms\Controller;
use Lms\Controller\AppController;

class ExamquestsController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
    }
    
    public function index($id = null){
        $this->paginate = [
            'contain' => ['LmsExams'],
            'order' =>['priority'=>'asc'],
            'conditions'=>[ ($id != null ?['lms_exam_id' => $id]: false )]
        ];
        $lmsExamquests = $this->paginate($this->LmsExamquests);
        $this->set(compact('lmsExamquests','id'));
    }

    public function view($id = null)
    {
        $lmsExamquest = $this->LmsExamquests->get($id, [
            'contain' => ['LmsExams', 'LmsExamresults'],
        ]);
        $this->set('lmsExamquest', $lmsExamquest);
    }

    public function add($id = null)
    {
        $lmsExamquest = $this->LmsExamquests->newEmptyEntity();

        if($this->request->is('post') and $this->request->getQuery('type') == "group"){

            $list = [];
            $handle = fopen( $this->request->getdata()['file']['tmp_name'] , "r");
            for ($i = 0; $row = fgetcsv($handle ); ++$i) {
                $list[] = explode(";",$row[0]);
            }
            $title = $list[0];
            $allow = ['title','types','priority','images','q1','q2','q3','q4','q5','correct'];
            unset($list[0]);

            
            foreach($list as $k => $lis){
                unset($list[$k]);
                foreach($lis as $ki => $li){
                    if(isset($title[$ki]))
                    $list[$k][$title[$ki]] = $li;
                }
            }

            $string = '';
            foreach($list as $lst){
                $value = array_values($lst);
                pr($value[0]);
                $title = isset($value[0])?$value[0]:'';
                $equest = $this->LmsExamquests->patchEntity($this->LmsExamquests->newEmptyEntity(),[
                    'title'=> $title ,
                    'types'=> isset($lst['types'])?$lst['types']:'',
                    'priority'=> isset($lst['priority'])?$lst['priority']:'',
                    'images'=> isset($lst['images'])?$lst['images']:'',
                    'q1'=> isset($lst['q1'])?$lst['q1']:'',
                    'q2'=> isset($lst['q2'])?$lst['q2']:'',
                    'q3'=> isset($lst['q3'])?$lst['q3']:'',
                    'q4'=> isset($lst['q4'])?$lst['q4']:'',
                    'q5'=> isset($lst['q5'])?$lst['q5']:'',
                    'correct'=> isset($lst['correct'])?$lst['correct']:'',
                    'lms_exam_id' => $id
                ]);
                if ($this->LmsExamquests->save($equest)) {
                    
                    $string .= __d('Lms', 'خوشبختانه').(' '.$title .' ') .__d('Lms', 'ذخیره شد').'<br>';
                }
                else
                    $string .= __d('Lms', 'X متاسفانه').(' '.$title .' ') .__d('Lms', 'ذخیره نشد').'<br>';

            }
            $this->Flash->success($string);
            return $this->redirect($this->referer());
        }
        else if ($this->request->is('post')) {
            if($id != null)
                $this->request = $this->request->withData('lms_exam_id', $id );
                
            $lmsExamquest = $this->LmsExamquests->patchEntity($lmsExamquest, $this->request->getData());
            if ($this->LmsExamquests->save($lmsExamquest)) {
                $this->Flash->success(__('The lms examquest has been saved.'));
                return $this->redirect($this->referer());
            }
            $this->Flash->error(__('The lms examquest could not be saved. Please, try again.'));
        }
        $lmsExams = $this->LmsExamquests->LmsExams->find('list');
        $this->set(compact('lmsExamquest', 'lmsExams','id'));

        if($this->request->getQuery('type') and $this->request->getQuery('type') == "group")
            $this->render('add_group');

    }

    public function edit($id = null)
    {
        $lmsExamquest = $this->LmsExamquests->get($id, [
            'contain' => [],
        ]);
        $id = $lmsExamquest->lms_exam_id;
        if ($this->request->is(['patch', 'post', 'put'])) {
            $lmsExamquest = $this->LmsExamquests->patchEntity($lmsExamquest, $this->request->getData());
            if ($this->LmsExamquests->save($lmsExamquest)) {
                $this->Flash->success(__('The lms examquest has been saved.'));

                return $this->redirect($this->referer());
            }
            $this->Flash->error(__('The lms examquest could not be saved. Please, try again.'));
        }
        $lmsExams = $this->LmsExamquests->LmsExams->find('list');
        $this->set(compact('lmsExamquest', 'lmsExams','id'));
        $this->render('add');
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $lmsExamquest = $this->LmsExamquests->get($id);
        if ($this->LmsExamquests->delete($lmsExamquest)) {
            $this->Flash->success(__('The lms examquest has been deleted.'));
        } else {
            $this->Flash->error(__('The lms examquest could not be deleted. Please, try again.'));
        }

        return $this->redirect($this->referer());
    }
}
