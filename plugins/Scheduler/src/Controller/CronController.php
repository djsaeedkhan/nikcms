<?php
namespace Scheduler\Controller;
use Scheduler\Controller\AppController;
use Admin\View\Helper\ModuleHelper;
use Cake\I18n\Time;
use Cake\ORM\TableRegistry;

class CronController extends AppController
{
    public function initialize(): void
    {
        //Configure::write('debug', 0);
        parent::initialize();
        $this->Authentication->addUnauthenticatedActions();
        $this->autoRender = false;
        $this->crons = $this->getTableLocator()->get('Scheduler.Cronjobs');
    }
    public function index(){
        $enable = false;
        $result = $this->Func->OptionGet('plugin_scheduler');
        if(isset($result)){
            $result = unserialize($result);
            if(isset($result['enable']) and $result['enable'] == 1)
                $enable = true;
        }

        if($enable == true):
            $crons  = (array) ModuleHelper::register_cronjobs();
            while( count($crons) > 0 ){
                foreach($crons as $id => $cron){
                    if($cron['order'] == 'hight2'){
                        unset($crons[$id]);
                        $this->check_cron($cron);
                    }
                }
                foreach($crons as $id => $cron){
                    if($cron['order'] == 'hight'){
                        unset($crons[$id]);
                        $this->check_cron($cron);
                    }
                }
                foreach($crons as $id => $cron){
                    if($cron['order'] == 'medium'){
                        unset($crons[$id]);
                        $this->check_cron($cron);
                    }
                }
                foreach($crons as $id => $cron){
                    if($cron['order'] == 'low'){
                        unset($crons[$id]);
                        $this->check_cron($cron);
                    }
                }
                $cron = [];
            }
            return $this->response->withStringBody('Cronjobs Is Working ... ');
        else:
            return $this->response->withStringBody('Cronjobs Is Disabled');
        endif;

        
    }
    private function check_cron($cron = null){
        $id = $this->crons->find('all')->where(['name' => $cron['name']])->first();
        $out = '';
        if($id){
            $now = Time::now();
            $sdate = new Time($id['created']);
            $sdate->modify('+'. $cron['every']);
            //if(strtotime($sdate->format('Y-m-d H:i:s')) < strtotime($now->format('Y-m-d H:i:s'))){
                ob_start();
                try {
                    echo $this->cell($cron['widget'],[$cron])->render(false);
                    
                } catch (\Throwable $th) {
                    echo "no";
                }
                $out = ob_get_contents();
                $this->save_res($cron, $out);
            //}
        }
        else
            $this->save_res($cron, $out);
    }
    private function save_res($data = null, $descr = null){
        if( ($id = $this->crons->find('all')->where(['name'=> $data['name']])->first()))
            $cron = $this->crons->get($id['id']);
        else $cron = $this->crons->newEmptyEntity();
        
        $cron = $this->crons->patchEntity($cron, [
            'name' => $data['name'],
            'plugin' => $data['plugin'],
            'status' => 1,
            'result' => $descr,
            'created' =>date('Y-m-d H:i:s'),
        ]);
        $this->crons->save($cron);
    }
}