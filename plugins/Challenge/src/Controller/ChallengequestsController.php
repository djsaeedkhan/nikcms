<?php
namespace Challenge\Controller;

use Cake\ORM\TableRegistry;
use Challenge\Controller\AppController;

class ChallengequestsController extends AppController
{
    //-----------------------------------------------------
    public function initialize(): void
    {
        parent::initialize();
        global $types;
        $types = [
            1 =>'چند گزینه ای (Radio)',
            2 =>'متنی (تشریحی)',
            3 => 'آپلود فایل',
            4 =>'چند انتخابی (Checkbox)',
            5 => 'سرتیتر (H1)',
            6 => 'سرتیتر (H2)',
            7 => 'سرتیتر (H3)',
            8 => 'متنی (Text)',
        ];
        $this->set('types',$types);
    }
    //-----------------------------------------------------
    public function index($ch_id = null)
    {
        $challenge= $this->getTableLocator()->get('Challenge.Challenges')->find('all')->where(['id'=> $ch_id])->first();
        if(! $challenge){
            $this->Flash->error('چنین '.__d('Template', 'همیاری').' پیدا نشد');
            return $this->redirect($this->referer());
        }
        $this->set(['challenge'=>$challenge]);

        $this->Challengeqanswers = $this->getTableLocator()->get('Challenge.Challengeqanswers');
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
        //--------------------------------------------------------------------------------
        //--------------------------------------------------------------------------------
        if ($this->request->is('post')) {
            $this->loadComponent('Admin.Fileupload');
            foreach( $this->request->getdata() as $k => $item){
                $temp = explode('_',$k );
                if(isset($temp[0]) and $temp[0] == 'file' and $item != ''){
                    $fuConfig['upload_path'] = WWW_ROOT . 'challenge/';
                    if (!file_exists($fuConfig['upload_path'])) {
                        mkdir($fuConfig['upload_path'], 0777, true);
                    }
                    $fuConfig['allowed_types'] = 'zip';
                    $fuConfig['file_name'] = 'ch'.$ch_id.'_'.$this->request->getAttribute('identity')->get('id').'_'.$k.'_'.date('m-d-h').'_'.rand(1000,9999);			
                    $fuConfig['max_size'] = 20000;			
                    $this->Fileupload->init($fuConfig);	
                    if (!$this->Fileupload->upload($k)){
                        $fError = $this->Fileupload->errors();
                    } else {
                        $item = $this->Fileupload->output('file_name');
                    }
                }
                $list[] = [
                    'challenge_id' => $ch_id,
                    'user_id' => $this->request->getAttribute('identity')->get('id'),
                    'types' => isset($temp[0])?$temp[0]:'-',
                    'challengequest_id' => isset($temp[1])?$temp[1]:'0',
                    'value' => is_array($item)?implode(',',$item):$item,
                ];
            }
            
            $answer = $this->Challengeqanswers->newEmptyEntity();
            $answer = $this->Challengeqanswers->patchEntities($answer,$list);
            if($this->Challengeqanswers->saveMany($answer))
                $this->redirect('?chid='.$ch_id.','.$this->request->getAttribute('identity')->get('id'));
        }
        //--------------------------------------------------------------------------------
        //--------------------------------------------------------------------------------
        if ($this->request->getQuery('ajax') and $this->request->getQuery('ajax') ==  1) {
            /* if(!in_array($_SERVER["HTTP_HOST"],['najm.cfss.ir','localhost','hdf.ssnet.ir'])){
                $response = $this->response->withType('application/json')->withStringBody('error07');
                return $response;  
            } */

            $lists = [];
            $pp = $this->Challengequests
                ->find('threaded')
                ->where(['challenge_id'=> $ch_id])
                ->select(['id','types','title','parent_id'])
                ->order(['priority' =>'asc'])
                ->enablehydration(false)
                ->toarray();

            if ($this->request->getQuery('parent') and $this->request->getQuery('parent') == "no" ) {
                foreach($pp as $k=> $pps){
                    if(isset($pps['children'])){
                        foreach($pps['children'] as $k2=> $pps2){
                            if(isset($pps2['children']))
                            unset($pp[$k]['children'][$k2]['children']);
                        }
                    }
                }
                $lists = $pp;
            }
            else{
                $lists = $this->Challengequests
                    ->find('children', ['for' => $this->request->getQuery('parent')  ])
                    ->find('threaded')
                    ->where(['challenge_id'=> $ch_id])
                    ->select(['id','types','title','parent_id'])
                    ->enablehydration(false)
                    ->toarray();
            }
            $response = $this->response->withType('application/json')->withStringBody(json_encode($lists));
            return $response;
        }
        //--------------------------------------------------------------------------------
        //--------------------------------------------------------------------------------

        if($ch_id == null)
            $this->redirect($this->referer());

        $this->Challengequests->recover();
        $parentCategory = $this->Challengequests
            ->find('threaded')
            ->order(['priority'=>'asc'])
            ->where(['challenge_id'=> $ch_id]);
        $this->set(compact('parentCategory','ch_id'));
    }

