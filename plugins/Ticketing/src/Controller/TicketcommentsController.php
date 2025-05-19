<?php
namespace Ticketing\Controller;

use Cake\ORM\TableRegistry;
use Ticketing\Controller\AppController;

class TicketcommentsController extends AppController
{
    public function index()
    {
        $this->paginate = [
            'contain' => ['Users', 'Tickets'],
            'order'=>['created'=>'desc']
        ];
        $ticketcomments = $this->paginate($this->Ticketcomments);
        $this->set(compact('ticketcomments'));
    }

    public function view($id = null)
    {
        $ticketcomment = $this->Ticketcomments->get($id, [
            'contain' => ['Users', 'Tickets'],
        ]);
        $this->set('ticketcomment', $ticketcomment);
    }

    public function add()
    {
        $ticketcomment = $this->Ticketcomments->newEntity();
        if ($this->request->is('post')) {

            if(!empty($this->request->getData()['file']['name'])) {	
                $fuConfig['upload_path'] = WWW_ROOT . 'tickets/';
                if (!file_exists($fuConfig['upload_path'])) {
                    mkdir($fuConfig['upload_path'], 0777, true);
                }
                $fuConfig['allowed_types'] = 'zip|rar|pdf|jpg|doc|mp3|mp4';
                $fuConfig['file_name'] = 'tk'.$this->Auth->user('id').'_'.date('m-d-h').'_'.rand(1000,9999);			
                $fuConfig['max_size'] = 20000;			
                $this->Fileupload->init($fuConfig);	
                if (!$this->Fileupload->upload('file')){
                    $fError = $this->Fileupload->errors();
                } else {
                    $item = $this->Fileupload->output('file_name');
                    $this->request = $this->request->withData('filename',$this->request->getData()['file']['name']);
                    $this->request = $this->request->withData('filesrc', $item);
                }
            }
            $this->request = $this->request->withData('user_id',$this->Auth->user('id') );
            $ticketcomment = $this->Ticketcomments->patchEntity($ticketcomment, $this->request->getData());
            
            if ($this->Ticketcomments->save($ticketcomment)) {
                $this->Flash->success(__d('Ticketing', 'The ticketcomment has been saved.'));
                return $this->redirect($this->referer());
            }
            $this->Flash->error(__d('Ticketing', 'The ticketcomment could not be saved. Please, try again.'));
        }
        $users = $this->Ticketcomments->Users->find('list', ['limit' => 200]);
        $tickets = $this->Ticketcomments->Tickets->find('list', ['limit' => 200]);
        $this->set(compact('ticketcomment', 'users', 'tickets'));
    }

    public function edit($id = null)
    {
        $ticketcomment = $this->Ticketcomments->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $ticketcomment = $this->Ticketcomments->patchEntity($ticketcomment, $this->request->getData());
            if ($this->Ticketcomments->save($ticketcomment)) {
                $this->Flash->success(__d('Ticketing', 'The ticketcomment has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__d('Ticketing', 'The ticketcomment could not be saved. Please, try again.'));
        }
        $users = $this->Ticketcomments->Users->find('list', ['limit' => 200]);
        $tickets = $this->Ticketcomments->Tickets->find('list', ['limit' => 200]);
        $this->set(compact('ticketcomment', 'users', 'tickets'));
    }

    public function close($id = null)
    {
        $this->Tickets = TableRegistry::get('Ticketing.Tickets');
        $this->request->allowMethod(['post']);
        $ticketcomment = $this->Tickets->get($id);
        if ($this->Tickets->query()->update()
            ->set(['completed' => date('Y-m-d h:i:s') ])
            ->where(['id' => $ticketcomment['id'] ])
            ->execute()) {
            $this->Flash->success(__d('Ticketing', 'The ticketcomment has been closed.'));
        } else {
            $this->Flash->error(__d('Ticketing', 'The ticketcomment could not be closed. Please, try again.'));
        }

        return $this->redirect($this->referer());
    }
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $ticketcomment = $this->Ticketcomments->get($id);
        if ($this->Ticketcomments->delete($ticketcomment)) {
            $this->Flash->success(__d('Ticketing', 'The ticketcomment has been deleted.'));
        } else {
            $this->Flash->error(__d('Ticketing', 'The ticketcomment could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
