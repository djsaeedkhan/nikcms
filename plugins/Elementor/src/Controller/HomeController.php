<?php
namespace Elementor\Controller;

use Admin\View\Helper\ModuleHelper;
use Elementor\Controller\AppController;
use Cake\ORM\TableRegistry;
class HomeController extends AppController{
    //-------------------------------------------------------------------
    public function initialize(){
        parent::initialize();
    }
    //-------------------------------------------------------------------
    public function index(){
        /* $results = $this->paginate(
            TableRegistry::getTableLocator()
                ->get('Formbuilder.Formbuilders')
                ->find('all')
                ->contain(['FormbuilderDatas'])
                ->order(['Formbuilders.id'=>'desc']),['limit'=>10000]);
        $this->set(compact('results')); */
    }
    //-------------------------------------------------------------------
    public function savesetting($id = null){
        $this->viewBuilder()->setLayout('Admin.ajax');
        //$this->autoRender = false;
        $param = $this->request->getQuery();
        global $setting;
        global $data;
        
        $data = null;
        $result = TableRegistry::getTableLocator()->get('Admin.PostMetas')->find('all')
            ->where(['post_id'=>$id ,'meta_type'=>'elementor','meta_key'=>$param['setting']])
            ->first();
        if($result){
            $data = $result['meta_values'];
        }

        $element = null;
        foreach(ModuleHelper::register_elementor() as $elm){
            if($elm['plugin'].'.'.$elm['name'] == $this->request->getQuery('plugin'))
                $element = $elm;
        }
        if($element == null)
            return $this->response->withStringBody("Element Not Found");

        $meta= null;
        if($this->request->getQuery('name')){
            $meta = TableRegistry::getTableLocator()->get('Admin.PostMetas')->find('all')
                ->where(['meta_type'=>'elementor','post_id'=> $id,'meta_key'=>$this->request->getQuery('name')])
                ->first();
        }
        if($this->request->is('post')){
            $p = $this->Func->PostMetaSave($id,[
                'type' => 'elementor',
                'name' => $this->request->getQuery('setting'),
                'value' => $this->request->getData()[str_replace('.','_',$this->request->getQuery('setting'))],
                'action' => 'create']);
            return $this->response->withStringBody($p==1?'success':'error' );
        }

        $this->set([
            'element'=>$element,
            'meta'=>$meta,
            'setting'=> $this->request->getQuery('setting'),
            'id'=> $id,
            'data'=>$data
        ]);
    }
    //-------------------------------------------------------------------
    public function deletesetting($id = null){
        $this->request->allowMethod(['post', 'delete','get']);
        $this->viewBuilder()->setLayout('Admin.ajax');
        $this->autoRender = false;
        $param = $this->request->getQuery();

        $result = TableRegistry::getTableLocator()->get('Admin.PostMetas')->find('all')
            ->where(['post_id'=>$id ,'meta_type'=>'elementor','meta_key'=>$param['setting']])
            ->first();
        if($result){
            $this->Postmetas = TableRegistry::getTableLocator()->get('Admin.PostMetas');
            $pmeta = $this->Postmetas->get($result->id);
            if ($this->Postmetas->delete($pmeta)) {
                return $this->response->withStringBody(1); 
            }
            else
                return $this->response->withStringBody(0); 
        }
        return $this->response->withStringBody(2); 
    }
    //-------------------------------------------------------------------
    public function savestatus($id = null){

        if($this->request->is('post') and isset($this->request->getData()['data'])){
            $p = $this->Func->PostMetaSave($id,[
                'type' => 'meta',
                'name' => 'elementor',
                'value' => $this->request->getData()['data'],
                'action' => 'create']);
            return $this->response->withStringBody($p==1?'1':'0' );
        }
        else
        return $this->response->withStringBody(0);

    }

    
}