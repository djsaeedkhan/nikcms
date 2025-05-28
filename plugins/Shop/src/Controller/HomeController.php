<?php
namespace Shop\Controller;

use Admin\View\Helper\ModuleHelper;
use Cake\Core\Configure;
use Shop\Controller\AppController;
use Cake\ORM\TableRegistry;
class HomeController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->viewBuilder()->setLayout('Admin.default');
    }
    //-----------------------------------------------------------
    public function index(){}
    //-----------------------------------------------------------
    public function customers(){
        $results = $this->paginate($this->getTableLocator()->get('Shop.ShopAddresses'),[
            'order'=>['id'=>'desc'],
            //'contain'=>['ShopOrderproducts']
        ]);
        $this->set(compact('results'));
    }
    //-----------------------------------------------------------
    private function allCell(){
        foreach(ModuleHelper::admin_postcnt() as $nav){
            echo $this->cell($nav);
        }
    }
    //-----------------------------------------------------------
    public function postsMeta($id = null){
        global $post_id;
        $post_id = $id;
        
        $post = $this->getTableLocator()->get('Admin.Posts')
            ->get($id, ['contain' => ['Users', 'Categories', 'Tags', 'Comments', 'PostMetas']]);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $this->allCell();
            $this->Flash->success(__('The post has been saved.'));
            return $this->redirect($this->referer());
        }
        $this->allCell();
        $this->post_type = $post['post_type'];
        $this->set('post_types',$this->post_type);
        $post_meta_list = array();
        if(isset($post->post_metas))
            $post_meta_list = $this->Func->MetaList($post);

        $this->set(compact('post','post_meta_list'));
    }
    //-----------------------------------------------------------
    public function postsStock($id = null){
        $this->ShopProductstocks = $this->getTableLocator()->get('Shop.ShopProductstocks');

        if ($this->request->is(['patch', 'post', 'put'])) {
            foreach($this->request->getData()['stock'] as $kid => $value){
                $this->ShopProductstocks->query()->update()
                    ->set(['stock' => $value  ])
                    ->where(['id' => $kid ])
                    ->execute();
            }
            $this->Flash->success(__('ثبت اطلاعات با موفقیت انجام شد'));
            //return $this->redirect($this->referer());
        }
        $lists = $this->ShopProductstocks
            ->find('all')
            ->where(['post_id' => $id])
            ->toArray();

        $post = $this->getTableLocator()->get('Admin.Posts')
            ->get($id);

        $pattern = $this->getTableLocator()->get('Shop.ShopAttributelists')
            ->find('list',['keyField'=>'id','valueField'=>'title'])
            ->toarray();
        $this->set(compact('lists','pattern','id','post'));
    }
    //-----------------------------------------------------------
    public function setting(){
        $result = $this->getTableLocator()->get('Admin.Options')
            ->find('list',['keyField'=>'name','valueField'=>'value'])
            ->where(['name' => 'plugin_shop'])
            ->toArray();
        $this->set('result', $result);
    }
    //-----------------------------------------------------------
    public function schedule(){
        $result = $this->getTableLocator()->get('Admin.Options')
            ->find('list',['keyField'=>'name','valueField'=>'value'])
            ->where(['name' => 'plugin_schedule'])
            ->toArray();
        $this->set('result', $result);
    }
    //-----------------------------------------------------------
    public function transport(){
        $result = $this->getTableLocator()->get('Admin.Options')
            ->find('list',['keyField'=>'name','valueField'=>'value'])
            ->where(['name' => 'plugin_transport'])
            ->toArray();
        $this->set('result', $result);
    }
    //-----------------------------------------------------------
    public function params($id = null){
        $this->ShopParams = $this->getTableLocator()->get('Shop.ShopParams');
        $this->ShopParamlists = $this->getTableLocator()->get('Shop.ShopParamlists');
        
        $params = $this->ShopParams->newEmptyEntity(();
        $paramlists = $this->ShopParamlists->newEmptyEntity(();

        //ajax
        if($this->request->is('ajax') and $this->request->getQuery('getlist') ) {
            $this->autoRender = false;
            Configure::write('debug', 0);
            $attrlists = $this->ShopParamlists->find('list',['keyField'=>'id','valueField'=>'title'])
                ->where([
                    'types'=> 1,
                    'shop_param_id'=> $this->request->getQuery('getlist') ])
                ->select(['id','title','priority'])
                ->order(['priority'=>'asc'])
                ->toarray();
            echo json_encode($attrlists);
        }

        if($this->request->getQuery('priority')){
            if ($this->request->is(['patch', 'post', 'put']) ) {
                foreach($this->request->getData() as $id => $value){
                    $this->ShopParamlists->query()->update()
                        ->set(['priority' => $value  ])
                        ->where(['id' => $id ])
                        ->execute();
                }
                $this->Flash->success(__('ثبت اطلاعات با موفقیت انجام شد'));
                $this->redirect($this->referer());
            }
        }
        elseif($this->request->getQuery('edit')){
            $paramlists = $this->ShopParamlists->get($this->request->getQuery('edit'));

            if ($this->request->is(['patch', 'post', 'put']) ) {
                $attrlister = $this->ShopParamlists->patchEntity($paramlists, $this->request->getData() );
                if($this->ShopParamlists->save($attrlister))
                    $this->Flash->success(__('ثبت اطلاعات با موفقیت انجام شد'));
                else
                    $this->Flash->error(__('متاسفانه ثبت انجام نشد'));

                return $this->redirect(['?'=>['list'=> $this->request->getQuery('list')] ]);
            }
        }
        elseif($this->request->getQuery('deletelist')){
            //$this->request->allowMethod(['post', 'delete']);
            $attrlister = $this->ShopParamlists->get($this->request->getQuery('deletelist'));
            if ($this->ShopParamlists->delete($attrlister)) {
                $this->Flash->success(__('حذف انجام شد'));
            } else {
                $this->Flash->error(__('متاسفانه حذف انجام نشد'));
            }
            return $this->redirect($this->referer());
        }
        elseif($this->request->getQuery('delete')){
            $this->request->allowMethod(['post', 'delete']);
            $attrlister = $this->ShopParams->get($this->request->getQuery('delete'));
            if ($this->ShopParams->delete($attrlister)) {
                $this->ShopParamlists->deleteAll(['shop_param_id' => $this->request->getQuery('delete') ]);
                $this->Flash->success(__('حذف انجام شد'));
            } else {
                $this->Flash->error(__('متاسفانه حذف انجام نشد'));
            }
            return $this->redirect($this->referer());
        }
        elseif ($this->request->is('post') ) {
            if($this->request->getQuery('list')){
                $paramlists = $this->ShopParamlists->patchEntity($paramlists, $this->request->getData()+[
                    'shop_param_id' => $this->request->getQuery('list')
                ]);

                if ($this->ShopParamlists->save($paramlists)) {
                    $this->Flash->success(__('The shop param has been saved.'));
                    return $this->redirect($this->referer());
                }
                $this->Flash->error(__('The shop param could not be saved. Please, try again.'));
            }
            
            else{
                $params = $this->ShopParams->patchEntity($params, $this->request->getData());
                if ($this->ShopParams->save($params)) {
                    $this->Flash->success(__('The shop param has been saved.'));
                    return $this->redirect($this->referer());
                }
                $this->Flash->error(__('The shop param could not be saved. Please, try again.'));
            }
        }
        $attrs = $this->ShopParams->find('all')->toarray();
        $attrlists = [];
        if($this->request->getQuery('list')){
            $attrlists = $this->ShopParams->find('all')
                ->contain(['ShopParamlists' => function ($q) {
                    return $q->order(['priority'=>'desc']);
                 }])
                ->where(['id'=> $this->request->getQuery('list')])
                ->first();
        }
        $this->set(compact('params','paramlists','attrs','attrlists'));
    }
    //-----------------------------------------------------------
    public function labels($id = null){
        $this->Labels = $this->getTableLocator()->get('Shop.ShopLabels');

        if($this->request->getQuery('edit'))
            $labels = $this->Labels->get($this->request->getQuery('edit'));
        else
            $labels = $this->Labels->newEmptyEntity(();
        
        $attrlister= [];
        if($this->request->getQuery('delete')){
            $this->request->allowMethod(['post', 'delete']);
            $attrlister = $this->Labels->get($this->request->getQuery('delete'));
            if ($this->Labels->delete($attrlister)) {
                $this->Flash->success(__('حذف انجام شد'));
            } else {
                $this->Flash->error(__('متاسفانه حذف انجام نشد'));
            }
            return $this->redirect($this->referer());
        }
        elseif ($this->request->is(['patch', 'post', 'put']) ) {
            $labels = $this->Labels->patchEntity($labels, $this->request->getData());
            if($this->Labels->save($labels)) {
                $this->Flash->success(__('Lable has been saved'));
                return $this->redirect($this->referer());
            }
            $this->Flash->error(__('The label could not be saved. Please, try again.'));
        }
        $lists = $this->Labels->find('all')->order(['id'=>'desc'])->toarray();
        $this->set(compact('labels','lists'));
    }
    //-----------------------------------------------------------
    public function brands($id = null){
        $this->Brands = $this->getTableLocator()->get('Shop.ShopBrands');

        if($this->request->getQuery('edit'))
            $brands = $this->Brands->get($this->request->getQuery('edit'));
        else
            $brands = $this->Brands->newEmptyEntity(();
        
        $attrlister= [];
        if($this->request->getQuery('delete')){
            $this->request->allowMethod(['post', 'delete']);
            $attrlister = $this->Brands->get($this->request->getQuery('delete'));
            if ($this->Brands->delete($attrlister)) {
                $this->Flash->success(__('حذف انجام شد'));
            } else {
                $this->Flash->error(__('متاسفانه حذف انجام نشد'));
            }
            return $this->redirect($this->referer());
        }
        elseif ($this->request->is(['patch', 'post', 'put']) ) {
            $brands = $this->Brands->patchEntity($brands, $this->request->getData());
            if($this->Brands->save($brands)) {
                $this->Flash->success(__('Lable has been saved'));
                return $this->redirect($this->referer());
            }
            $this->Flash->error(__('The label could not be saved. Please, try again.'));
        }
        $lists = $this->Brands->find('all')->order(['id'=>'desc'])->toarray();
        $this->set(compact('brands','lists'));
    }
    //-----------------------------------------------------------
    public function attributes($id = null){
        set_time_limit(10);
        $this->ShopAttributes = $this->getTableLocator()->get('Shop.ShopAttributes');
        $this->ShopAttlists = $this->getTableLocator()->get('Shop.ShopAttributelists');

        if($this->request->getQuery('edit'))
            $attrs = $this->ShopAttributes->get($this->request->getQuery('edit'));
        else
            $attrs = $this->ShopAttributes->newEmptyEntity(();
        
        $this->attrib_ajax();

        $attrlister= [];
        if($this->request->getQuery('e_attriblist')){
            $attrlister = $this->ShopAttlists->get($this->request->getQuery('e_attriblist'));

            if ($this->request->is(['patch', 'post', 'put']) ) {
                //$attrlister = $this->ShopAttlists->newEmptyEntity(();
                $attrlister = $this->ShopAttlists->patchEntity($attrlister, $this->request->getData() );
                if($this->ShopAttlists->save($attrlister))
                    $this->Flash->success(__('ثبت اطلاعات با موفقیت انجام شد'));
                else
                    $this->Flash->error(__('متاسفانه ثبت انجام نشد'));

                return $this->redirect(['?'=>'']);
            }
        }
        elseif($this->request->getQuery('a_attrblist')){
            $attrlister = $this->ShopAttlists->newEmptyEntity(();
            if ($this->request->is(['patch', 'post', 'put']) ) {
                $this->request = $this->request->withData('shop_attribute_id',$this->request->getQuery('a_attrblist'));
                $this->request = $this->request->withData('value',1);
                $attrlister = $this->ShopAttlists->patchEntity($attrlister, $this->request->getData() );
                if($this->ShopAttlists->save($attrlister))
                    $this->Flash->success(__('ثبت اطلاعات با موفقیت انجام شد'));
                else
                    $this->Flash->error(__('متاسفانه ثبت انجام نشد'));
                return $this->redirect(['?'=>'']);
            }
        }
        elseif($this->request->getQuery('d_attriblist')){
            $this->request->allowMethod(['post', 'delete']);
            $attrlister = $this->ShopAttlists->get($this->request->getQuery('d_attriblist'));
            if ($this->ShopAttlists->delete($attrlister)) {
                $this->Flash->success(__('حذف انجام شد'));
            } else {
                $this->Flash->error(__('متاسفانه حذف انجام نشد'));
            }
            return $this->redirect($this->referer());
        }
        elseif($this->request->getQuery('delete')){
            $this->request->allowMethod(['post', 'delete']);
            $attrlister = $this->ShopAttributes->get($this->request->getQuery('delete'));
            if ($this->ShopAttributes->delete($attrlister)) {
                $this->ShopAttlists->deleteAll(['shop_attribute_id' => $this->request->getQuery('delete') ]);
                $this->Flash->success(__('حذف انجام شد'));
            } else {
                $this->Flash->error(__('متاسفانه حذف انجام نشد'));
            }
            return $this->redirect($this->referer());
        }
        elseif ($this->request->is(['patch', 'post', 'put']) ) {
            $attrs = $this->ShopAttributes->patchEntity($attrs, $this->request->getData());
            if($this->ShopAttributes->save($attrs)) {

                if(isset($this->request->getData()['value'])){
                    $data = [];
                    foreach($this->Func->newline($this->request->getData()['value']) as $item){
                        $data[] = [
                            'shop_attribute_id' => $attrs->id,
                            'title' => $item,
                            'value'=> '1'
                        ];
                    }
                    
                    $attrs = $this->ShopAttlists->newEmptyEntity(();
                    $attrs = $this->ShopAttlists->patchEntities($attrs, $data );
                    $this->ShopAttlists->saveMany($attrs);
                }
                
                $this->Flash->success(__('The shop param has been saved.'));
                return $this->redirect($this->referer());
            }
            $this->Flash->error(__('The shop param could not be saved. Please, try again.'));
        }
        $attrlist = $this->ShopAttributes->find('all')
            ->contain(['ShopAttributelists'=>['ShopAttributes']])
            ->order(['id'=>'desc'])->toarray();
        $this->set(compact('attrs','attrlist'));
        $this->set(['attrlister'=>$attrlister]);
    }
    //-----------------------------------------------------------
    private function attrib_ajax(){
        if ( $this->request->is('ajax') and $this->request->getQuery('gettitle') ) {
            $this->autoRender = false;
            Configure::write('debug', 0);
            $list = [];
            foreach($this->ShopAttlists->find('all')->contain(['ShopAttributes'])->toarray() as $temp){
                $list[$temp['id']] = isset($temp['shop_attribute']['title'])?$temp['shop_attribute']['title']:'';
            }
            echo json_encode($list);
        }

        if ( $this->request->is('ajax') and $this->request->getQuery('getlist') ) {
            $this->autoRender = false;
            Configure::write('debug', 0);
            $list_all = $this->ShopAttlists->find('list',['keyField'=>'id','valueField'=>'title'])->toarray();
            $arr = [];
            foreach(explode(',', $this->request->getQuery('getlist')) as $li){
                $arr[] = $this->ShopAttlists->find('list',['keyField'=>'id','valueField'=>'id'])
                    ->where(['shop_attribute_id'=> $li])
                    ->enableHydration(false)
                    ->toarray();
            }
            $arr = array_values($arr);
            while(count($arr) > 1){
                for($i=0;$i<count($arr);$i++){
                    $temp = [];
                    //$arr[$i] = array_reverse($arr[$i]);
                    for($j=0; $j<count($arr[$i]); $j++){
                        $arr[$i] =array_values($arr[$i]);
                        if(isset($arr[$i+1])){
                            foreach(($arr[$i+1]) as $t)
                                $temp[] = $arr[$i][$j] .','.$t;
                        }
                    }
                    if(isset($arr[$i+1])){
                        $arr[$i] = $temp;
                        unset($arr[$i+1]);
                    }
                    $arr = array_values($arr);
                }
            }
            if(isset($arr[0]) and count($arr[0])){
                $arr = $arr[0];
                foreach($arr as $k=>$ar){
                    $temp = explode(',',$ar);
                    if(count($temp)){
                        $arr[$k] = '';
                        $p = [];
                        foreach($temp as $tmp){
                            $p[$tmp]= $list_all[$tmp];
                        }
                        $arr[$k] = $p;
                    }
                }
            }
            echo json_encode($arr);
        }
    }
}