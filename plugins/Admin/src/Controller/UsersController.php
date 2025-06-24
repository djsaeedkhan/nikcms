<?php
namespace Admin\Controller;
use Admin\Controller\AppController;
use Cake\Controller\Exception\SecurityException;
use Cake\Event\EventInterface;
use Cake\ORM\TableRegistry;
use Cake\Auth\DefaultPasswordHasher;

class UsersController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
    }
    //--------------------------------------------------------------------
    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);
    }
    //--------------------------------------------------------------------
    public function index(){
        $user = $this->Users->find('all')
            ->contain([
                'Roles',
                'Profiles',
                'UserMetas',
                'UsersLogs' => function($q) {
                    return $q
                        ->order(['created' =>'DESC'])
                        ->limit(1);}
            
            ])
            ->order(['Users.id'=>'desc']);
        
        if($this->request->getQuery('text')){
            $user->where(['OR'=>[
                'family LIKE '=>'%'.$this->request->getQuery('text').'%',
                'username LIKE '=>'%'.$this->request->getQuery('text').'%',
                'email LIKE '=>'%'.$this->request->getQuery('text').'%',
            ]]);
        }

        if($this->request->is('post')){
            $u = $this->Users->find('all')
                ->contain(['Roles','Profiles','UserMetas'])
                ->order(['Users.id'=>'desc'])
                ->toarray();

            $list = [];
            $listkey = [];
            foreach($u as $us){
                foreach($us->user_metas as $meta)
                    array_push( $listkey ,$meta['meta_key'] );
            }
    
            $i=0;
            foreach($u as $us){
                $temp = [
                    'id'=>$us->id,
                    'username'=>$us->username,
                    'family'=>$us->family,
                    'email'=>$us->email,
                    'enable'=>$us->enable
                ];
                array_push( $list ,$temp );
    
                $m = [];
                foreach($us->user_metas as $meta){
                    $m[$meta['meta_key']] = $meta['meta_value'];
                    $list[$i][$meta['meta_key']] = trim(preg_replace('/\t+/', '', h($meta['meta_value']) ));
                }
                foreach($listkey as $lk){
                    if( !isset($list[$i][$lk]) )
                        $list[$i][$lk] = "";
                }
    
                krsort($list[$i]);
                $i+=1;
            }
            $this->Func->tocsv( $list);
        }
        $users = $this->paginate($user,['limit'=>50]);
        $activity = $this->_activity('getlist');
        $this->set(compact('users','activity'));
    }
    //--------------------------------------------------------------------
    public function view($id = null){
        if($id == null) $id = $this->request->getAttribute('identity')->get('id');
        
        try{
            $user = $this->Users->get($id, [
                'contain' => ['Posts']
            ]);
        }
        catch (\Exception $e) {
            $this->Flash->error(__d('Admin', 'کاربر پیدا نشد'));
            return $this->redirect($this->referer());
        }
        $this->set('user', $user);
    }
    //--------------------------------------------------------------------
    public function profile($id = null){
        
        /* 
        commented 1404/03/12
        if($this->request->getQuery('thumbnail')){
            $this->_Thumbnail($this->request->getQuery('thumbnail'));
        } */

        if($id == null or $this->request->getAttribute('identity')->get('role_id') != 1) 
            $id = $this->request->getAttribute('identity')->get('id');

        try{
            $user = $this->Users->get($id, ['contain' => ['UserMetas']]);
        }
        catch (\Exception $e) {
            $this->Flash->error(__d('Admin', 'کاربر پیدا نشد'));
            return $this->redirect($this->referer());
        }

        $meta_list = array();
        if(isset($user->user_metas))
            $meta_list = $this->Func->MetaList($user,'users');
        $this->set([
            'user' => $user,
            'meta_list' => $meta_list,
        ]);
    }    
    //--------------------------------------------------------------------
    public function add(){
        $user = $this->Users->newEmptyEntity();
        
        $this->Users = TableRegistry::getTableLocator()->get('Admin.Users');
        $user = $this->Users->newEmptyEntity();

        if ($this->request->is('post') and $this->request->getQuery('get')) {

            $list = [];
            $handle = fopen( $this->request->getdata()['file']['tmp_name'] , "r");
            for ($i = 0; $row = fgetcsv($handle ); ++$i) {
                $list[] = explode(";",$row[0]);
            }
            $title = $list[0];
            $allow = ['username','password','family','email','mobile','enable','role','expired'];
            unset($list[0]);

            
            foreach($list as $k => $lis){
                unset($list[$k]);
                foreach($lis as $ki => $li){
                    if(isset($title[$ki]))
                    $list[$k][$title[$ki]] = $li;
                }
            }

            $string = '';
            foreach($list as $lst){
                $value = array_values($lst);
                $username = isset($lst['username'])?$lst['username']:$value[0];

                $user = $this->Users->newEmptyEntity();
                $user = $this->Users->patchEntity($user,[
                    'username'=> $username,
                    'password'=> isset($lst['password'])?$lst['password']:'',
                    'family'=> isset($lst['family'])?$lst['family']:'',
                    'email'=> isset($lst['email'])?$lst['email']:'',
                    'phone'=> isset($lst['mobile'])?$lst['mobile']:'',
                    'enable'=> isset($lst['enable'])?$lst['enable']:'',
                    'role_id'=> isset($lst['role'])?$lst['role']:3,
                    'expired'=> isset($lst['expired'])?$lst['expired']:null,
                ]);
                if ($this->Users->save($user)) {
                    foreach($lst as $lk => $ls){
                        if(! in_array($lk ,  $allow)){
                            $this->Func->PostMetaSave($user->id,[
                                'source' =>'users',
                                'type' => 'meta',
                                'name' => $lk,
                                'value' => $ls,
                                'action' => 'create']);
                        }
                    }
                    $string .= __d('Admin', 'خوشبختانه').(' '.$username.' ') .__d('Admin', 'ذخیره شد').'<br>';
                }
                else
                    $string .= __d('Admin', 'X متاسفانه').(' '.$username.' ') .__d('Admin', 'ذخیره نشد').'<br>';
            }
            $this->Flash->success($string);
            return $this->redirect($this->referer());
        }
        elseif ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__d('Admin', 'The user has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__d('Admin', 'The user could not be saved. Please, try again.'));
        }

        if($this->request->getQuery('get') and $this->request->getQuery('get')=='group'){
            $this->render('add-group');
        }
        $this->set(compact('user'));
    }
    //--------------------------------------------------------------------
    public function edit($id = null){
        
        try{
            $user = $this->Users->get($id, ['contain' => ['UserMetas']]);
        }
        catch (\Exception $e) {
            $this->Flash->error(__d('Admin', 'کاربر پیدا نشد'));
            return $this->redirect($this->referer());
        }

        if ($this->request->is(['patch', 'put'])) {
            if($this->request->getData('password') == ''){
                $data = $this->request->getData();
                unset($data['password']);
                $this->request = $this->request->withParsedBody($data);
            }
            else{
                $this->Users = TableRegistry::getTableLocator()->get('Admin.Users');
            }

            if($this->request->getAttribute('identity')->get('role_id') != 1){
                $data = $this->request->getData();
                unset($data['username']);
                unset($data['token']);
                unset($data['enable']);
                unset($data['role_id']);
                $this->request = $this->request->withParsedBody($data);
            }
            $user = $this->Users->patchEntity($user, $this->request->getData());

            if ($result = $this->Users->save($user)) {
                if($this->request->getData('UserMetas') and count($this->request->getData('UserMetas'))):
                    foreach($this->request->getData('UserMetas') as $key => $val){
                        $this->Func->PostMetaSave($result->id,[
                            'source' =>'users',
                            'type' => 'meta',
                            'name' => $key,
                            'value' => $val,
                            'action' => 'create']);
                    }
                endif;

                $this->Flash->success(__d('Admin', 'کاربر با موفقیت بروزرسانی شد'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__d('Admin', 'The user could not be saved. Please, try again.'));
        }

        //$meta_list = array();
        if(isset($user->user_metas)){
            $meta_list = $this->Func->MetaList($user, 'users');
            $user['UserMetas'] = $meta_list;
        }

        $this->set([
            'user' => $user,
            'action' => 'edit',
            'meta_list' => $meta_list,
            ]);
        $this->render('add');
    }
    //--------------------------------------------------------------------
    public function delete($id = null){
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            TableRegistry::getTableLocator()->get("Admin.UserMetas")->deleteAll(['user_id' => $id]);
            $this->Flash->success(__d('Admin', 'The user has been deleted.'));
        } else {
            $this->Flash->error(__d('Admin', 'The user could not be deleted. Please, try again.'));
        }
        return $this->redirect($this->referer());
    }
    //--------------------------------------------------------------------
    public function add2(){
        $str = '';
        $str2 = (explode("\n", $str));
        foreach($str2 as $st){
            $temp = explode(',',$st);
            $user = $this->Users->newEmptyEntity();
            $user = $this->Users->patchEntity($user, [
                'family' => trim($temp[0]),
                'username' => trim($temp[1]),
                'password' => trim($temp[2]),
                'enable'=>1,
                'token'=>'1',
                'role_id'=>3
            ]);
            if ($this->Users->save($user)) {
                pr("inserted");
            }else pr("not In");
        }
    }
    //--------------------------------------------------------------------
}