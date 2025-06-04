<?php
namespace Mpdfs\Controller;
use Mpdfs\Controller\AppController;
use Cake\ORM\TableRegistry;
use \Mpdfs\CreatePdf;

class HomeController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->viewBuilder()->setLayout('Admin.default');
    }
    public function index(){
        $this->autoRender = false;
        /* 
            $pdf = new Createpdf;
            $pdf->show([
                'سلام حال شما خوب است',
                'Welcome Saeed'
            ],[
                'filename'=>'F/saeed.pdf',
                'filedest'=>'F',
                'SetFooter'=>'صفحه {PAGENO}',
                'SetHeader'=>['text'=>'saeed'],
            ]);
        */
    }
}