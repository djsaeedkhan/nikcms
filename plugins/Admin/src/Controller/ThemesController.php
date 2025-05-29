<?php
namespace Admin\Controller;

use Admin\Controller\AppController;
use App\Model\Table\Options;
use Cake\ORM\TableRegistry;
use Admin\Controller\AppController;

class ThemesController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
    }
    //----------------------------------------------------------
    public function index(){
        if ($this->request->is('post')) {
            $result = $this->Func->OptionSave('website_template', $this->request->getParam('?')['theme'],'create');
            if($result)
                $this->Flash->success(__d('Admin', 'The Template has been saved.'));
            else
                $this->Flash->error(__d('Admin', 'The Template could not be saved. Please, try again.'));
            return $this->redirect($this->referer());
        }
        $this->set('result',$this->Func->plugin_getlist());
        $this->set('template',$this->Func->OptionGet('website_template'));
    }
    //----------------------------------------------------------
    public function template(){
        $p = $this->_activity();
        $visit = false;
        $visiter = false;
        if(is_array($p)){
            foreach($p as $pk => $pv){
                if(
                    $pk != $this->request->getAttribute('identity')->get('session_hash') 
                    and 
                    $pv['url'] == $this->_currenturl()
                    ){
                    $visit = true;
                    $visiter = isset($pv['username'])?$pv['username']:'-';
                }
            }
        }
        
        if($visit){
            $this->Flash->error(
                __d('Admin', 'کاربر').
                ' <b> '.$visiter.'</b> '.
                __d('Admin', 'در 10 دقیقه اخیر دراین صفحه فعالیت داشته و ممکن است همچنان در حال تغییر در این صفحه باشد.<br>
             توجه داشته باشید که اعمال تغییرات شما ممکن است با تغییرات کاربر دیگر ایجاد تداخل کند.'));
        }
        
        if( $this->Func->Optionget('lang_enable') == 1)
            $model = TableRegistry::get("Admin.Options2");
        else
            $model = TableRegistry::get("Admin.Options");
            
        $setting['setting'] = $model->find('all')
            ->where(['name'=> 'setting'.(defined('template_slug')?'_'.template_slug :'')  ])
            ->first();
        if(isset($setting['setting']['value']))
            $setting['setting'] = $setting['setting']['value'];
        else
            $setting['setting'] = NULL;  
        $this->set([
            'result' => $setting,
            'AllMenu' => $this->Func->AllMenu()
            ]);
    }
    //----------------------------------------------------------
    public function Menu($id = null){
        if($this->request->getQuery('delete')){
            $tag = $this->Themes->find('all')->where(['id'=> $this->request->getQuery('delete')]);
            if($tag->first()){  
                if ($this->Themes->delete($this->Themes->get( $tag->first()['id'] ))) {
                    $this->Flash->success(__d('Admin', 'The menu has been deleted.'));
                } else {
                    $this->Flash->error(__d('Admin', 'The menu could not be deleted. Please, try again.'));
                }
            }
            return $this->redirect(['action'=>'Menu']);
        }
        if($this->request->is('post')):
            $option = $this->Themes->newEmptyEntity();
            $data = [
                'id'=> isset($this->request->getData()['id'])?$this->request->getData()['id']:null,
                'name'=>$this->request->getData()['name'],
                'types'=>'nav_menu',
                'value'=> isset($this->request->getData()['data'])?serialize($this->request->getData()['data']):null,
            ];
            if(strtolower($id) == 'new')
                unset($data['id'],$data['value']);

            $option = $this->Themes->patchEntity($option,$data);
            if ($this->Themes->save($option)) {
                $this->Flash->success(__d('Admin', 'The theme has been saved.'));
                if(strtolower($id) == 'new')
                    return $this->redirect(['?'=>['id'=>$option['id']]]);
                else
                    return $this->redirect($this->referer());
            }
            $this->Flash->error(__d('Admin', 'The theme could not be saved. Please, try again.'));
		endif;
		//----------------------------
        $nav =[];
        $current = null;
        if(strtolower($id) == 'new'){
           $this->set('new_menu',1) ;
        }
        elseif($this->request->getQuery('menu')){
            $nav = $this->Themes->find('all')->
                select(['id','name','value'])->
                where(['types'=>'nav_menu','id'=>$this->request->getQuery('menu')])->
                order(['id'=>'desc']);
            $current = $this->request->getQuery('menu');
        }
        else{
            $nav = $this->Themes->find('all')->select(['id','name','value'])->where(['types'=>'nav_menu'])->order(['id'=>'desc']);
            $current = $nav->count()?$nav->first()['id']:null;
        }

		$this->set([
            "menu_current" => $nav?$nav->first():[] ,
            "menu_list" => $this->Themes->find('list')->select(['id','name'])->where(['types'=>'nav_menu'])->order(['id'=>'desc']),
            'menu_current_id'=> $current,
            ]);
    }
    //----------------------------------------------------------
    public function Widget($id = null){
        $theme = $this->Themes->newEmptyEntity();
        if ($this->request->is('post')) {
            $theme = $this->Themes->patchEntity($theme, $this->request->getData());
            if ($this->Themes->save($theme)) {
                $this->Flash->success(__d('Admin', 'The theme has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__d('Admin', 'The theme could not be saved. Please, try again.'));
        }
        $this->set(compact('theme'));
    }
    //----------------------------------------------------------
    public function beforeFilter(EventInterface $event)
    {
        //parent::beforeFilter($event);
        //$user = $this->request->getAttribute('identity');
        //pr($user['role']);
        $this->Authentication->addUnauthenticatedActions('*');
        $this->Auth->deny(['index']);
    }
}