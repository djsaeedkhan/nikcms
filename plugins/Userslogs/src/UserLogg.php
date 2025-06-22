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
        $this->UsersLogs = TableRegistry::getTableLocator()->get('Userslogs.UsersLogs');
        try {
            $r = $this->UsersLogs->patchEntity(
            $this->UsersLogs->newEmptyEntity() , [
                'user_id' => isset($user['id'])?$user['id'] : null,
                'username' => isset($user['username'])? $user['username'] : null,
                'types' => $types , //1:succ 2:faild
                'created' => date('Y-m-d h:i:s'),
            ]);
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

    public function login_check_failed($user = [], $options = []){
        $this->UsersLogs = TableRegistry::getTableLocator()->get('UsersLogs');
        try {
            $time = (isset($options['time'])?$options['time'] : 15);
            $limit = (isset($options['limit'])?$options['limit'] : 5);

            $result = $this->UsersLogs->find('all')
            ->where([
                'username' => isset($user['username'])? $user['username'] :null,
                //'created >=' => FrozenTime::now()->modify('-'.$time.' minutes')
            ])
            ->order(['UsersLogs.id'=>'desc'])
            ->limit($limit)
            ->toarray();
            
            $access = false;

            //اگر تعداد بررسی کمتر از حد مجاز بود
            if(count($result) < $limit)
                return true;

            // اگر آخرین لاگین موفق بود
            if(isset($result[0]) and $result[0]['types'] == 1)
                return true; 

            // اولین لاگین در سری جدید تلاش برای ورود
            $first_login = $result[count($result) - 1];
            if(isset($result[count($result) - 1]['types']) and $result[count($result) - 1]['types'] == 1)
                return true;
            
            $created = new FrozenTime($first_login['created']);
            $now = FrozenTime::now();
            $threshold = $now->modify('-'.$time.' minutes');
            if ($created < $threshold) {
                $access = true;
            }

            return $access;
        } catch (\Throwable $th) {
            return false;
        }
    }
}