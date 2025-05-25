<?php
namespace Website\Controller;

use App\Controller\AppController as BaseController;
use Cake\Event\EventInterface;

class AppController extends BaseController
{
    public function initialize(): void
    {
        parent::initialize();
    }

    public function beforeFilter(EventInterface $event)
    {
        //$this->Auth->allow();
        $this->Authentication->addUnauthenticatedActions();
    }
}
