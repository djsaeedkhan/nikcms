<?php
namespace Challenge\Controller;
use Challenge\Controller\AppController;

class ChallengetimelinesController extends AppController
{
    public function add($id = null){
        $challengetimeline = $this->Challengetimelines->newEmptyEntity();
        if ($this->request->is('post')) {
            $this->request = $this->request->withData('challenge_id',$id );
            $challengetimeline = $this->Challengetimelines->patchEntity($challengetimeline, $this->request->getData());
            
            if ($this->Challengetimelines->save($challengetimeline)) {
                $this->Flash->success(__('ثبت اطلاعات با موفقیت انجام شد'));
                return $this->redirect(['action' => 'edit',$id]);
            }
            $this->Flash->error(__('متاسفانه ثبت اطلاعات انجام نشد. لطفا دوباره تلاش کنید'));
        }
        $challenges = $this->Challengetimelines->Challenges->find('list', []);
        $this->set(compact('challengetimeline', 'challenges'));
    }

    public function edit($id = null){
        $challengetimeline = $this->Challengetimelines->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $challengetimeline = $this->Challengetimelines->patchEntity($challengetimeline, $this->request->getData());
            if ($this->Challengetimelines->save($challengetimeline)) {
                $this->Flash->success(__('ثبت اطلاعات با موفقیت انجام شد'));
                return $this->redirect($this->referer());
                //return $this->redirect(['controller'=>'Admin','action' => 'view',$challengetimeline['challenge_id']]);
            }
            pr($challengetimeline);
            $this->Flash->error(__('متاسفانه ثبت اطلاعات انجام نشد'));
        }
        $challenges = $this->Challengetimelines->Challenges->find('list', []);
        $this->set(compact('challengetimeline', 'challenges'));
    }
    
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $challengetimeline = $this->Challengetimelines->get($id);
        if ($this->Challengetimelines->delete($challengetimeline)) {
            $this->Flash->success(__('The challengetimeline has been deleted.'));
        } else {
            $this->Flash->error(__('The challengetimeline could not be deleted. Please, try again.'));
        }

        return $this->redirect(['controller'=>'Admin','action' => 'view',$challengetimeline['challenge_id']]);
    }
}
