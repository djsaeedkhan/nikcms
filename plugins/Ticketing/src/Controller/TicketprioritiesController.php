<?php
namespace Ticketing\Controller;

use Ticketing\Controller\AppController;

class TicketprioritiesController extends AppController
{
    public function index()
    {
        $ticketpriorities = $this->paginate($this->Ticketpriorities);
        $this->set(compact('ticketpriorities'));
    }
   
    public function add($id = null){
        if($id != null)
            $ticketpriority = $this->Ticketpriorities->get($id);
        else
            $ticketpriority = $this->Ticketpriorities->newEntity();

        if ($this->request->is(['patch', 'post', 'put'])) {
            $ticketpriority = $this->Ticketpriorities->patchEntity($ticketpriority, $this->request->getData());
            if ($p = $this->Ticketpriorities->save($ticketpriority)) {
                $this->Flash->success(__d('Ticketing', 'The ticketpriority has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__d('Ticketing', 'The ticketpriority could not be saved. Please, try again.'));
        }
        $this->set(compact('ticketpriority'));
    }
    
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $ticketpriority = $this->Ticketpriorities->get($id);
        if ($this->Ticketpriorities->delete($ticketpriority)) {
            $this->Flash->success(__d('Ticketing', 'The ticketpriority has been deleted.'));
        } else {
            $this->Flash->error(__d('Ticketing', 'The ticketpriority could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}