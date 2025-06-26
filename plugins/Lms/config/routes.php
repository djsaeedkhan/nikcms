<?php
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use Cake\Routing\Route\DashedRoute;

/* Router::plugin(
    'Lms',
    ['path' => '/admin/lms/'],
    function (RouteBuilder $routes) {
        $routes->connect('/', ['controller' => 'Home']);
        $routes->fallbacks(DashedRoute::class);
    }
);

Router::plugin(
    'Lms',
    ['path' => '/lms/client/'],
    function (RouteBuilder $routes) {
        $routes->connect('/video/:id/', ['controller' => 'Client','action'=>'video'],['pass' => ['id']])
            ->setMethods(['PUT']);
        $routes->connect('/video', ['controller' => 'Client','action'=>'index']);
        $routes->connect('/:action/:id/', ['controller' => 'Client'],['pass' => ['id']]);
        $routes->connect('/course/', ['controller' => 'Client', 'action' => 'course'],['pass' => ['id']]);

        $routes->connect('/renewExam/:course/:exam', ['controller' => 'Client', 'action' => 'course','?'=>['do'=>'renewExam']],['pass' => ['course','exam']]);

        $routes->connect('/renew/:id/', ['controller' => 'Client', 'action' => 'course','?'=>['do'=>'renew']],['pass' => ['id']]);
        $routes->connect('/renew/:id/:month', ['controller' => 'Client', 'action' => 'course','?'=>['do'=>'renew']],['pass' => ['id','month']]);

        $routes->connect('/factors/', ['controller' => 'Client', 'action' => 'factors'],['pass' => ['id']]);
        $routes->connect('/payments/', ['controller' => 'Client', 'action' => 'payments'],['pass' => ['id']]);
        $routes->connect('/index/', ['controller' => 'Client', 'action' => 'index'],['pass' => ['id']]);
        $routes->connect('/dashboard/', ['controller' => 'Client', 'action' => 'index'],['pass' => ['id']]);
        $routes->connect('/', ['controller' => 'Client', 'action' => 'index']);
        $routes->fallbacks(DashedRoute::class);
    }
);

Router::plugin('Lms',['path' => '/lms/'],
    function (RouteBuilder $routes) {
        $routes->connect('/video/:id/', ['controller' => 'Guest','action'=>'video'],['pass' => ['id']])
            ->setMethods(['PUT']);
        $routes->connect('/video', ['controller' => 'Guest','action'=>'index']);
        $routes->connect('/view/:id/*', ['controller' => 'Guest','action'=>'courses'],['pass' => ['id']]);
        $routes->connect('/detail/:id/*', ['controller' => 'Guest','action'=>'courses','?'=>['detail'=>1]],['pass' => ['id']]);
        $routes->connect('/register/:id/*', ['controller' => 'Guest','action'=>'courses','?'=>['register'=>1]],['pass' => ['id']]);
        $routes->connect('/subscribe/:id/*', ['controller' => 'Guest','action'=>'subscribe'],['pass' => ['id']]);

        $routes->connect('/', ['controller' => 'Guest', 'action' => 'index']);
        $routes->fallbacks(DashedRoute::class);
    }
);
Router::plugin('Lms',['path' => '/lms/client/myexams'],
    function (RouteBuilder $routes) {
        $routes->connect('/:action/:id/', ['controller' => 'Client'],['pass' => ['id']]);
        $routes->connect('/', ['controller' => 'Client', 'action' => 'myexam']);
        $routes->fallbacks(DashedRoute::class);
    }
); */
