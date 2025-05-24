<?php
namespace Thumbnail\Controller;
use Thumbnail\Controller\AppController;
use Cake\ORM\TableRegistry;
class HomeController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $this->viewBuilder()->setLayout('Admin.default');
    }
    public function index(){

        if($this->request->is('post') and isset($this->request->getData()['id']) 
            and isset($this->request->getData()['url']) ){

            $this->autoRender = false;
            $url = $this->request->getData()['url'];
            $id = intval($this->request->getData()['id']);
            $p = $this->Func->save_image_size($url , $id);
            if(isset($p['thumbnail'])){
                return $this->response->withStringBody(1);
            }
            else{
                return $this->response->withStringBody(0);
            }
        }

        $result = $this->getTableLocator()->get('Admin.Posts')
            ->find('list',['keyField'=>'id','valueField'=>'title'])
            ->where(['post_type' => 'media','title LIKE'=>'%.jpg'])
            ->toArray();
        $result = $result + $this->getTableLocator()->get('Admin.Posts')
            ->find('list',['keyField'=>'id','valueField'=>'title'])
            ->where(['post_type' => 'media','title LIKE'=>'%.png'])
            ->toArray();
        $result = $result + $this->getTableLocator()->get('Admin.Posts')
            ->find('list',['keyField'=>'id','valueField'=>'title'])
            ->where(['post_type' => 'media','title LIKE'=>'%.jpeg'])
            ->toArray();
        krsort($result);

        

        if($this->request->is('post') and $this->request->getQuery('do') == 'create'){
            $cnt = 0;
            foreach($result as $k => $res){
                $p = $this->Func->save_image_size($res , $k);
                if(isset($p['thumbnail']))
                    $cnt +=1;
            }
            $this->Flash->success(__('بازسازی '.$cnt.'تصویر با موفقیت انجام شد'));
            return $this->redirect($this->referer());
        }
        $this->set('result', $result);
    }
}