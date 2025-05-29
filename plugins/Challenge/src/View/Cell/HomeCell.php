<?php
namespace Challenge\View\Cell;

use Cake\ORM\TableRegistry;
use Cake\View\Cell;

/**
 * Home cell
 */
class HomeCell extends Cell
{

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


        $chlist = $this->getTableLocator()->get('Challenge.Challenges')
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

        $query =  $this->getTableLocator()->get('Challenge.Challengeviews')->find('list',['keyField' => 'challenge_id','valueField' => 'count']);
        $view = $query->select([
                //'challenge_id',
                'count' => $query->func()->sum('views'),
                ])
            ->toarray();
        $this->set([
            'challenge_all' => $this->getTableLocator()->get('Challenge.Challenges')->find('all')->count(),
            'userprofile_all' => $this->getTableLocator()->get('Challenge.Challengeuserprofiles')->find('all')->count(),
            'userforms_all' => $this->getTableLocator()->get('Challenge.Challengeuserforms')->find('all')->count(),
            'userform_today' => $this->getTableLocator()->get('Challenge.Challengeuserforms')->find('all')->where(['DATE(Challengeuserforms.created)' => date('Y-m-d')])->count(),
            'user_userforms_all' => $this->getTableLocator()->get('Challenge.Challengeuserforms')->find('all')->select(['user_id'])->group(['user_id'])->count(),
            'follower_all' => $this->getTableLocator()->get('Challenge.Challengefollowers')->find('all')->count(),
            'views_all' => isset($view[0])?$view[0]:'-',
            'user_all' => $this->getTableLocator()->get('Users')->find('all')->count(),
            //'challenge_all' => $this->getTableLocator()->get('Challenge.Challenges')->find('all')->toarray(),
        ]);
    }
    public function map(){
        $this->Challenges = $this->getTableLocator()->get('Challenge.Challenges');
        /* $users = $this->Challenges->Challengeuserforms
            ->find('list',['keyField' => 'user_id','valueField' => 'user_id'])
            ->toarray(); */

        $users = $this->Challenges->Challengeuserforms
            ->find('list',['keyField' => 'user_id','valueField' => 'user_id'])
            ->toarray();
        $count = count($users);

        $this->Challengeuserprofiles = $this->getTableLocator()->get('Challenge.Challengeuserprofiles');

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

        $query =  $this->getTableLocator()->get('Challenge.Challengeviews')->find('list',['keyField' => 'challenge_id','valueField' => 'count']);
        $view = $query->select([
                //'challenge_id',
                'count' => $query->func()->sum('views'),
                ])
            ->toarray();

        $this->set([
            'views_all' => isset($view[0])?$view[0]:0,
            'challenge_all' => $this->getTableLocator()->get('Challenge.Challenges')->find('all')->count(),
            //'userprofile_all' => $this->getTableLocator()->get('Challenge.Challengeuserprofiles')->find('all')->count(),
            'userforms_all' => $this->getTableLocator()->get('Challenge.Challengeuserforms')->find('all')->count(),
           // 'userform_today' => $this->getTableLocator()->get('Challenge.Challengeuserforms')->find('all')->where(['DATE(Challengeuserforms.created)' => date('Y-m-d')])->count(),
            //'user_userforms_all' => $this->getTableLocator()->get('Challenge.Challengeuserforms')->find('all')->select(['user_id'])->group(['user_id'])->count(),
            'follower_all' => $this->getTableLocator()->get('Challenge.Challengefollowers')->find('all')->count(),
            'user_all' => $this->getTableLocator()->get('Users')->find('all')->count(),
        ]);

    }
}
