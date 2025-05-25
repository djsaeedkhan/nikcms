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
                $this->getTableLocator()->get('Admin.Posts')->find('all')->where(['post_type !='=>'media'])->count(),
            'count_comment'=>
                $this->getTableLocator()->get('Admin.Comments')->find('all')->where(['parent_id' => 0])->count(),
            'count_users'=>
                $this->getTableLocator()->get('Users')->find('all')->count(),
            'count_media'=>
                $this->getTableLocator()->get('Admin.Posts')->find('all')->where(['post_type'=>'media'])->count()
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