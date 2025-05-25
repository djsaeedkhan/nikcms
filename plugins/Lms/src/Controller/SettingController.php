<?php
namespace Lms\Controller;
use Lms\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\I18n\Time;

class SettingController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->viewBuilder()->setLayout('Admin.default');
    }
    public function index(){
        $result = $this->Func->OptionGet('plugin_lms');
        $this->set('result', $result);
    }
}