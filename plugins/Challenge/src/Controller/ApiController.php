<?php
namespace Challenge\Controller;
use Challenge\Controller\AppController;
use Cake\ORM\TableRegistry;

class ApiController extends AppController
{
    //-----------------------------------------------------
    public function initialize(): void
    {
        parent::initialize();
        //$this->loadComponent('Admin.Fileupload');
        //$this->viewBuilder()->setLayout("login");
        //$this->Authentication->addUnauthenticatedActions();
    }
    //-----------------------------------------------------
    public function index($ch_id = null){
        if($this->request->getQuery('challenge_id'))
            $ch_id  = $this->request->getQuery('challenge_id');

        if($ch_id == null)
            return false;

        if ($this->request->getQuery('type') ) {
            switch ( $this->request->getQuery('type') ) {
                case 'challengequests':
                    return $this->_challengequests($ch_id);
                    break;
                
                default:
                    # code...
                    break;
            }
        }
        $this->autoRender = false;
    }

    private function _challengequests($ch_id = null){
        
        if ($this->request->getQuery('ajax') and $this->request->getQuery('ajax') ==  1) {

            if(!in_array($_SERVER["HTTP_HOST"],['najm.cfss.ir','localhost','hdf.ssnet.ir'])){
                $response = $this->response->withType('application/json')->withStringBody('error07');
                return $response;  
            }

            $lists = [];
            $pp = $this->Challengequests
                ->find('threaded')
                ->where([ 'challenge_id'=> $ch_id])
                ->select(['id','types','title','parent_id'])
                ->order(['id' =>'asc'])
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
                    ->where(['challenge_id'=> $ch_id , ])
                    ->select(['id','types','title','parent_id'])
                    ->enablehydration(false)
                    ->toarray();
            }
            $response = $this->response->withType('application/json')->withStringBody(json_encode($lists));
            return $response;
        }
    }
}