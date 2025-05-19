<?php
namespace Admin\Controller;
use Admin\Controller\AppController;
use Cake\ORM\TableRegistry;
class DashboardController extends AppController {
    public function initialize(){
        parent::initialize();
    }
    public function index(){
        $this->set([
            'count_post'=>
                TableRegistry::get('Admin.Posts')->find('all')->where(['post_type !='=>'media'])->count(),
            'count_comment'=>
                TableRegistry::get('Admin.Comments')->find('all')->where(['parent_id' => 0])->count(),
            'count_users'=>
                TableRegistry::get('Users')->find('all')->count(),
            'count_media'=>
                TableRegistry::get('Admin.Posts')->find('all')->where(['post_type'=>'media'])->count()
        ]);
    }
    public function Update(){
    }
    public function Help(){
    }
    public function About(){
    }
    public function test(){   
    }
}