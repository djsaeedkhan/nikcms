<?php
namespace Seo\Controller;
use Seo\Controller\AppController;
class UrlController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        //$this->loadModel('Seo.Tinyurls');
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
        else
        {
            $this->Flash->error(__d('Seo','url not fount'));
            $this->redirect($this->referer());
        }
    }
}