    public function add($ch_id = null, $parent_id = null)
    {
        $challengequest = $this->Challengequests->newEmptyEntity();
        if ($this->request->is('post')) {

            if($parent_id != null)
                $this->request = $this->request->withData('parent_id', ($parent_id==0?null:$parent_id) );

            $this->request = $this->request->withData('challenge_id', $ch_id );

            $challengequest = $this->Challengequests->patchEntity($challengequest, $this->request->getData());
            if ($this->Challengequests->save($challengequest)) {
                $this->Flash->success(__('The challengequest has been saved.'));

                return $this->redirect(['action' => 'index',$ch_id]);
            }
            $this->Flash->error(__('The challengequest could not be saved. Please, try again.'));
        }
        $challenges = $this->Challengequests->Challenges->find('list', ['limit' => 200]);
        $parentChallengequests = $this->Challengequests->ParentChallengequests
            ->find('treeList',['keyField'=>'id','valueField'=>'title','spacer' => '—'])
            ->where(['challenge_id'=> $ch_id ]);

        $this->set(compact('challengequest', 'challenges', 'parentChallengequests','parent_id'));
    }

    public function edit($ch_id = null , $id = null)
    {
        $challengequest = $this->Challengequests->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $challengequest = $this->Challengequests->patchEntity($challengequest, $this->request->getData());

            if($this->request->getData()['parent_id'] == $id or $this->request->getData()['parent_id'] ==null)
                unset($challengequest->parent_id);

            if ($this->Challengequests->save($challengequest)) {
                $this->Flash->success(__('The challengequest has been saved.'));
                return $this->redirect(['action' => 'index',$ch_id]);
            }
            $this->Flash->error(__('The challengequest could not be saved. Please, try again.'));
        }

        $challenges = $this->Challengequests->Challenges->find('list', ['limit' => 200]);
        $parentChallengequests = $this->Challengequests->ParentChallengequests
            ->find('treeList',['keyField'=>'id','valueField'=>'title','spacer' => '—'])
            ->where(['challenge_id'=> $ch_id ]);

        $this->set(compact('challengequest', 'challenges', 'parentChallengequests'));
    }

    public function delete($ch_id = null, $id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $challengequest = $this->Challengequests->get($id);
        if ($this->Challengequests->delete($challengequest)) {
            $this->Flash->success(__('The challengequest has been deleted.'));
        } else {
            $this->Flash->error(__('The challengequest could not be deleted. Please, try again.'));
        }
        return $this->redirect($this->referer());
    }

    public function report($ch_id = null)
    {
        $challenge= $this->getTableLocator()->get('Challenge.Challenges')->find('all')->where(['id'=> $ch_id])->first();
        if(! $challenge){
            $this->Flash->error('چنین '.__d('Template', 'همیاری').' پیدا نشد');
            return $this->redirect($this->referer());
        }
        $this->set(['challenge'=>$challenge]);

        $this->Challengeqanswers = $this->getTableLocator()->get('Challenge.Challengeqanswers');
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
        //--------------------------------------------------------------------------------
        //--------------------------------------------------------------------------------
        if ($this->request->getQuery('ajax') and $this->request->getQuery('ajax') ==  1) {
            /* if(!in_array($_SERVER["HTTP_HOST"],['najm.cfss.ir','localhost'])){
                $response = $this->response->withType('application/json')->withStringBody('error07');
                return $response;  
            } */
            if(($this->request->getQuery('q_id')) and $this->request->getQuery('q_id')!= ''){
                if($this->request->getQuery('type') and $this->request->getQuery('type')== 'select'){
                    $tmp = $this->Challengeqanswers->find('all')->where([
                        'value LIKE '=>'%'.intval($this->request->getQuery('q_id')).'%',
                        'types'=>'radio',
                        ])->count();
                }
                elseif($this->request->getQuery('type') and $this->request->getQuery('type')== 'check'){
                    $tmp = $this->Challengeqanswers->find('all')->where([
                        'value LIKE '=>'%'.intval($this->request->getQuery('q_id')).'%',
                        'types'=>'check',
                        ])->count();
                }
                else{
                    $tmp = $this->Challengeqanswers->find('all')->where([
                        'value !='=>'',
                        'challengequest_id'=>intval($this->request->getQuery('q_id'))
                        ])->count();
                }
                
            }else $tmp = '-';
            
            $response = $this->response->withType('application/json')->withStringBody($tmp);
            return $response;
        }
        //--------------------------------------------------------------------------------
        //--------------------------------------------------------------------------------

        if($ch_id == null)
            $this->redirect($this->referer());

        $this->Challengequests->recover();
        $parentCategory = $this->Challengequests
            ->find('threaded')
            ->order(['priority'=>'asc'])
            ->where(['challenge_id'=> $ch_id]);
        $this->set(compact('parentCategory','ch_id'));
    }
}
