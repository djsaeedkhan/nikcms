<?php
namespace Tinyurl\Controller;
use Tinyurl\Controller\AppController;
class UrlController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $this->loadModel('Tinyurl.Tinyurls');
    }
    public function index($id=null)
    {
        $results = $this->Tinyurls->find()
            ->order(['id'=>'desc'])
            ->where(['OR' => [
                'id' => intval($id),
                'slug' => $id
                ]])
            ->first();
        if($results){
            $temp = $this->Tinyurls->get($results->toarray()['id']);
            $temp->views = ++$temp['views'];
            $this->Tinyurls->save($temp);
            $this->redirect($results->toarray()['link']);
        }
        else{
            $this->Flash->error(__d('Tinyurl','لینک پیدا نشد'));
            $this->redirect($this->referer());
        }
    }
}