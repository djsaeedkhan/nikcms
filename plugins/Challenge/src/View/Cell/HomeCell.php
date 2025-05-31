<?php
declare(strict_types=1);

namespace Challenge\View\Cell;

use Cake\View\Cell;
use Cake\ORM\TableRegistry;

/**
 * Home cell
 */
class HomeCell extends Cell
{
    /**
     * List of valid options that can be passed into this
     * cell's constructor.
     *
     * @var array<string, mixed>
     */
    protected $_validCellOptions = [];

    /**
     * Initialization logic run at the end of object construction.
     *
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();
    }

    /**
     * Default display method.
     *
     * @return void
     */
    public function display($data = null){
        $ids = [];
        $iconlist = [];
        for($i=1;$i<10;$i++):if(setting['box2__title'.$i] != ''): 
            if(setting['box2__ids'.$i] != ''){
                $node = array_unique(explode(';',setting['box2__ids'.$i]));
                $iconlist[setting['box2__entitle'.$i]] = $node ;
                foreach($node  as $k)
                    $k != ''?array_push($ids , $k):'';
            }
        endif;endfor;


        $chlist = TableRegistry::getTableLocator()->get('Challenge.Challenges')
            ->find('all')
            ->where(['enable'=>1,'Challenges.id IN' => array_unique($ids) ])
            ->contain([
                /* 'Challengefollowers' => function ($q) {
                    return $q
                        ->select([
                            'challenge_id',
                            'count' => $q->func()->count('*') ])
                        ->group(['challenge_id']);
                }, */
                'Challengecats',
                'Challengestatuses',
                'Challengetopics',
                ///'Challengetags'
                ])
            ->order(['Challenges.id'=>'desc'])
            ->toarray();
            
        $this->set([
            'chlist' =>$chlist,
            'iconlist' => $iconlist
        ]);
    }
    
    public function dashboard(){

        $query =  TableRegistry::getTableLocator()->get('Challenge.Challengeviews')->find('list',['keyField' => 'challenge_id','valueField' => 'count']);
        
        $view = 0;
        try {
            $view = $query->select([
                //'challenge_id',
                'count' => $query->func()->sum('views'),
                ])
            ->toarray();
        } catch (\Throwable $th) {
           $view = 0;
        }
        
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
        ]);
    }
    public function map(){
        $this->Challenges = TableRegistry::getTableLocator()->get('Challenge.Challenges');
        /* $users = $this->Challenges->Challengeuserforms
            ->find('list',['keyField' => 'user_id','valueField' => 'user_id'])
            ->toarray(); */

        $users = $this->Challenges->Challengeuserforms
            ->find('list',['keyField' => 'user_id','valueField' => 'user_id'])
            ->toarray();
        $count = count($users);

        $this->Challengeuserprofiles = TableRegistry::getTableLocator()->get('Challenge.Challengeuserprofiles');

        $query = $this->Challengeuserprofiles->find('list',['keyField' => 'provice','valueField' => 'count']);
        $all = $query->select([
                'provice',
                'count' => $query->func()->count('*'),
                ])
            ->where(['user_id IN'=> $users])
            ->group(['provice'])
            ->toarray();
        
        $this->set([
            'count' => $count,
            'all'=> $all
        ]);

        $query =  TableRegistry::getTableLocator()->get('Challenge.Challengeviews')->find('list',['keyField' => 'challenge_id','valueField' => 'count']);
        $view = $query->select([
                //'challenge_id',
                'count' => $query->func()->sum('views'),
                ])
            ->toarray();

        $this->set([
            'views_all' => isset($view[0])?$view[0]:0,
            'challenge_all' => TableRegistry::getTableLocator()->get('Challenge.Challenges')->find('all')->count(),
            //'userprofile_all' => TableRegistry::getTableLocator()->get('Challenge.Challengeuserprofiles')->find('all')->count(),
            'userforms_all' => TableRegistry::getTableLocator()->get('Challenge.Challengeuserforms')->find('all')->count(),
           // 'userform_today' => TableRegistry::getTableLocator()->get('Challenge.Challengeuserforms')->find('all')->where(['DATE(Challengeuserforms.created)' => date('Y-m-d')])->count(),
            //'user_userforms_all' => TableRegistry::getTableLocator()->get('Challenge.Challengeuserforms')->find('all')->select(['user_id'])->group(['user_id'])->count(),
            'follower_all' => TableRegistry::getTableLocator()->get('Challenge.Challengefollowers')->find('all')->count(),
            'user_all' => TableRegistry::getTableLocator()->get('Users')->find('all')->count(),
        ]);

    }
}
