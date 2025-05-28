<?php
namespace Challenge\Controller;
use Challenge\Controller\AppController;

class ChallengeforumsController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->viewBuilder()->setLayout('Admin.default');
        //$this->Challenges = $this->getTableLocator()->get('Challenge.Challenges');
    }

    public function index()
    {
        $enable = 2;
        if(($this->request->getQuery('action')) and $this->request->getQuery('action')=='unapproved'){
            $enable = 0;
        }
        if(($this->request->getQuery('action')) and $this->request->getQuery('action')=='approved'){
            $enable = 1;
        }

        $challenge_id = false;
        if($this->request->getQuery('challenge_id')){
            $challenge_id = $this->request->getQuery('challenge_id');
        }

        $this->paginate = [
            'contain' => ['Challenges', 'Challengeforumtitles', 'Users'],
            'order'=>['id'=>'desc'],
            'conditions'=>[
                $challenge_id?['Challengeforums.challenge_id'=> $challenge_id]:null,
                $enable != 2?['Challengeforums.enable'=> $enable]:null,
            ]
        ];
        $challengeforums = $this->paginate($this->Challengeforums);
        $this->set(compact('challengeforums'));
    }

    public function view($id = null){
        $challengeforum = $this->Challengeforums->get($id, [
            'contain' => ['Challenges', 'Challengeforumtitles', 'Users'],
        ]);
        $this->set('challengeforum', $challengeforum);
    }

    public function add()
    {
        $challengeforum = $this->Challengeforums->newEmptyEntity(();
        if ($this->request->is('post')) {
            $challengeforum = $this->Challengeforums->patchEntity($challengeforum, $this->request->getData());
            if ($this->Challengeforums->save($challengeforum)) {
                $this->Flash->success(__('The challengeforum has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The challengeforum could not be saved. Please, try again.'));
        }
        $challenges = $this->Challengeforums->Challenges->find('list', ['limit' => 200]);
        $challengeforumtitles = $this->Challengeforums->Challengeforumtitles->find('list', ['limit' => 200]);
        $users = $this->Challengeforums->Users->find('list', ['limit' => 200]);
        $this->set(compact('challengeforum', 'challenges', 'challengeforumtitles', 'users'));
    }

    public function edit($id = null)
    {
        $challengeforum = $this->Challengeforums->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $challengeforum = $this->Challengeforums->patchEntity($challengeforum, $this->request->getData());
            if ($this->Challengeforums->save($challengeforum)) {
                $this->Flash->success(__('The challengeforum has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The challengeforum could not be saved. Please, try again.'));
        }
        $challenges = $this->Challengeforums->Challenges->find('list', ['limit' => 200]);
        $challengeforumtitles = $this->Challengeforums->Challengeforumtitles->find('list', ['limit' => 200]);
        $users = $this->Challengeforums->Users->find('list', ['limit' => 200]);
        $this->set(compact('challengeforum', 'challenges', 'challengeforumtitles', 'users'));
    }

    public function approve($id = null)
    {
        $challengeforum = $this->Challengeforums->get($id, [
            'contain' => [],
        ]);
        
        $this->request = $this->request->withData('enable',1 );
        $challengeforum = $this->Challengeforums->patchEntity($challengeforum, $this->request->getData());
        if ($this->Challengeforums->save($challengeforum)) {
            $this->Flash->success(__('The challengeforum has been saved.'));
        }
        else
            $this->Flash->error(__('The challengeforum could not be saved. Please, try again.'));
        return $this->redirect($this->referer());
    }
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $challengeforum = $this->Challengeforums->get($id);
        if ($this->Challengeforums->delete($challengeforum)) {
            $this->Flash->success(__('The challengeforum has been deleted.'));
        } else {
            $this->Flash->error(__('The challengeforum could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}