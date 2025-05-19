<?php
namespace Postviews\Controller;

use Postviews\Controller\AppController;
use Cake\ORM\TableRegistry;
class HomeController extends AppController
{
    public function initialize(){
        parent::initialize();
        $this->ViewBuilder()->setLayout('Admin.default');
    }
    public function index() {
        /* $result = TableRegistry::getTableLocator()->get('Admin.PostMetas')
            ->find('all')
            ->where(['meta_key' =>'post_views'])
            ->order(['PostMetas.id' =>'DESC'])
            ->setTypeMap(['meta_value' => 'integer'])
            ->enableHydration(false)
            ->limit(10)
            ->toArray(); */

        /* $result->join([
            'table' => 'post_metas','alias' => "pm1",'type' => 'LEFT',
            'conditions' => ["pm1.post_id = Posts.id"] ]);
        $result->where(["pm1.meta_key"=>'post_views']); */

        /* $this->set('results',$result); */
    }
    public function setting(){
        $result = TableRegistry::getTableLocator()->get('Admin.Options')
            ->find('list',['keyField'=>'name','valueField'=>'value'])
            ->where(['name' => 'postviews_plugin'])
            ->toArray();
        $this->set('result', $result);
    }
}