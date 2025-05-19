<?php
namespace Challenge\Controller;
use Challenge\Controller\AppController;

class ChallengeimagesController extends AppController
{
    public function add($id = null)
    {
        $challengeimage = $this->Challengeimages->newEntity();
        if ($this->request->is('post')) {
            $this->request = $this->request->withData('challenge_id',$id );
            $challengeimage = $this->Challengeimages->patchEntity($challengeimage, $this->request->getData());
            if ($this->Challengeimages->save($challengeimage)) {
                $this->Flash->success(__('The challengeimage has been saved.'));

                return $this->redirect(['controller'=>'Admin','action' => 'view',$id]);
            }
            $this->Flash->error(__('The challengeimage could not be saved. Please, try again.'));
        }
        $challenges = $this->Challengeimages->Challenges->find('list', ['limit' => 200]);
        $this->set(compact('challengeimage', 'challenges'));
    }


    public function edit($id = null)
    {
        $challengeimage = $this->Challengeimages->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $challengeimage = $this->Challengeimages->patchEntity($challengeimage, $this->request->getData());
            if ($this->Challengeimages->save($challengeimage)) {
                $this->Flash->success(__('The challengeimage has been saved.'));

                return $this->redirect(['controller'=>'Admin','action' => 'view',$challengeimage['challenge_id']]);
            }
            $this->Flash->error(__('The challengeimage could not be saved. Please, try again.'));
        }
        $challenges = $this->Challengeimages->Challenges->find('list', ['limit' => 200]);
        $this->set(compact('challengeimage', 'challenges'));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $challengeimage = $this->Challengeimages->get($id);
        if ($this->Challengeimages->delete($challengeimage)) {
            $this->Flash->success(__('The challengeimage has been deleted.'));
        } else {
            $this->Flash->error(__('The challengeimage could not be deleted. Please, try again.'));
        }

        return $this->redirect(['controller'=>'Admin','action' => 'view',$challengeimage['challenge_id']]);
    }
}
