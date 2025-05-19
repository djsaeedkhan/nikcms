<?php
namespace Ticketing\Controller;

use Ticketing\Controller\AppController;


class TicketstatusesController extends AppController
{
    public function index()
    {
        $ticketstatuses = $this->paginate($this->Ticketstatuses);
        $this->set(compact('ticketstatuses'));
    }
    public function add($id = null){
        if($id != null)
            $ticketstatus = $this->Ticketstatuses->get($id);
        else
            $ticketstatus = $this->Ticketstatuses->newEntity();
        if ($this->request->is(['patch', 'post', 'put'])) {
            $ticketstatus = $this->Ticketstatuses->patchEntity($ticketstatus, $this->request->getData());
            if ($this->Ticketstatuses->save($ticketstatus)) {
                $this->Flash->success(__d('Ticketing', 'The ticketstatus has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__d('Ticketing', 'The ticketstatus could not be saved. Please, try again.'));
        }
        $this->set(compact('ticketstatus'));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $ticketstatus = $this->Ticketstatuses->get($id);
        if ($this->Ticketstatuses->delete($ticketstatus)) {
            $this->Flash->success(__d('Ticketing', 'The ticketstatus has been deleted.'));
        } else {
            $this->Flash->error(__d('Ticketing', 'The ticketstatus could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
