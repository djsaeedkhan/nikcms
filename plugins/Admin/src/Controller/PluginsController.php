<?php
namespace Admin\Controller;

use Admin\Controller\AppController;
use Userlogs\Plugin as Userlogs;
use Cake\Core\Plugin;

class PluginsController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
    }
    //----------------------------------------------------------------
    public function index(){
        if(($this->request->getQuery('add')) or ($this->request->getQuery('remove'))){
            if(($this->request->getQuery('add')))
                $this->_Favorite($this->request->getQuery('add') , 'add');
            elseif(($this->request->getQuery('remove')))
                $this->_Favorite($this->request->getQuery('remove') , 'remove');
        }

        $this->set('result',$this->Func->plugin_getlist());
        $this->set('plugin_available',unserialize($this->Func->OptionGet('plugin_available_list')));
        $this->set('plugin_favorite',$p = unserialize($this->Func->OptionGet('plugin_favorite_list')));
    }
    //----------------------------------------------------------------
    public function view($id = null){
        $plugin = $this->Plugin->get($id, ['contain' => []]);
        $this->set('plugin', $plugin);
    }
    //----------------------------------------------------------------
    private function _Favorite($name = null,$action = 'add'){

        $this->render(false);
        //if ($this->request->is('post')) {
            $data = $this->Func->OptionGet('plugin_favorite_list');
            $temp = array();
            if($data != false)
                $temp = unserialize($data);
            if($action == 'add'){
                if(!in_array($name,$temp))
                    $temp []= $name;
            }
            else{
                foreach($temp as $k=>$value){
                    if($value == $name)
                        unset($temp[$k]);
                }
            }
            $result = $this->Func->OptionSave('plugin_favorite_list', serialize($temp),'create');
            if( $result){
                if($action == 'add')
                    $this->Flash->success(__d('Admin', 'افزودن به علاقه مندی انجام شد'));
                else {
                    $this->Flash->success(__d('Admin', 'حذف از علاقه مندی انجام شد'));
                }
            }
            else
                $this->Flash->error(__d('Admin', 'متاسفانه درخواست شما انجام نشد'));
        //}
        return $this->redirect($this->referer());
    }
    //----------------------------------------------------------------
    public function Enable($name = null,$action = 'enable'){
        $this->render(false);
        if ($this->request->is('post')) {
            $data = $this->Func->OptionGet('plugin_available_list');
            $temp = array();
            if($data != false)
                $temp = unserialize($data);
            if($action == 'enable'){
                if(!in_array($name,$temp))
                    $temp []= $name;
                Plugin::getCollection()->get($name)->activation();
            }
            else{
                if(in_array($name,$temp))
                    unset($temp[array_search($name, $temp)]);

                Plugin::getCollection()->get($name)->deactivation();
            }
            $result = $this->Func->OptionSave('plugin_available_list', serialize($temp),'create');
            if( $result)
                $this->Flash->success(__d('Admin', 'تغییرات با موفقیت اعمال شد'));
            else
                $this->Flash->error(__d('Admin', 'متاسفانه تغییرات اعمال نشد. دوباره تلاش کنید'));
        }
        return $this->redirect($this->referer());
    }
    //----------------------------------------------------------------
    public function execute($id = null){
        //$this->request->allowMethod(['post', 'delete']);
        //$list = unserialize($this->Func->OptionGet('plugin_available_list'));

        $available = $this->Func->plugin_available();
        foreach($this->Func->plugin_data() as $app){
            try {
                if(in_array($app->getName(),$available)){
                    pr($app->activation());
                }
                    
            } catch (\Throwable $th) {
                //debug($app->name);
            }
        }
        $this->Flash->success(__d('Admin', 'تغییرات ساختاری دیتابیس با موفقیت بروزرسانی شد'));

        return $this->redirect($this->referer());


    }
    //----------------------------------------------------------------
}