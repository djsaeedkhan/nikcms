<?php
namespace Ticketing\View\Cell;
use Cake\ORM\TableRegistry;
use Cake\View\Cell;
class HomeCell extends Cell
{
    public function user_dashboard(){

        $user_id = $this->request->getsession()->read('Auth.User.id');
        $tickets = $this->getTableLocator()->get('Ticketing.Tickets')->find('all')
                ->contain([
                    'Ticketstatuses', 
                    'Ticketpriorities', 
                    'Users', 
                    'Agents', 
                    'Posts', 
                    'Ticketcategories',
                    'Ticketcomments'=>function ($q) {
                        return $q->order(['id'=>'desc']);//->limit(10);
                    } 
                ])
                ->where(['completed IS NULL ','Tickets.user_id'=> $user_id ])
                ->order(['Tickets.id'=>'desc'])
                ->toarray();
        $this->set(compact('tickets'));
    }
}