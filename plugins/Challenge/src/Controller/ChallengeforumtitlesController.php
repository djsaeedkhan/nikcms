<?php
namespace Challenge\Controller;

use Challenge\Controller\AppController;

/**
 * Challengeforumtitles Controller
 *
 * @property \Challenge\Model\Table\ChallengeforumtitlesTable $Challengeforumtitles
 *
 * @method \Challenge\Model\Entity\Challengeforumtitle[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ChallengeforumtitlesController extends AppController
{
    public function add($id = null)
    {
        $challengeforumtitle = $this->Challengeforumtitles->newEmptyEntity(();
        if ($this->request->is('post')) {
            $this->request = $this->request->withData('challenge_id',$id );
            $challengeforumtitle = $this->Challengeforumtitles->patchEntity($challengeforumtitle, $this->request->getData());
            if ($this->Challengeforumtitles->save($challengeforumtitle)) {
                $this->Flash->success(__('The challengeforumtitle has been saved.'));

                return $this->redirect(['controller'=>'Admin','action' => 'view',$id]);
            }
            $this->Flash->error(__('The challengeforumtitle could not be saved. Please, try again.'));
        }
        $challenges = $this->Challengeforumtitles->Challenges->find('list', ['limit' => 200]);
        $this->set(compact('challengeforumtitle', 'challenges'));
    }

    public function edit($id = null)
    {
        $challengeforumtitle = $this->Challengeforumtitles->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $challengeforumtitle = $this->Challengeforumtitles->patchEntity($challengeforumtitle, $this->request->getData());
            if ($this->Challengeforumtitles->save($challengeforumtitle)) {
                $this->Flash->success(__('The challengeforumtitle has been saved.'));

                return $this->redirect(['controller'=>'Admin','action' => 'view',$challengeforumtitle['challenge_id']]);
            }
            $this->Flash->error(__('The challengeforumtitle could not be saved. Please, try again.'));
        }
        $challenges = $this->Challengeforumtitles->Challenges->find('list', ['limit' => 200]);
        $this->set(compact('challengeforumtitle', 'challenges'));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $challengeforumtitle = $this->Challengeforumtitles->get($id);
        if ($this->Challengeforumtitles->delete($challengeforumtitle)) {
            $this->Flash->success(__('The challengeforumtitle has been deleted.'));
        } else {
            $this->Flash->error(__('The challengeforumtitle could not be deleted. Please, try again.'));
        }

        return $this->redirect(['controller'=>'Admin','action' => 'view',$challengeforumtitle['challenge_id']]);
    }
}
