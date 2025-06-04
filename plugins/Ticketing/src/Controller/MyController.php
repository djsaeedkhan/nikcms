<?php
namespace Ticketing\Controller;
use Ticketing\Controller\AppController;
use Cake\ORM\TableRegistry;

class MyController extends AppController
{
    //-------------------------------------------------------------------------------
    public function initialize(): void
    {
        parent::initialize();
        if (isset($this->setting['client_webview']) and $this->setting['client_webview'] == 1) {
            try {
                $this->viewBuilder()->setLayout('Template.default-ticket');
            } catch (\Throwable $th) {
                $this->viewBuilder()->setLayout('Ticketing.default');
            }
        }
        else 
            $this->viewBuilder()->setLayout('Admin.default');

        $this->Tickets =  TableRegistry::getTableLocator()->get('Ticketing.Tickets');
        $this->Ticketcomments = TableRegistry::getTableLocator()->get('Ticketing.Ticketcomments');
    }
    //---------------------------------------------------------------------
    public function index($page = "index", $id = null) {       
        $this->set(['current'=>$page]);
        switch ($page) {
            case 'new':
                $this->add();
                $this->render('add');
                break;

            case 'closed':
                $tickets = $this->Tickets->find('all')
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
                    ->where(['completed IS NOT NULL ','Tickets.user_id'=> $this->request->getAttribute('identity')->get('id') ])
                    ->order(['Tickets.id'=>'desc'])
                    ->toarray();
                $this->set(compact('tickets'));
                $this->render('index');
                break;

            default:
                $tickets = $this->Tickets->find('all')
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
                    ->where(['completed IS NULL ','Tickets.user_id'=> $this->request->getAttribute('identity')->get('id') ])
                    ->order(['Tickets.id'=>'desc'])
                    ->toarray();
                $this->set(compact('tickets'));
                $this->render('index');
                break;
        }
    }
    //---------------------------------------------------------------------
    public function submit($id = null ) {
        $this->set(['current'=>'submit']);
        
        $ticketcomment = $this->Ticketcomments->newEmptyEntity();
        if ($this->request->is('post')) {
            
            if (!empty($this->request->getData()['file']['name'])) {	
                $fuConfig['upload_path'] = WWW_ROOT . 'tickets/';
                if (!file_exists($fuConfig['upload_path'])) {
                    mkdir($fuConfig['upload_path'], 0777, true);
                }
                $fuConfig['allowed_types'] = 'zip|rar|pdf|jpg';
                $fuConfig['file_name'] = 'tk'.$this->request->getAttribute('identity')->get('id').'_'.date('m-d-h').'_'.rand(1000,9999);			
                $fuConfig['max_size'] = 20000;
                $this->Fileupload->init($fuConfig);
                if (!$this->Fileupload->upload('file')) {
                    $fError = $this->Fileupload->errors();
                } else {
                    $item = $this->Fileupload->output('file_name');
                    $this->request = $this->request->withData('filename', $this->request->getData()['file']['name']);
                    $this->request = $this->request->withData('filesrc', $item);
                }
            }
            if (isset($this->request->getData()['subject']))
                $this->request = $this->request->withData('subject', strip_tags($this->request->getData()['subject']));
            
            if (isset($this->request->getData()['content']))  
                $this->request = $this->request->withData('content', strip_tags($this->request->getData()['content']));
                
            $ticketcomment = $this->Ticketcomments->patchEntity($ticketcomment, $this->request->getData());
            $ticketcomment['user_id'] = $this->request->getAttribute('identity')->get('id');

            if ($this->Ticketcomments->save($ticketcomment)) {
                $this->Func->create_admin_alert('ticketing', [
                    'slug' => 'submit_ticket',
                    'title' => __d('Ticketing', 'پاسخ تیکت ثبت شد'),
                    'link' => '/admin/ticketing/ticketcomments/index/' ]);

                $this->Flash->success(__d('Ticketing', 'ثبت پاسخ با موفقیت انجام شد'));
                return $this->redirect($this->referer());
            }
            $this->Flash->error(__d('Ticketing', 'متاسفانه ثبت پاسخ انجام نشد'));
        }
        
        $ticket = $this->Tickets->get($id, [
            'contain' => [
                'Ticketstatuses', 
                'Ticketpriorities', 
                'Users', 
                'Agents', 
                'Posts', 
                'Ticketcategories', 
                'Ticketaudits', 
                'Ticketcomments'=>[
                    'sort' => [
                        'Ticketcomments.id' =>((isset($this->setting['client_reply_order']) and $this->setting['client_reply_order'] == 'ASC')?'ASC':'DESC')],
                    'Users']],
        ]);
        $this->set('ticket', $ticket);
        $this->render('comment');
    }
    //---------------------------------------------------------------------
    private function add() {
        $ticket = $this->Tickets->newEmptyEntity();

        if ($this->request->is(['post'])) {
            $this->request = $this->request->withData('subject', strip_tags($this->request->getData()['subject']));
            $this->request = $this->request->withData('content', strip_tags($this->request->getData()['content']));
            $ticket = $this->Tickets->patchEntity($ticket, $this->request->getData());
            $ticket['user_id']= $this->request->getAttribute('identity')->get('id');
            if ($this->Tickets->save($ticket)) {

                if (!empty($this->request->getData()['file']['name'])) {	
                    $fuConfig['upload_path'] = WWW_ROOT . 'tickets/';
                    if (!file_exists($fuConfig['upload_path'])) {
                        mkdir($fuConfig['upload_path'], 0777, true);
                    }
                    $fuConfig['allowed_types'] = 'zip|rar|pdf|jpg';
                    $fuConfig['file_name'] = 'tk'.$this->request->getAttribute('identity')->get('id').'_'.date('m-d-h').'_'.rand(1000,9999);
                    $fuConfig['max_size'] = 20000;
                    $this->Fileupload->init($fuConfig);	
                    if (!$this->Fileupload->upload('file')) {
                        $fError = $this->Fileupload->errors();
                    } else {
                        $item = $this->Fileupload->output('file_name');
                        $this->request = $this->request->withData('filename', $this->request->getData()['file']['name']);
                        $this->request = $this->request->withData('filesrc', $item);

                        $ticketcomment = $this->Ticketcomments->patchEntity($this->Ticketcomments->newEmptyEntity(), $this->request->getData());
                        $ticketcomment['user_id'] = $this->request->getAttribute('identity')->get('id');
                        $ticketcomment['ticket_id'] = $ticket->id;
                        if($this->Ticketcomments->save($ticketcomment))
                            $this->Flash->success(__d('Ticketing', 'آپلود فایل ضمیمه با موفقیت انجام شد'));
                        else
                            $this->Flash->error(__d('Ticketing', 'متاسفانه آپلود فایل ضمیمه انجام نشد'));
                    }
                }
                $this->Flash->success(__d('Ticketing', 'ثبت اطلاعات با موفقیت انجام شد'));
                $this->Func->create_admin_alert('ticketing', [
                    'slug' => 'new_ticket',
                    'descr'=>' ',
                    'title' => __d('Ticketing', 'تیکت جدید ثبت شد'),
                    'link' => '/admin/ticketing/tickets/index/']);

                return $this->redirect('/tickets/index');
            }
            $this->Flash->error(__d('Ticketing', 'متاسفانه ثبت اطلاعات با موفقیت انجام نشد'));
        }
        $ticketpriorities = $this->Tickets->Ticketpriorities->find('list', ['limit' => 200]);
        $ticketcategories = $this->Tickets->Ticketcategories->find('list', ['limit' => 200]);
        $this->set(compact('ticket', 'ticketpriorities', 'ticketcategories'));
    }
    //---------------------------------------------------------------------
    public function query($id = null) {
        $ticket = $this->Tickets->newEmptyEntity();
        if ($this->request->is('post')) {
            $ticket = $this->Tickets->patchEntity($ticket, []);
            $ticket->subject = strip_tags($this->request->getData()['subject']);
            $ticket->post_id = $this->request->getData()['post_id'];
            $ticket->alert_type = $this->request->getData()['alert_type'];
            $ticket->post_id = $id;
            $ticket->user_id = $this->request->getAttribute('identity')->get('id');
            if ($this->Tickets->save($ticket))
                $this->Flash->success(__d('Ticketing', 'تیکت با موفقیت ثبت گردید'));
            else
                $this->Flash->error(__d('Ticketing', 'متاسفانه تیکت شما ثبت نشد، لطفا دوباره اقدام نمایید'));
        }
        return $this->redirect($this->referer());
    }
    //---------------------------------------------------------------------
}