<?php
namespace Admin\Controller;
use Admin\Controller\AppController;
use Cake\ORM\TableRegistry;
class DashboardController extends AppController {
    public function initialize(): void
    {
        parent::initialize();
    }
    public function index(){
        $this->set([
            'count_post'=>
                TableRegistry::getTableLocator()->get('Admin.Posts')->find('all')->where(['post_type !='=>'media'])->count(),
            'count_comment'=>
                TableRegistry::getTableLocator()->get('Admin.Comments')->find('all')->where(['parent_id' => 0])->count(),
            'count_users'=>
                TableRegistry::getTableLocator()->get('Users')->find('all')->count(),
            'count_media'=>
                TableRegistry::getTableLocator()->get('Admin.Posts')->find('all')->where(['post_type'=>'media'])->count()
        ]);
    }
    public function update(){}
    public function help(){}
    public function about(){}
    public function test(){}
}