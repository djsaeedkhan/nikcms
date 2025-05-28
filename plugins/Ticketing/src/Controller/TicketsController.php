<?php
namespace Ticketing\Controller;

use Cake\ORM\TableRegistry;
use Ticketing\Controller\AppController;

class TicketsController extends AppController
{
    public function index() {
        $this->paginate = [
            'contain' => ['Ticketstatuses','Ticketpriorities', 'Users', 'Agents', 'Posts', 'Ticketcategories',
                'Ticketcomments'=>function ($q) {
                    return $q->order(['id'=>'desc']);//->limit(10);
                }],
            'order'=>['id'=>'desc']
        ];

        $ticket = $this->Tickets->find('all')
            ->contain(['Ticketstatuses', 'Ticketpriorities', 'Users', 'Agents', 'Posts', 'Ticketcategories',
                'Ticketcomments'=>function ($q) {
                    return $q->order(['id'=>'desc']);//->limit(10);
                }])
            ->order(
                $this->request->getQuery('sort')?
                    ['Tickets.'.$this->request->getQuery('sort')=>$this->request->getQuery('direction')]:
                    ['Tickets.id'=>'desc']
            );

        if($this->request->getQuery('text')){
            $temp = TableRegistry::getTableLocator()->get('Lms.Users')->find('list', ['keyField' =>'id','valueField'=>'id'])
                ->where([
                    'OR'=>[
                        'username LIKE '=>'%'.$this->request->getQuery('text').'%',
                        'phone LIKE '=>'%'.$this->request->getQuery('text').'%',
                        'family LIKE '=>'%'.$this->request->getQuery('text').'%',
                    ]
                ])
                ->toarray();
            if(count($temp) > 0)
            $ticket = $ticket->where(['Tickets.user_id IN '=>  $temp]);
            else{
                $ticket = $ticket->where(['OR'=>[
                        is_numeric($this->request->getQuery('text'))?['Tickets.id LIKE ' => '%'.$this->request->getQuery('text').'%']:[],
                        'Tickets.subject LIKE ' => '%'.$this->request->getQuery('text').'%',
                        'Tickets.content LIKE ' => '%'.$this->request->getQuery('text').'%',
                        'Tickets.phone_number LIKE ' => '%'.$this->request->getQuery('text').'%',
                        'Tickets.email LIKE ' => '%'.$this->request->getQuery('text').'%',
                    ]
                ]);
            }
        }
        if ($this->request->getQuery('user_id')) {
            $ticket = $ticket->where([
                'Tickets.user_id' =>$this->request->getQuery('user_id'),
            ]);
        }
        $tickets = $this->paginate($ticket);
        $this->set(compact('tickets'));

        if ($this->request->getQuery('tocsv')) {
            $u = $ticket->limit(100000000)->toArray();
            $list = [];
            $header = [
                __d('Ticketing', 'ش تیکت'),
                __d('Ticketing', 'وضعیت'),
                __d('Ticketing', 'عنوان تیکت'),
                __d('Ticketing', 'آخرین پیام'),
                __d('Ticketing', 'کاربر'),
                __d('Ticketing', 'وضعیت'),
                __d('Ticketing', 'اولویت'),
                __d('Ticketing', 'دسته بندی'),
                __d('Ticketing', 'تاریخ ثبت'),
            ];
            foreach($u as $us){ 
                $temp = [
                    'id'=>$us->id,
                    'completed'=>$us->completed?
                        __d('Ticketing', 'تکمیل شده'):
                        __d('Ticketing', 'تکمیل نشده'),

                    'subject'=>h(strip_tags($us->subject)),
                    'last_ticket'=>($us->has('ticketcomments') and count($us['ticketcomments']) > 0)?h(strip_tags($us['ticketcomments'][0]['content'])):'',
                    'user_id'=> $us->has('user') ?$us->user->Fname:'',
                    'status'=> $us->has('ticketstatus') ? $us->ticketstatus->title: '',
                    'priority'=> $us->has('ticketpriority') ? $us->ticketpriority->title : '',
                    'category'=> $us->has('ticketcategory') ? $us->ticketcategory->title : '',
                    'created'=> $this->Func->date2($us->created) ,
                ];
                array_push($list, $temp);
            }
            $this->Func->tocsv($list, $header);
        }
    }
    //---------------------------------------------------------------------
    public function comment($id = null) {
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
                    'sort' => ['Ticketcomments.id' => 'DESC'],
                    'Users']],
        ]);
        $this->set('ticket', $ticket);
    }
    //---------------------------------------------------------------------
    public function add($id = null) {
        if($id == null)
            $ticket = $this->Tickets->newEmptyEntity(();
        else
            $ticket = $this->Tickets->get($id);

        if ($this->request->is(['post'])) {

            if (!empty($this->request->getData()['file']['name'])) {
                $fuConfig['upload_path'] = WWW_ROOT . 'tickets/';
                if (!file_exists($fuConfig['upload_path'])) {
                    mkdir($fuConfig['upload_path'], 0777, true);
                }
                $fuConfig['allowed_types'] = 'zip|rar|pdf|jpg|doc|mp3|mp4';
                $fuConfig['file_name'] = 'tka'.$this->request->getAttribute('identity')->get('id').date('mdh').rand(1000, 9999);
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
            $this->Ticketcomments= TableRegistry::getTableLocator()->get('Admin.Ticketcomments');
            foreach ($this->request->getData()['user_id'] as $user_id) {
                $ticket = $this->Tickets->newEmptyEntity(();
                $this->request = $this->request->withData('user_id', $user_id);
                $ticket = $this->Tickets->patchEntity($ticket, $this->request->getData());
                if ($this->Tickets->save($ticket)) {

                    if(!empty($this->request->getData()['file']['name'])) {	
                        $ticketcomment = $this->Ticketcomments->newEmptyEntity(();
                        $ticketcomment = $this->Ticketcomments->patchEntity($ticketcomment, [
                            'content'=>$ticket->content,
                            'user_id'=>$this->request->getAttribute('identity')->get('id'),
                            'ticket_id'=>$ticket->id,
                            'filename' => $this->request->getData()['file']['name'],
                            'filesrc' => $item,
                            'modified'=>date('Y-m-d H:i:s'),
                            'created'=>date('Y-m-d H:i:s'),
                        ]);
                        $this->Ticketcomments->save($ticketcomment);
                    }

                    $this->Flash->success(__d('Ticketing', 'ایجاد تیکت با موفقیت ایجاد شد برای کاربر ') .' #'.$user_id);
                }
                else
                    $this->Flash->error(__d('Ticketing', 'متاسفانه ایجاد تیکت انجام نشد برای کاربر ') .' #'.$user_id);
            }
            return $this->redirect($this->referer());
        }

        if ($this->request->is(['patch', 'put'])) {
            $ticket = $this->Tickets->patchEntity($ticket, $this->request->getData() );
            if ($this->Tickets->save($ticket)) {
                $this->Flash->success(__d('Ticketing', 'بروز رسانی تیکت با موفقیت انجام شد'));
            }
            else
                $this->Flash->error(__d('Ticketing', 'متاسفانه بروزرسانی تیکت انجام نشد'));
            return $this->redirect($this->referer());
        }

        $ticketstatuses = $this->Tickets->Ticketstatuses->find('list');
        $ticketpriorities = $this->Tickets->Ticketpriorities->find('list');
        $users = $this->Tickets->Users
            ->find('list', ['keyField'=>'id','valueField'=>'Fname'])
            ->where(['role_id !='=>1]);

        $agents = $this->Tickets->Agents
            ->find('list', ['keyField'=>'id','valueField'=>'Fname'])
            ->where(['role_id'=>1]);

        $posts = $this->Tickets->Posts->find('list', ['limit' => 200]);
        $ticketcategories = $this->Tickets->Ticketcategories->find('list');
        $this->set(compact('ticket', 'ticketstatuses', 'ticketpriorities', 'users', 'agents', 'posts', 'ticketcategories'));
    }
    //---------------------------------------------------------------------
    public function delete($id = null)
    {
        if ($id == null and $this->request->getQuery('id')) {
            $id = $this->request->getQuery('id');
            $this->request->allowMethod(['get', 'delete']);
        } else {
            $this->request->allowMethod(['post', 'delete']);
        }
        foreach ($id as $ids) {
            $ticket = $this->Tickets->get($ids);
            $comments = $this->Tickets->Ticketcomments
                ->find('all')
                ->where(['Ticketcomments.ticket_id'=>$ids])
                ->toarray();
                
            if ($this->Tickets->delete($ticket)) {
                foreach ($comments as $comment) {
                    @unlink(WWW_ROOT . 'tickets/'.$comment['filesrc']);
                }
                $this->Flash->success(__d('Ticketing', 'تیکت با موفقیت حذف شد ') .' #'. $ids);
            } else {
                $this->Flash->error(__d('Ticketing', 'متاسفانه تیکت حذف نشد ') .' #'.$ids);
            }
        }

        return $this->redirect(['action' => 'index']);
    }
    //---------------------------------------------------------------------
}