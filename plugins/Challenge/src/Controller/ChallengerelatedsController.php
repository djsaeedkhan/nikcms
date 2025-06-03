<?php
namespace Challenge\Controller;

use Challenge\Controller\AppController;

class ChallengerelatedsController extends AppController
{

    public function add($id = null)
    {
        $challengerelated = $this->Challengerelateds->newEmptyEntity();
        if ($this->request->is('post')) {
            $challengerelated = $this->Challengerelateds->patchEntity($challengerelated, $this->request->getData());
            if ($this->Challengerelateds->save($challengerelated)) {
                $this->Flash->success(__('ثبت با موفقیت انجام شد'));
                return $this->redirect($this->referer());
            }
            $this->Flash->error(__('متاسفانه ثبت انجام نشد'));
        }
        $challenges = $this->Challengerelateds->Challenges->find('list');
        $this->set(compact('challengerelated', 'challenges','id'));
    }

    public function delete($id = null){
        $this->request->allowMethod(['post', 'delete']);
        $challengerelated = $this->Challengerelateds->get($id);
        if ($this->Challengerelateds->delete($challengerelated)) {
            $this->Flash->success(__('حذف با موفقیت انجام شد'));
        } else {
            $this->Flash->error(__('متاسفانه حذف انجام نشد'));
        }

        return $this->redirect($this->referer());
    }
}
