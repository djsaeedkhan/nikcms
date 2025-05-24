<?php
namespace Lms\Controller;

use Cake\ORM\TableRegistry;
use Lms\Controller\AppController;

class FactorsController extends AppController
{
    public function initialize(){
        parent::initialize();
    }
    //-----------------------------------------------------------------------------------
    public function index()
    {
        $this->paginate = [
            'contain' => ['Users'],
            'order'=>['id'=>'desc']
        ];

        $factor = $this->LmsFactors->find('all')
            ->contain(['Users'])
            ->order(
                $this->request->getQuery('sort')?
                    ['LmsFactors.'.$this->request->getQuery('sort')=>$this->request->getQuery('direction')]:
                    ['LmsFactors.id'=>'desc']
                );

        if($this->request->getQuery('text')){
            $temp = TableRegistry::getTableLocator()->get('Lms.Users')->find('list',['keyField' =>'id','valueField'=>'id'])
                ->where([
                    'OR'=>[
                        'username LIKE '=>'%'.$this->request->getQuery('text').'%',
                        'phone LIKE '=>'%'.$this->request->getQuery('text').'%',
                        'family LIKE '=>'%'.$this->request->getQuery('text').'%',
                    ]
                ])
                ->toarray();
            if(count($temp) > 0)
                $factor->where(['LmsFactors.user_id IN '=>  $temp]);
            else{
                $factor = $factor->where(['OR'=>[
                    is_numeric($this->request->getQuery('text'))?['LmsFactors.id LIKE ' => '%'.$this->request->getQuery('text').'%']:[],
                    'descr LIKE ' => '%'.$this->request->getQuery('text').'%',
                ]]);
            }
        }
        if($this->request->getQuery('user_id')){
            $factor = $factor->where(['OR'=>[
                'LmsFactors.user_id' =>$this->request->getQuery('user_id'),
            ]]);
        }

        $lmsFactors = $this->paginate($factor);
        $this->set(compact('lmsFactors'));

        if ($this->request->getQuery('tocsv')) {
            $u = $factor->limit(100000000)->toArray();
            $list = [];
            $header = [
                'ش فاکتور',
                'مبلغ',
                'کاربر',
                'پرداخت شده',
                'توضیحات',
                /* 'وضعیت', */
                'تاریخ ثبت',
            ];
            foreach($u as $us){ 
                $temp = [
                    'id'=>$us->id,
                    'price'=> $us->price,
                    'user_id'=> $us->has('user') ?$us->user->Fname:'-',
                    'paid'=> $us->paid==1?'موفق':'ناموفق',
                    'descr'=> $us->descr,
                    /* 'status'=> $us->status, */
                    'created'=> $this->Func->date2($us->created) ,
                ];
                array_push( $list ,$temp );
            }
            $this->Func->tocsv( $list,$header);
        }

    }
    //-----------------------------------------------------------------------------------
    public function view($id = null)
    {
        $lmsFactor = $this->LmsFactors->get($id, [
            'contain' => [
                'Users', 
                'LmsPayments', 
                'LmsUserfactors',
                //'Userss'
            ],
        ]);
        $this->set('lmsFactor', $lmsFactor);
    }
    //-----------------------------------------------------------------------------------
    public function add($id=null)
    {
        if($id != null)
            $lmsFactor = $this->LmsFactors->get($id);
        else
            $lmsFactor = $this->LmsFactors->newEntity();

        if ($this->request->is(['patch', 'post', 'put'])) {
            $this->request = $this->request->withData('user_ids', $this->request->getAttribute('identity')->get('id') );
            $this->request = $this->request->withData('status', 0);

            $lmsFactor = $this->LmsFactors->patchEntity($lmsFactor, $this->request->getData());
            if ($this->LmsFactors->save($lmsFactor)) {
                if ($this->request->is(['post'])) {
                    $lmsUserfactor = $this->LmsUserfactors->newEntity();
                    $lmsUserfactor = $this->LmsUserfactors->patchEntity($lmsUserfactor,[
                        'user_id' => $this->request->getData()['user_id'],
                        'lms_factor_id' => $lmsFactor->id,
                        'lms_course_id' => $this->request->getData()['lms_course_id'],
                        'user_ids' => $this->request->getAttribute('identity')->get('id'), 
                        'enable' => $this->request->getData()['paid']
                    ]);
                    if ($this->LmsUserfactors->save($lmsUserfactor)){
                        $this->Flash->success('ثبت فاکتور دسترسی کاربر به دوره با موفقیت انجام شد');  

                        if($this->request->getData()['paid'] == 1){
                            $lmsCourseuser = $this->LmsCourseusers->newEntity();
                            $lmsCourseuser = $this->LmsCourseusers->patchEntity($lmsCourseuser, [
                                'user_id' => $this->request->getData()['user_id'],
                                'lms_course_id' => $this->request->getData()['lms_course_id'],
                                'enable'=> 1
                            ]);
                            if($this->LmsCourseusers->save($lmsCourseuser)){
                                $this->Flash->success('فعال سازی دوره انتخاب شده برای کاربر با موفقیت انجام شد');
                            }else{
                                $this->Flash->error('متاسفانه، دوره درخواست شده فعال نگردید - کد39');
                            }
                        }
                        
                        
                    }else{
                        $this->Flash->error('متاسفانه ثبت فاکتور دسترسی کاربر به دوره انجام نشد');  
                    }

                }

                $this->Flash->success(($id != null?'بروز رسانی ':'ایجاد').__(' فاکتور با موفقیت انجام گردید'));
                return $this->redirect(['action' => 'view',$lmsFactor->id]);
            }
            $this->Flash->error(__('متاسفانه ثبت / بروزرسانی فاکتور با موفقیت انجام نشد'));
        }
        $users = $this->LmsFactors->Users->find('list',['keyField'=>'id','valueField'=>'fname']);
        $course = $this->LmsCourses->find('list',['keyField'=>'id','valueField'=>'title']);
        $this->set(compact('lmsFactor', 'users','course'));
    }
    //-----------------------------------------------------------------------------------
    public function delete($id = null){

        if($id == null and $this->request->getQuery('id')){
            $id = $this->request->getQuery('id');
            $this->request->allowMethod(['get', 'delete']);
        }else{
            $this->request->allowMethod(['post', 'delete']);
        }
        foreach($id as $ids){
            $lmsFactor = $this->LmsFactors->get($ids);
            if ($this->LmsFactors->delete($lmsFactor)) {
                $this->Flash->success(__('فاکتور #'.$ids .' با موفقیت حذف شد'));
            } else {
                $this->Flash->error(__('متاسفانه فاکتور  #'.$ids .' حذف نشد'));
            }
        }
        return $this->redirect(['action' => 'index']);
    }
    //-----------------------------------------------------------------------------------
}