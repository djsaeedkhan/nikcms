<?php
namespace Admin\Controller;
use Admin\Controller\AppController;
use Cake\Event\Event;

class CommentsController extends AppController
{
    //-----------------------------------------------------------------------------
    public function initialize(){
        parent::initialize();
    }
    //-----------------------------------------------------------------------------
    public function beforeFilter(Event $event){
        if($this->request->getParam('action') == 'save'){
            $this->Auth->allow();
        }
        /* else{
            $this->ViewBuilder()->setLayout('Admin.default');
            $this->set(['code'=>1]);
        } */
    }
    //-----------------------------------------------------------------------------
    public function index(){
        $this->paginate = [
            'contain' => ['Posts', 'Users','ParentComments'],
            'order'=> ['id'=>'desc']
        ];
        $users = $this->Comments->Users->find('list')->toarray();
        $comments = $this->paginate($this->Comments);
        $this->set(compact('comments','users'));
    }
    //-----------------------------------------------------------------------------
    public function add($id = null){
        if($id != null)
            $comment = $this->Comments->get($id, ['contain' => ['Posts', 'Users']]);
        else
            $comment = $this->Comments->newEntity();
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
            $comment = $this->Comments->newEntity();
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
            $comment = $this->Comments->newEntity();
            $comment = $this->Comments->patchEntity($comment,[
                'post_id' => $post['id'],
                'content' => isset($data['body'])?$data['body']:null,
                'approved' => 0 ,
                'post_type' => $post['post_type'] ,
                'parent_id' => 0 ,
                'user_id' => $this->Auth->user('id'),
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