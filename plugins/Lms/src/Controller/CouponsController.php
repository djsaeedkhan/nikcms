<?php
namespace Lms\Controller;

use Cake\ORM\TableRegistry;
use Lms\Controller\AppController;


class CouponsController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->LmsCoupons = TableRegistry::getTableLocator()->get('Lms.LmsCoupons');
    }
    public function index(){
        $this->paginate = [
            //'order'=>['id'=>'desc']
        ];

        $lmsCoupons = $this->LmsCoupons->find('all')
            ->contain(["LmsFactors" => [
                'queryBuilder' => function ($q) {
                    return $q->where(['LmsFactors.paid'=>'1']);
                }
            ]])
            ->order(
                $this->request->getQuery('sort')?
                    ['LmsCoupons.'.$this->request->getQuery('sort')=>$this->request->getQuery('direction')]:
                    ["LmsCoupons.expiry_date"=>'desc']
                );
        $lmsCoupons = $this->paginate($lmsCoupons);
        $this->set(compact('lmsCoupons'));
    }

    public function view($id = null)
    {
        $lmsCoupon = $this->LmsCoupons->get($id, [
            'contain' => ["LmsFactors"=>['Users']],
            'order'=>['id'=>'desc']
        ]);

        $this->set('lmsCoupon', $lmsCoupon);
    }

    public function add($id = null){
        if($id != null){
            $lmsCoupon = $this->LmsCoupons->get($id, [
                'contain' => [],
            ]);
        }else{
            $lmsCoupon = $this->LmsCoupons->newEntity();
        }
        if ($this->request->is(['patch', 'post', 'put'])) {
            $this->request = $this->request->withData('product_ids', json_encode($this->request->getData()['product_ids']));
            $this->request = $this->request->withData('expiry_date', $this->Func->shm_to_mil($this->request->getData()['expiry_date'],'/'));

            $lmsCoupon = $this->LmsCoupons->patchEntity($lmsCoupon, $this->request->getData());
            if ($this->LmsCoupons->save($lmsCoupon)) {
                if ($this->request->is(['post']))
                    $this->Flash->success(__('ثبت کد تخفیف با موفقیت انجام شد'));
                else
                    $this->Flash->success(__('ویرایش کد تخفیف انجام شد'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('متاسفانه عملیات کد تخفیف انجام نشد'));
        }
        $courselist = $this->LmsCourses->find('list',['keyField' => 'id','valueField' => 'title'])->toarray();
        $this->set(compact('lmsCoupon','courselist'));
    }

    public function edit($id = null)
    {
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            $lmsCoupon = $this->LmsCoupons->patchEntity($lmsCoupon, $this->request->getData());
            if ($this->LmsCoupons->save($lmsCoupon)) {
                $this->Flash->success(__('ویرایش کد تخفیف انجام شد'));

                return $this->redirect($this->referer());
            }
            $this->Flash->error(__('متاسفانه ویرایش کد تخفیف انجام نشد'));
        }
        $this->set(compact('lmsCoupon'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Lms Coupon id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $lmsCoupon = $this->LmsCoupons->get($id);
        if ($this->LmsCoupons->delete($lmsCoupon)) {
            $this->Flash->success(__('کوپن تخفیف با موفقیت حذف گردید'));
        } else {
            $this->Flash->error(__('متاسفانه حذف کد تخفیف انجام نشد.'));
        }

        return $this->redirect($this->referer());
    }
}
