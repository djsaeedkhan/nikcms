<?php
namespace Ticketing\Controller;

use Ticketing\Controller\AppController;

class TicketcategoriesController extends AppController
{

    public function index()
    {
        $ticketcategories = $this->paginate($this->Ticketcategories);

        $this->set(compact('ticketcategories'));
    }

    public function add($id = null)
    {
        if($id != null)
            $ticketcategory = $this->Ticketcategories->get($id);
        else
            $ticketcategory = $this->Ticketcategories->newEntity();
        if ($this->request->is(['patch', 'post', 'put'])) {
            $ticketcategory = $this->Ticketcategories->patchEntity($ticketcategory, $this->request->getData());
            if ($this->Ticketcategories->save($ticketcategory)) {
                $this->Flash->success(__d('Ticketing', 'The ticketcategory has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__d('Ticketing', 'The ticketcategory could not be saved. Please, try again.'));
        }
        $this->set(compact('ticketcategory'));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $ticketcategory = $this->Ticketcategories->get($id);
        if ($this->Ticketcategories->delete($ticketcategory)) {
            $this->Flash->success(__d('Ticketing', 'The ticketcategory has been deleted.'));
        } else {
            $this->Flash->error(__d('Ticketing', 'The ticketcategory could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
