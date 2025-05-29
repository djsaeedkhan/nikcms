<?php
namespace Formbuilder\Controller;

use Formbuilder\Controller\AppController;
use Cake\ORM\TableRegistry;
class HomeController extends AppController{
    //-------------------------------------------------------------------
    public function initialize(): void
    {
        parent::initialize();
        $this->viewBuilder()->setLayout('Admin.default');
        $this->Formbuilders = TableRegistry::getTableLocator()->get('Formbuilder.Formbuilders');

    }
    //-------------------------------------------------------------------
    public function index(){
        $results = $this->paginate(
            TableRegistry::getTableLocator()
                ->get('Formbuilder.Formbuilders')
                ->find('all')
                ->contain(['FormbuilderDatas'])
                ->order(['Formbuilders.id'=>'desc']), ['limit'=>10000]);
        $this->set(compact('results'));
    }
    //-------------------------------------------------------------------
    public function add($id = null) {
        $this->viewBuilder()->setLayout('Admin.default');
        if($id != null)
            $result = $this->Formbuilders
                ->find('all')
                ->where(['Formbuilders.id'=>$id])
                ->contain(['FormbuilderItems'])
                ->first();
        else
            $result = $this->Formbuilders->newEmptyEntity();

        if ($this->request->is(['patch', 'post', 'put'])) {
            $this->request = $this->request->withData('formbuilder_items.0.form_data', urldecode( $this->request->getData()['formbuilder_items'][0]['form_data']));

            if(isset($result['formbuilder_items'][0]['id']))
                {
                    $this->request = $this->request->withData('formbuilder_items.0.id', $result['formbuilder_items'][0]['id']);
                    echo "Yes|";
                }
            else
            echo "No";
            $result = $this->Formbuilders->patchEntity($result, $this->request->getData());

            pr($this->request->getData());
            if ($result = $this->Formbuilders->save($result)) {
                $this->Flash->success(__d('Formbuilder', 'ثبت فرم با موفقیت انجام شد'));
                //return $this->redirect(['action'=>'add',$result->id]);
            } else
                $this->Flash->error(__d('Formbuilder', 'متاسفانه ثبت فرم انجام نشد'));
        }
        $this->set([
            'result' => $result,
            ]);
    }
    //-------------------------------------------------------------------
    public function edit($id = null) {
        $this->viewBuilder()->setLayout('Admin.default');
        $this->Formbuilders = $this->getTableLocator()->get('Formbuilder.Formbuilders');
        $result = $this->Formbuilders
            ->find('all')
            ->where(['Formbuilders.id'=>$id])
            ->contain(['FormbuilderItems'])
            ->first();

        if ($this->request->is(['patch', 'post', 'put'])) {
            if($result['formbuilder_items'][0]['id'])
                $this->request = $this->request->withData('formbuilder_items.0.id', $result['formbuilder_items'][0]['id']);

            $result = $this->Formbuilders->patchEntity($result, $this->request->getData());
            if ($this->Formbuilders->save($result)) {
                $this->Flash->success(__d('Formbuilder', 'ویرایش فرم با موفقیت انجام شد.'));
                return $this->redirect(['action'=>'index']);
            }
            $this->Flash->error(__d('Formbuilder', 'متاسفانه ویرایش فرم انجام نشد'));
        }
        $this->set([
            'result' => $result,
            ]);
    }
    //-------------------------------------------------------------------
    public function view($id = null) {
        $form = [];
        if ($id == 'last') {
            $results = TableRegistry::getTableLocator()
                ->get('Formbuilder.FormbuilderDatas')
                ->find('all')
                ->contain(['Users','Formbuilders'=>['FormbuilderItems']])
                ->order(['FormbuilderDatas.id'=>'desc'])
                ->toarray();
        } else {
            $results = $p = TableRegistry::getTableLocator()
                ->get('Formbuilder.FormbuilderDatas')
                ->find('all')
                ->where(['FormbuilderDatas.formbuilder_id' => $id])
                ->contain(['Users','Formbuilders'=>['FormbuilderItems']])
                ->order(['FormbuilderDatas.id'=>'desc'])
                ->toarray();
            $form = TableRegistry::getTableLocator()
                ->get('Formbuilder.Formbuilders')
                ->get($id);
        }
        $this->set([
            'results' => $p = $results,
            'form'=>$form,
            ]);

        if ($this->request->is(['post'])) {
            $all = [];
            if (count($p)==0) {
                $this->Flash->error(__d('Formbuilder', 'اطلاعاتی برای نمایش پیدا نشد'));
                return $this->redirect($this->referer());
            }
            foreach ($p as $pp) {
                $field = unserialize($pp->field);
                $data = unserialize($pp->data);
                unset($data['formbuilder_id']);
                $list = [];
                foreach ($data as $k=>$ppp) {
                    //$list[$k] = $ppp;
                    if (!is_array($ppp)) {
                        $field[$k] = isset($field[$k])?$field[$k]:$field[str_replace('_', ' ', $k)];
                        $list[$field[$k]] = h(trim(preg_replace('~[\r\n]+~', '', h($ppp))));
                    }
                }
                //pr($list);
                $list['created'] = $this->Func->date2($pp['created']);
                array_push($all, $list);
            }
            $this->Func->tocsv($all);
        }
    }
    //-------------------------------------------------------------------
    public function ViewForm($id = null) {
        $this->set([
            'result' => TableRegistry::getTableLocator()
                ->get('Formbuilder.FormbuilderDatas')
                ->find('all')
                ->where(['FormbuilderDatas.id' => $id])
                ->contain(['Users','Formbuilders'=>['FormbuilderItems']])
                ->order(['FormbuilderDatas.id'=>'desc'])
                ->first()
            ]);
    }
    //-------------------------------------------------------------------
    public function delete($id = null){
        $this->request->allowMethod(['post', 'delete']);
        $this->Formbuilders = TableRegistry::getTableLocator()
            ->get('Formbuilder.Formbuilders');
        $data = $this->Formbuilders->get($id);
        if ($this->Formbuilders->delete($data)) {
            //$this->Formbuilders->delete($data)
            $this->Flash->success(__d('Formbuilder', 'حذف فرم با موفقیت انجام شد'));
        }
        else
            $this->Flash->error(__d('Formbuilder', 'متاسفانه حذف فرم انجام نشد.'));
        return $this->redirect($this->referer());
    }
    //-------------------------------------------------------------------
}