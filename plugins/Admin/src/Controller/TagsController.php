<?php
namespace Admin\Controller;

use Admin\Controller\AppController;
use Cake\ORM\TableRegistry;

class TagsController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
    }

    public function index(){
        $tag = $this->Tags->newEmptyEntity();
        $tags = $this->paginate($this->Tags->find('all')
            ->contain(['Posts'])
            ->where(['post_type'=>$this->post_type]));
        $this->set(compact('tag','tags'));
    }

    public function view($id = null){
        $tag = $this->Tags->get($id, [
            'contain' => ['Posts']
        ]);
        $this->set('tag', $tag);
    }

    public function add($id = null){
        if($id != null)
            $tag = $this->Tags->get($id, ['contain' => ['Posts']]);
        else
            $tag = $this->Tags->newEmptyEntity();
        if ($this->request->is(['patch', 'post', 'put'])) {
            //$this->request->data['post_type'] = $this->post_type;
            $tag = $this->Tags->patchEntity($tag, $this->request->getData());
            if ($this->Tags->save($tag)) {
                $this->Flash->success(__d('Admin', 'The tag has been saved.'));
                return $this->redirect($this->referer());
            }
            $this->Flash->error(__d('Admin', 'The tag could not be saved. Please, try again.'));
        }
        $posts = $this->Tags->Posts->find('list', ['limit' => 200]);
        $this->set(compact('tag', 'posts'));
    }

    public function delete($id = null){
        $this->request->allowMethod(['post', 'delete']);
        $tag = $this->Tags->get($id);
        if ($this->Tags->delete($tag)) {
            $this->Flash->success(__d('Admin', 'The tag has been deleted.'));
        } else {
            $this->Flash->error(__d('Admin', 'The tag could not be deleted. Please, try again.'));
        }
        return $this->redirect($this->referer());
    }
}
