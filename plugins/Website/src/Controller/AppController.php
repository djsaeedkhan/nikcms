<?php
namespace Website\Controller;

use App\Controller\AppController as BaseController;
use Cake\Event\EventInterface;
use Authentication\Controller\Component\AuthenticationComponent;

class AppController extends BaseController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->Authorization->skipAuthorization();
    }

    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);
        $this->Authentication->addUnauthenticatedActions([
            'home', 'index', 'ajax','archive','category','catsingle','single','tag','search',
            'Getdata','robots','sitemap','sitemapIndex','image'
        ]);
    }
}
