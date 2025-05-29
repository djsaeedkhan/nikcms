<?php
namespace Challenge\Controller;
use Challenge\Controller\AppController;

class ChallengetextsController extends AppController
{
    public function add($id= null)
    {
        $challengetext = $this->Challengetexts->newEmptyEntity();
        if ($this->request->is('post')) {
            $this->request = $this->request->withData('challenge_id',$id );
            $challengetext = $this->Challengetexts->patchEntity($challengetext, $this->request->getData());
            if ($this->Challengetexts->save($challengetext)) {
                $this->Flash->success(__('The challengetext has been saved.'));

                return $this->redirect(['controller'=>'Admin','action' => 'view',$id]);
            }
            $this->Flash->error(__('The challengetext could not be saved. Please, try again.'));
        }
        $challenges = $this->Challengetexts->Challenges->find('list', ['limit' => 200]);
        $this->set(compact('challengetext', 'challenges'));
    }

    public function edit($id = null)
    {
        $challengetext = $this->Challengetexts->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $challengetext = $this->Challengetexts->patchEntity($challengetext, $this->request->getData());
            if ($this->Challengetexts->save($challengetext)) {
                $this->Flash->success(__('The challengetext has been saved.'));

                return $this->redirect(['controller'=>'Admin','action' => 'view',$challengetext['challenge_id']]);
            }
            $this->Flash->error(__('The challengetext could not be saved. Please, try again.'));
        }
        $challenges = $this->Challengetexts->Challenges->find('list', ['limit' => 200]);
        $this->set(compact('challengetext', 'challenges'));
        $this->render('add');
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $challengetext = $this->Challengetexts->get($id);
        if ($this->Challengetexts->delete($challengetext)) {
            $this->Flash->success(__('The challengetext has been deleted.'));
        } else {
            $this->Flash->error(__('The challengetext could not be deleted. Please, try again.'));
        }

        return $this->redirect(['controller'=>'Admin','action' => 'view',$challengetext['challenge_id']]);
    }
}
