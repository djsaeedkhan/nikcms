<?php
namespace Userslogs;
use Cake\ORM\TableRegistry;
use Cake\I18n\Time;

class UserLogg
{
    protected $_defaultConfig = [
        'cache' => true,
    ];
    public $user_id;
    public function __construct(){}
    public function login_savelog($user = [], $types = null){
        $this->UsersLogs = TableRegistry::getTableLocator()->get('UsersLogs');
        $r = $this->UsersLogs->patchEntity($this->UsersLogs->newEntity() , [
            'user_id' => isset($user['id'])? $user['id'] :false,
            'username' => isset($user['username'])? $user['username'] :false,
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
            ->where(['user_id' => isset($user['id'])?$user['id']:false]);
        if($r->count() > 1)
            return true;
        else return false;
    }
    public function login_check_failed($user = [], $types = null){
        $this->UsersLogs = TableRegistry::getTableLocator()->get('UsersLogs');

        $res = $this->UsersLogs->find('all')
            ->where([
                'username' => isset($user['username'])? $user['username'] :false,
                'types'=>2
            ])
            ->andWhere(function($exp) {
                $now = Time::now();
                $now->modify('-100 minutes');
                $exp->lte('created', Time::now() );
                $exp->gte('created', $now->format('Y-m-d h:i:s'));
                return $exp;
            })->count();
        try {
            //pr($res);
        } catch (\Throwable $th) {
            return false;
        }
    }
}
