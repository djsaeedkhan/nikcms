<?php
namespace Challenge\Controller;

use Cake\ORM\TableRegistry;
use Challenge\Controller\AppController;
use Challenge\Predata;

class ChallengeusersController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->Users = TableRegistry::getTableLocator()->get('Challenge.Users');
        $this->Challengeuserprofiles = TableRegistry::getTableLocator()->get('Challenge.Challengeuserprofiles');
    }
    
    public function index(){
        if(isset($this->request->getParam('?')['text'])){
            $search = $this->request->getParam('?')['text'];
            $temp = $this->Users->find('all')
                ->where([ 'OR'=> [
                    'Users.username LIKE'=>'%'.$search.'%',
                    'Users.family LIKE'=>'%'.$search.'%',
                    'Users.email LIKE'=>'%'.$search.'%',
                ]])
                ->contain(['Challengeuserprofiles','UserMetas']);

            if( ! $temp->toarray()){
                $temp = $this->Users->find('all')
                    ->contain(['Challengeuserprofiles','UserMetas'])
                    ->matching('Challengeuserprofiles', function ($q) use ($search) {
                        return $q->where([
                            'OR'=>[
                                'Challengeuserprofiles.email LIKE ' => '%'.$search.'%',
                                'Challengeuserprofiles.mobile LIKE' => '%'.$search.'%',
                                'Challengeuserprofiles.codemeli LIKE' => '%'.$search.'%',
                                'Challengeuserprofiles.univercity LIKE' => '%'.$search.'%',
                            ],
                        ]);
                    });
            }
            $users = $this->paginate($temp);
        }
        else{
            $this->paginate = [
                'contain' => ['Challengeuserprofiles','UserMetas'],
                'order'=>['id'=>'desc']
            ];
            $users = $this->paginate($this->Users);
        }
        $this->set(compact('users'));

        if ($this->request->is('post') and isset($this->request->getParam('?')['getlist'])) {
            $u = $this->Users->find('all')
                ->contain(['Challengeuserprofiles','UserMetas','Challengeuserforms' =>['Challenges'] ])
                ->toarray();
            $list =[];
            $predata = new Predata();


            $chlist = TableRegistry::getTableLocator()->get('Challenge.Challenges')
                ->find('list',['keyField' => 'id','valueField' => 'title'])
                ->toarray();

                
            foreach($u as $us){
                $meta = $this->Func->MetaList($us,'users');
                $profile = isset($us->challengeuserprofiles[0])?$us->challengeuserprofiles[0]:[];
                $temp = [
                    'id'=>$us->id,
                    'username'=>$us->username,
                    'family'=>$us->family,
                    'codemeli'=> isset($profile['codemeli'])?$profile['codemeli']:'',
                    'gender'=> isset($profile['gender'])? $predata->getvalue('gender',$profile['gender']):'',
                    'provice'=> isset($profile['provice'])?$this->Func->province_list($profile['provice']):'',
                    'birth_date'=> isset($profile['birth_date'])?$profile['birth_date']:'',
                    'email_register'=>$us->email,
                    'email_profile'=> isset($profile['email2'])?$profile['email2']:'',
                    'mobile_profile'=> isset($profile['mobile'])?$profile['mobile']:'',
                    'mobile_register'=> isset($meta['mobile'])?$meta['mobile']:'',
                    'single'=> isset($profile['single'])? $predata->getvalue('group',$profile['single']):'',
                    'center'=> isset($profile['center'])? $predata->getvalue('center',$profile['center']):'',
                    'center_name'=> isset($profile['center_name'])?$profile['center_name']:'',
                    'semat'=> isset($profile['semat'])?$profile['semat']:'',
                    'field'=> isset($profile['field'])?$profile['field']:'',
                    'eductions'=> isset($profile['eductions'])? $predata->getvalue('eductions',$profile['eductions']):'',
                    'univercity'=> isset($profile['univercity'])?$profile['univercity']:'',
                    'enable'=>$us->enable,
                ];


                $temp1 = [];
                foreach($us['challengeuserforms'] as $uss){
                    $temp1[$uss['challenge_id']] = $uss['challenge_id'];
                }
                $temp2 = [];
                foreach($chlist as $kch => $vch){
                    if(isset($temp1[$kch]))
                        $temp2[$kch] = 1 ;
                    else
                        $temp2[$kch] = '-' ;
                }
                $temp += $temp2;
                array_push( $list ,$temp );
            }
            $this->Func->tocsv( $list);
        }
    }

    public function view($id = null){
        $user = $this->Users->get($id, [
            'contain' => [ 'Challengefollowers'=>['Challenges'], 'Challengeforums', 'Challenges', 'Challengeuserforms'=>['Challenges'], 
            'Challengeuserprofiles'=>['Challengetopics'],'UserMetas'],
        ]);
        $this->set('user', $user);
    }

    public function add($id = null)
    {
        if($id !=null){
            $user = $this->Users->get($id,['contain'=>'Challengeuserprofiles']);
        }
        else
            $user = $this->Users->newEmptyEntity(();

        if ($this->request->is(['patch', 'post', 'put'])) {
            //$this->request = $this->request->withData('challengeuserprofile',$this->request->getData() );

            $user = $this->Users->patchEntity($user, $this->request->getData() );
            if ($p = $this->Users->save($user)) {
                
                $profile = $this->Challengeuserprofiles->find('all')->where(['user_id'=>$id])->first();
                if(! $profile)
                    $profile = $this->Challengeuserprofiles->newEmptyEntity(();
                $this->request = $this->request->withData('challengeuserprofile.user_id', $id);
                $profile = $this->Challengeuserprofiles->patchEntity($profile, $this->request->getData()['challengeuserprofile'] );

                if ($this->Challengeuserprofiles->save($profile)) {
                    $this->Flash->success(__('ثبت اطلاعات پروفایل با موفقیت انجام شد'));
                }
                else{
                    $this->Flash->error(__('متاسفانه ثبت اطلاعات پروفایل انجام نشد'));
                }
                $this->Flash->success(__('ثبت اطلاعات کاربری با موفقیت انجام شد'));
                return $this->redirect($this->referer());
            }
            else
                $this->Flash->error(__('متاسفانه ثبت اطلاعات کاربری انجام نشد'));
        }
        $roles = $this->Users->Roles->find('list', ['limit' => 200]);
        $logs = $this->Users->Logs->find('list', ['limit' => 200]);
        $challengetags = $this->Users->Challengetags->find('list', ['limit' => 200]);
        $this->set(compact('user', 'logs', 'challengetags'));

        if($id !=null)
            $this->render('edit');
    }

    /* public function edit($id = null)
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
        $roles = $this->Users->Roles->find('list', ['limit' => 200]);
        $logs = $this->Users->Logs->find('list', ['limit' => 200]);
        $challengetags = $this->Users->Challengetags->find('list', ['limit' => 200]);
        $this->set(compact('user', 'roles', 'logs', 'challengetags'));
    } */

    /* public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    } */
}
