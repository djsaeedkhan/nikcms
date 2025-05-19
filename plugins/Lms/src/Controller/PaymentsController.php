<?php
namespace Lms\Controller;

use Cake\ORM\TableRegistry;
use Lms\Controller\AppController;

/**
 * LmsPayments Controller
 *
 * @property \Lms\Model\Table\LmsPaymentsTable $LmsPayments
 *
 * @method \Lms\Model\Entity\LmsPayment[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PaymentsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index(){
        $this->paginate = [
            'contain' => ['LmsFactors', 'Users'],
            //'order'=>['id'=>'desc']
        ];

        $payment = $this->LmsPayments->find('all')
            ->contain(['LmsFactors', 'Users'])
            ->order(
                $this->request->getQuery('sort')?
                    ['LmsPayments.'.$this->request->getQuery('sort')=>$this->request->getQuery('direction')]:
                    ['LmsPayments.id'=>'desc']
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
                $payment->where(['LmsPayments.user_id IN '=>  $temp]);
            else{
                $payment->where([
                    is_numeric($this->request->getQuery('text'))?['LmsPayments.id LIKE ' => '%'.$this->request->getQuery('text').'%']:[],
                    'LmsPayments.token LIKE ' => '%'.$this->request->getQuery('text').'%',
                ]);
            }
        }
        if($this->request->getQuery('user_id')){
            $payment = $payment->where(['OR'=>[
                'LmsPayments.user_id' =>$this->request->getQuery('user_id'),
            ]]);
        }
        $lmsPayments = $this->paginate($payment);
        $this->set(compact('lmsPayments'));

        if ($this->request->getQuery('tocsv')) {
            $u = $payment->limit(100000000)->toArray();
            $list = [];
            $header = [
                'ش فاکتور',
                'پیگیری',
                'مبلغ',
                'کاربر',
                'درگاه',
                'پرداخت',
                'تاریخ ثبت',
            ];
            foreach($u as $us){ 
                $temp = [
                    'lms_factor_id'=>$us->has('lms_factor')?$us->lms_factor->id:'',
                    'token'=>$us->token,
                    'price'=> $us->price,
                    'user_id'=> $us->has('user') ?$us->user->Fname:'',
                    'terminal_ids'=> $us->terminal_ids,
                    'enable'=> $us->enable,
                    'created'=> $this->Func->date2($us->created) ,
                ];
                array_push( $list ,$temp );
            }
            $this->Func->tocsv( $list,$header);
        }
    }

    /**
     * View method
     *
     * @param string|null $id Lms Payment id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $lmsPayment = $this->LmsPayments->get($id, [
            'contain' => ['LmsFactors', 'Users'],
        ]);

        $this->set('lmsPayment', $lmsPayment);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $lmsPayment = $this->LmsPayments->newEntity();
        if ($this->request->is('post')) {
            $lmsPayment = $this->LmsPayments->patchEntity($lmsPayment, $this->request->getData());
            if ($this->LmsPayments->save($lmsPayment)) {
                $this->Flash->success(__('The lms payment has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The lms payment could not be saved. Please, try again.'));
        }
        $lmsFactors = $this->LmsPayments->LmsFactors->find('list');
        $users = $this->LmsPayments->Users->find('list');
        $this->set(compact('lmsPayment', 'lmsFactors', 'users'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Lms Payment id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $lmsPayment = $this->LmsPayments->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $lmsPayment = $this->LmsPayments->patchEntity($lmsPayment, $this->request->getData());
            if ($this->LmsPayments->save($lmsPayment)) {
                $this->Flash->success(__('The lms payment has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The lms payment could not be saved. Please, try again.'));
        }
        $lmsFactors = $this->LmsPayments->LmsFactors->find('list');
        $users = $this->LmsPayments->Users->find('list');
        $this->set(compact('lmsPayment', 'lmsFactors', 'users'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Lms Payment id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null){

        if($id == null and $this->request->getQuery('id')){
            $id = $this->request->getQuery('id');
            $this->request->allowMethod(['get', 'delete']);
        }else{
            $this->request->allowMethod(['post', 'delete']);
        }
        foreach($id as $ids){
            $lmsPayment = $this->LmsPayments->get($ids);
            if ($this->LmsPayments->delete($lmsPayment)) {
                $this->Flash->success(__('پرداخت #'.$ids .' با موفقیت حذف شد'));
            } else {
                $this->Flash->error(__('متاسفانه پرداخت  #'.$ids .' حذف نشد'));
            }
        }
        return $this->redirect(['action' => 'index']);
    }
}
