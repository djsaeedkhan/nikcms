<?php
namespace Challenge\Controller;
use Challenge\Controller\AppController;
use Cake\ORM\TableRegistry;

class AdminController extends AppController
{
    //-----------------------------------------------------
    public function initialize(): void
    {
        parent::initialize();
        $this->Challenges = TableRegistry::getTableLocator()->get('Challenge.Challenges');
    }
    //-----------------------------------------------------
    public function index($id = null){

        if(isset($this->request->getParam('?')['text'])){
            $search = $this->request->getParam('?')['text'];
            $challenges = $this->paginate(
                $this->Challenges->find('all')
                ->contain(['Challengestatuses', 'Users','ChallengeFollowers','Challengeuserforms'])
                ->where([
                    'OR'=>[
                        'Challenges.title LIKE'=>'%'.$search.'%',
                        'Challenges.descr LIKE'=>'%'.$search.'%',
                    ]
                ]));
        }
        else{
            $challenges = $this->paginate(
                $this->Challenges->find('all')
                    ->contain(['Challengestatuses', 'Users','Challengefollowers','Challengeuserforms'])
                    ->order(['Challenges.id'=>'desc'])
            );
        }
        $this->set(compact('challenges'));
    }
    //-----------------------------------------------------
    public function add() {
        $challenge = $this->Challenges->newEmptyEntity();
        if ($this->request->is('post')) {
            $this->request = $this->request->withData('user_id',$this->request->getAttribute('identity')->get('id') );
            $challenge = $this->Challenges->patchEntity($challenge, $this->request->getData());
            if ($this->Challenges->save($challenge)) {
                $this->Flash->success(__('The challenge has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The challenge could not be saved. Please, try again.'));
        }
        $challengestatuses = $this->Challenges->Challengestatuses->find('list', ['limit' => 200]);
        $users = $this->Challenges->Users->find('list', ['limit' => 200]);
        $challengecats = $this->Challenges->Challengecats->find('list', ['limit' => 200]);
        $challengetopics = $this->Challenges->Challengetopics->find('list', ['limit' => 200]);
        $challengefields = $this->Challenges->Challengefields->find('list', ['limit' => 200]);
        $challengetags = $this->Challenges->Challengetags->find('list', ['limit' => 200]);
        $related = $this->Challenges->find('list', ['limit' => 200]);

        $this->set(compact('related','challenge', 'challengestatuses', 'users','challengetopics', 'challengecats', 'challengetags','challengefields'));
    }
    //-----------------------------------------------------
    public function view($id = null){
        $challenge = $this->Challenges->get($id, [
            'contain' => [
                'Challengestatuses',
                'Users',
                'Challengecats',
                'Challengefields',
                'Challengetags',
                'Challengetopics',
                'Challengefollowers',
                'Challengeforums',
                'Challengeforumtitles',
                'Challengeimages',
                //'Challengemetas',
                'Challengepartners',
                'Challengerelateds'=>['Challenges'],
                'Challengetexts',
                'Challengetimelines',
                'Challengeuserforms',
                'Challengeviews'
            ],
            /* 'contain' => [
                'Challengestatuses', 
                'Users',
                'Challengetopics', 
                'Challengefields',
                'Challengecats', 
                'Challengetags',
                'Challengeforumtitles', 
                'Challengeimages',
                'Challengepartners', 
                'Challengetexts', 
                'Challengetimelines', 
                'Challengeviews',
                'Challengeuserforms',
                'Challengerelateds'=>['Challenges']], */
        ]);

        $this->set([
            'follower' => $this->Challenges->Challengefollowers->find('all')->where(['challenge_id'=>$id])->count(),
            'challenge' => $challenge,
            'chnews' => $this->Query->post('chnews',[
                'contain_where'=>[ 'meta_key'=>'challenge_id', 'meta_value'=>$id]
            ]),
            'chresource' => $p = $this->Query->post('chresource',[
                'contain_where'=>[
                    'meta_key'=>'challenge_id',
                    'meta_value'=>$id
                    ]
            ]),
            'chupdates' => $this->Query->post('chupdates',[
                'contain_where'=>[ 'meta_key'=>'challenge_id', 'meta_value'=>$id]
            ]),
        ]);
    }
    //-----------------------------------------------------
    public function edit($id = null)
    {
        $challenge = $this->Challenges->get($id, [
            'contain' => ['Challengecats', 'Challengetags','Challengetopics','Challengefields','Challengerelateds'],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $challenge = $this->Challenges->patchEntity($challenge, $this->request->getData());
            if ($this->Challenges->save($challenge)) {

                $this->Flash->success(__('The challenge has been saved.'));
                return $this->redirect(['action' => 'view',$id]);
            }
            $this->Flash->error(__('The challenge could not be saved. Please, try again.'));
        }
        $challengestatuses = $this->Challenges->Challengestatuses->find('list', ['limit' => 200]);
        $users = $this->Challenges->Users->find('list', ['limit' => 200]);
        $challengecats = $this->Challenges->Challengecats->find('list', ['limit' => 200]);
        $challengetopics = $this->Challenges->Challengetopics->find('list', ['limit' => 200]);
        $challengefields = $this->Challenges->Challengefields->find('list', ['limit' => 200]);
        $challengetags = $this->Challenges->Challengetags->find('list', ['limit' => 200]);
        $related = $this->Challenges->find('list', ['limit' => 200]);

        $this->set(compact('related','challenge', 'challengestatuses', 'challengefields','users','challengetopics', 'challengecats', 'challengetags'));
        $this->render('add');
    }
    //-----------------------------------------------------
    public function delete($id = null){
        $this->request->allowMethod(['post', 'delete']);
        $challenge = $this->Challenges->get($id);
        if ($this->Challenges->delete($challenge)) {
            $this->Flash->success(__('The challenge has been deleted.'));
        } else {
            $this->Flash->error(__('The challenge could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
    //-----------------------------------------------------
    public function report(){
        
        $query =  TableRegistry::getTableLocator()->get('Challenge.Challengeviews')->find('list',['keyField' => 'challenge_id','valueField' => 'count']);
        $view = $query->select(['count' => $query->func()->sum('views'),])->toarray();

        $query =  TableRegistry::getTableLocator()->get('Challenge.challengeuserprofiles')
            ->find('list',['keyField' => 'gender','valueField' => 'count'])
            ->select(['gender'])
            ->group(['gender']);
        $malefemale = $query->select(['count' => $query->func()->count('gender') ])->toarray();  

        $query =  TableRegistry::getTableLocator()->get('Challenge.challengeuserprofiles')
            ->find('list',['keyField' => 'eductions','valueField' => 'count'])
            ->select(['eductions'])
            ->group(['eductions']);
        $eduction = $query->select(['count' => $query->func()->count('eductions') ])->toarray();

        $this->set([
            'challenge_all' => TableRegistry::getTableLocator()->get('Challenge.Challenges')->find('all')->count(),
            'userprofile_all' => TableRegistry::getTableLocator()->get('Challenge.Challengeuserprofiles')->find('all')->count(),
            'userforms_all' => TableRegistry::getTableLocator()->get('Challenge.Challengeuserforms')->find('all')->count(),
            'userform_today' => TableRegistry::getTableLocator()->get('Challenge.Challengeuserforms')->find('all')->where(['DATE(Challengeuserforms.created)' => date('Y-m-d')])->count(),
            'user_userforms_all' => TableRegistry::getTableLocator()->get('Challenge.Challengeuserforms')->find('all')->select(['user_id'])->group(['user_id'])->count(),
            'follower_all' => TableRegistry::getTableLocator()->get('Challenge.Challengefollowers')->find('all')->count(),
            'views_all' => isset($view[0])?$view[0]:'-',
            'user_all' => TableRegistry::getTableLocator()->get('Users')->find('all')->count(),
            //'challenge_all' => TableRegistry::getTableLocator()->get('Challenge.Challenges')->find('all')->toarray(),

            'userprofile_malefemale' => $malefemale,
            'userprofile_eduction' => $eduction,
        ]);

    }
}