<?php
declare(strict_types=1);

namespace SSS\Controller;

use App\Controller\AppController;

/**
 * Users Controller
 *
 * @property \SSS\Model\Table\UsersTable $Users
 * @method \SSS\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Roles'],
        ];
        $users = $this->paginate($this->Users);

        $this->set(compact('users'));
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => ['Roles', 'Logs', 'Challengetags', 'Challengeblueticks', 'Challengefollowers', 'Challengeforums', 'Challengeqanswers', 'Challenges', 'Challengeuserforms', 'Challengeuserprofiles', 'Comments', 'FormbuilderDatas', 'LmsCertificates', 'LmsCoursefilecans', 'LmsCourses', 'LmsCoursesessions', 'LmsCourseusers', 'LmsExamresultlists', 'LmsExamresults', 'LmsExams', 'LmsExamusers', 'LmsFactors', 'LmsPayments', 'LmsUserfactors', 'LmsUsernotes', 'LmsUserprofiles', 'PollVotes', 'Posts', 'Profiles', 'ShopAddresses', 'ShopFavorites', 'ShopLogesticusers', 'ShopOrderlogesticlogs', 'ShopOrderlogestics', 'ShopOrderlogs', 'ShopOrderrefunds', 'ShopOrders', 'ShopOrdershippings', 'ShopOrdertexts', 'ShopOrdertokens', 'ShopPayments', 'ShopProfiles', 'ShopUseraddresses', 'SmsValidations', 'Ticketaudits', 'Ticketcomments', 'Tickets', 'TmpChallengeforms', 'TmpMembers', 'TmpPersonlikes', 'TmpPersons', 'TmpProblemforms', 'TmpProblems', 'UserMetas'],
        ]);

        $this->set(compact('user'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user = $this->Users->newEmptyEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $roles = $this->Users->Roles->find('list', ['limit' => 200])->all();
        $logs = $this->Users->Logs->find('list', ['limit' => 200])->all();
        $challengetags = $this->Users->Challengetags->find('list', ['limit' => 200])->all();
        $this->set(compact('user', 'roles', 'logs', 'challengetags'));
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => ['Logs', 'Challengetags'],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $roles = $this->Users->Roles->find('list', ['limit' => 200])->all();
        $logs = $this->Users->Logs->find('list', ['limit' => 200])->all();
        $challengetags = $this->Users->Challengetags->find('list', ['limit' => 200])->all();
        $this->set(compact('user', 'roles', 'logs', 'challengetags'));
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
