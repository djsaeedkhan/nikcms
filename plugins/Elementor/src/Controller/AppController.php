<?php

namespace Elementor\Controller;

use App\Controller\AppController as BaseController;

class AppController extends BaseController
{
    public function initialize(){
        parent::initialize();
        $this->ViewBuilder()->setLayout('Admin.default');
    }
}
