<?php
namespace Admin\Controller;
use Admin\Controller\AppController;
use Cake\Event\EventInterface;

class CommentsController extends AppController
{
    //-----------------------------------------------------------------------------
    public function initialize(): void
    {
        parent::initialize();
    }
    //-----------------------------------------------------------------------------
    public function beforeFilter(EventInterface $event)
    {
        if($this->request->getParam('action') == 'save'){
            //$this->Auth->allow();
            $this->Authentication->addUnauthenticatedActions();
        }
        /* else{
            $this->viewBuilder()->setLayout('Admin.default');
            $this->set(['code'=>1]);
        } */
    }
    //-----------------------------------------------------------------------------
    public function index(){
        $users = $this->Comments->Users->find('list')->toarray();
        $comments = $this->paginate(
            $this->Comments->find('all')
                ->contain(['Posts', 'Users','ParentComments'])
                ->order(['id'=>'desc'])
        );
        $this->set(compact('comments','users'));
    }
    //-----------------------------------------------------------------------------
    public function add($id = null){
        if($id != null)
            $comment = $this->Comments->get($id, ['contain' => ['Posts', 'Users']]);
        else
            $comment = $this->Comments->newEmptyEntity();
        if ($this->request->is(['patch', 'post', 'put'])) {
            $comment = $this->Comments->patchEntity($comment, $this->request->getData());
            if ($this->Comments->save($comment)) {
                $this->Flash->success(__d('Admin', 'The comment has been saved.'));
                return $this->redirect(['action' => 'index']);
            }else
            $this->Flash->error(__d('Admin', 'The comment could not be saved. Please, try again.'));
        }
        $users = $this->Comments->Users->find('list', ['limit' => 200]);
        $this->set(compact('comment', 'posts', 'users'));
    }
    //-----------------------------------------------------------------------------
    public function reply($id = null)
    {
        $comment = $this->Comments->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $comment = $this->Comments->newEmptyEntity();
            $comment = $this->Comments->patchEntity($comment, $this->request->getData());
            if ($this->Comments->save($comment)) {
                $this->Flash->success(__d('Admin', 'The comment has been saved.'));
                return $this->redirect(['action' => 'index']);
            }else
            $this->Flash->error(__d('Admin', 'The comment could not be saved. Please, try again.'));
            //debug($comment->errors());
        }
        $this->set(compact('comment'));
    }
    //-----------------------------------------------------------------------------
    public function approve($id = null,$approve)
    {
        $this->autorender = false;
        $comment = $this->Comments->get($id, ['contain' => ['Posts', 'Users']]);
        $comment = $this->Comments->patchEntity($comment, ['approved'=>($approve==1?0:1)]);
        if ($this->Comments->save($comment))
            $this->Flash->success(__d('Admin', 'The comment has been saved.'));
        else
            $this->Flash->error(__d('Admin', 'The comment could not be saved. Please, try again.'));
        return $this->redirect(['action' => 'index']);
    }
    //-----------------------------------------------------------------------------
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $comment = $this->Comments->get($id);
        if ($this->Comments->delete($comment)) {
            $this->Flash->success(__d('Admin', 'The comment has been deleted.'));
        }
        else
            $this->Flash->error(__d('Admin', 'The comment could not be deleted. Please, try again.'));
        return $this->redirect(['action' => 'index']);
    }
    //-----------------------------------------------------------------------------
    public function save($id = null){
        $data = $this->request->getData();
        $post = $this->Query->post('',['id'=> $data['post_id'],'get_type'=>'first']);
        if ($this->request->is(['post']) and isset($post['id'])) {
            $comment = $this->Comments->newEmptyEntity();
            $comment = $this->Comments->patchEntity($comment,[
                'post_id' => $post['id'],
                'content' => isset($data['body'])?$data['body']:null,
                'approved' => 0 ,
                'post_type' => $post['post_type'] ,
                'parent_id' => 0 ,
                'user_id' => $this->request->getAttribute('identity')->get('id'),
                'author' => isset($data['name'])?$data['name']:null,
                'author_email' =>isset($data['email'])?$data['email']:null,
                'author_url' => isset($data['website'])?$data['website']:null,
                'author_IP' => $this->request->clientIp() ,
            ]);
            if ($this->Comments->save($comment))
                $this->Flash->success(__d('Admin', 'ثبت نظر شما با موفقیت انجام شد'));
            else
                $this->Flash->error(__d('Admin', 'متاسفانه نظرشما ثبت نشد'));
        }
        return $this->redirect($this->referer());
        
    }
    //-----------------------------------------------------------------------------
}