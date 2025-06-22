<?php
namespace Userslogs;
use Cake\ORM\TableRegistry;
use Cake\I18n\FrozenTime;

class UserLogg
{
    protected $_defaultConfig = [
        'cache' => true,
    ];
    public $user_id;
    public $UsersLogs;
    public function __construct(){}
    public function login_savelog($user = [], $types = null){
        $this->UsersLogs = TableRegistry::getTableLocator()->get('UsersLogs');
        $r = $this->UsersLogs->patchEntity(
            $this->UsersLogs->newEmptyEntity() , [
                'user_id' => isset($user['id'])?$user['id'] : null,
                'username' => isset($user['username'])? $user['username'] : null,
                'types' => $types , //1:succ 2:faild
                'created' => date('Y-m-d h:i:s'),
            ]);
        try {
            $p = $this->UsersLogs->save($r);
            return $p;
        } catch (\Throwable $th) {
            return false;
        }
    }
    
    public function login_firstvisit($user = [], $types = null){
        $this->UsersLogs = TableRegistry::getTableLocator()->get('UsersLogs');
        $r = $this->UsersLogs->find('all')
            ->where(['user_id' => isset($user['id'])?$user['id']:null]);
        if($r->count() > 1)
            return true;
        else 
            return false;
    }
    public function login_check_failed($user = [], $option = []){
        $this->UsersLogs = TableRegistry::getTableLocator()->get('UsersLogs');
        try {
            $time = (isset($option['types'])?$option['types'] : 15);
            return $this->UsersLogs->find('all')
            ->where([
                'username' => isset($user['username'])? $user['username'] :null,
                'types'=> isset($option['types'])?$option['types'] : 2,
                'created >=' => FrozenTime::now()->modify('-'.$time.' minutes')
            ])
            ->count();
        } catch (\Throwable $th) {
            return false;
        }
    }
}
