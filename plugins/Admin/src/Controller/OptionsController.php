<?php
namespace Admin\Controller;
use Admin\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Log\Log;

class OptionsController extends AppController 
{
    public function initialize(){
        parent::initialize();
    }
    //-----------------------------------------------
    public function index() {
        $this->set('result', 
            $this->Options->find('list',['keyField'=>'name','valueField'=>'value'])->toArray() );

        $this->set('result2', 
            TableRegistry::get('Admin.Options2')->find('list',['keyField'=>'name','valueField'=>'value'])->toArray() 
        );
    }
    //-----------------------------------------------
    public function all() {
        $this->set('result', 
            $this->Options->find('list',['keyField'=>'name','valueField'=>'value'])->toArray() );
    }
    //-----------------------------------------------
    public function reading() {
        $this->set('result', 
            $this->Options->find('list',['keyField'=>'name','valueField'=>'value'])->toArray() );
    }
    //-----------------------------------------------
    public function media() {
        $this->set('result', 
            $this->Options->find('list',['keyField'=>'name','valueField'=>'value'])->toArray() );
    }
    //-----------------------------------------------
    public function users() {
        $this->set('result', 
            $this->Options->find('list',['keyField'=>'name','valueField'=>'value'])->toArray() );
    }
    //-----------------------------------------------
    public function language() {
        $this->set('result', 
            $this->Options->find('list',['keyField'=>'name','valueField'=>'value'])->toArray() );
    }
    //-----------------------------------------------
    public function register() {
        $this->set('result', 
            $this->Options->find('list',['keyField'=>'name','valueField'=>'value'])->toArray() );
    }
    //-----------------------------------------------
    public function SaveSetting($show_error = 1){
        //$this->log($this->request->getData());
        $this->viewBuilder()->setLayout('ajax');
		if($this->request->is('post')):
            Log::write('debug',json_encode($this->request->getData()));
            foreach($this->request->getData() as $key => $val):
                $option = $this->Options->newEntity();
                $result = $this->Options->find('all')->where(['name' => $key]);
                $tkey = $key;
                if(substr( $tkey, 0, 8 ) === "setting_")
                    $val = is_array($val)?json_encode($val,JSON_UNESCAPED_UNICODE):$val;
                else
                    $val = is_array($val)?serialize($val):$val;
                    
                if($result->count() == 0):
                    $data = [
                        'name' => $key,
                        'value' => $val
                    ];
                else:
                    $data = [
                        'id' => $result->first()['id'],
                        'name' => $key,
                        'value' => $val];
                endif;

                $option = $this->Options->newEntity($data);
                $option = $this->Options->save($option);
            endforeach;
            if($show_error == 1 and !$this->request->is('ajax'))
                $this->Flash->success(__d('Admin', 'اطلاعات بصورت موفقیت آمیز ذخیره شدند'));
		endif;

        if($this->request->is('ajax')){
            $response = $this->response->withStringBody('1');
            return $response;
        }else{
            $this->redirect($this->referer());
        }
        $this->render(false);
    }
    //-----------------------------------------------
    public function SaveSetting2($show_error = 1){
        $this->viewBuilder()->setLayout('ajax');
        $this->Options = TableRegistry::get('Admin.Options2');
		if($this->request->is('post')):
            Log::write('debug',json_encode($this->request->getData()));
            foreach($this->request->getData() as $key=>$val):
                $option = $this->Options->newEntity();
                $result = $this->Options->find('all')->where(['name' => $key]);
                if(substr( $key, 0, 8 ) === "setting_")
                    $val = is_array($val)?json_encode($val,JSON_UNESCAPED_UNICODE):$val;
                else
                    $val = is_array($val)?serialize($val):$val;

                if( $result->count() == 0):
                    $data = [
                        'name' => $key,
                        'value' => $val ];
                else:
                    $data = [
                        'id' => $result->first()['id'],
                        'name' => $key,
                        'value' => $val ];
                endif;
                $option = $this->Options->newEntity($data);
                $this->Options->save($option);
            endforeach;
            if($show_error == 1 and !$this->request->is('ajax'))
                $this->Flash->success(__d('Admin', 'اطلاعات بصورت موفقیت آمیز ذخیره شدند'));
		endif;
		$this->redirect($this->referer());
        $this->render(false);
    }
    //-----------------------------------------------
    public function DeleteSetting($show_error = null){
        //$this->log($this->request->getData()['name']);

        $this->viewBuilder()->setLayout('ajax') ;
        if($this->request->is('post')):
            if(($id = $this->Options->find('all')
            ->where(['name' => $this->request->getData()['name']])
            ->first()['id'])){
                $post = $this->Options->get($id);
                if ($this->Options->delete($post)){
                    if($show_error == 1)
                    $this->Flash->success(__d('Admin', 'The post has been deleted.'));
                }
                else{
                    if($show_error == 1)
                    $this->Flash->error(__d('Admin', 'The post could not be deleted. Please, try again.'));
                }
            }
		endif;
		$this->redirect($this->referer());
        $this->render(false);
	}
    //-----------------------------------------------
}