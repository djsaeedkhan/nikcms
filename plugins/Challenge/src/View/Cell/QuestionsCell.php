<?php
namespace Challenge\View\Cell;

use Cake\View\Cell;
use Cake\ORM\TableRegistry;

/**
 * Questions cell
 */
class QuestionsCell extends Cell
{
    /**
     * List of valid options that can be passed into this
     * cell's constructor.
     *
     * @var array
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
    public function display($ch_id = null)
    {
        $challenge= TableRegistry::get('Challenge.Challenges')->find('all')->where(['id'=> $ch_id])->first();
        $this->Challengequests = TableRegistry::get('Challenge.Challengequests');
        if(! $challenge){
            $this->Flash->error('چنین '.__d('Template', 'همیاری').' پیدا نشد');
            return $this->redirect($this->referer());
        }
        $this->set(['challenge'=>$challenge]);

        $this->Challengeqanswers = TableRegistry::get('Challenge.Challengeqanswers');
        //--------------------------------------------------------------------------------
        //--------------------------------------------------------------------------------
        if ($this->request->getQuery('chid') and $this->request->getQuery('chid') !=  '') {
            $temp = explode(',',$this->request->getQuery('chid') );
            $chresult = $this->Challengeqanswers->find('all')
                ->where([ 'Challengeqanswers.challenge_id'=> $temp[0] , 'user_id' => $temp[1] ])
                ->order([ 'Challengeqanswers.id' =>'asc' ])
                ->contain(['Challengequests'])
                ->enablehydration(false)
                ->toarray();

            $qlist = $this->Challengequests->find('list',['keyField' => 'id','valueField' => 'title'])
                ->where([ 'challenge_id'=> $temp[0] ])
                ->enablehydration(false)
                ->toarray();

            $this->set([
                'chresult' => $chresult ,
                'qlist' => $qlist
                ]);
        }

        $this->Challengequests->recover();
        $parentCategory = $this->Challengequests
            ->find('threaded')
            ->order(['priority'=>'asc'])
            ->where(['challenge_id'=> $ch_id]);
        $this->set(compact('parentCategory','ch_id'));
    }
}