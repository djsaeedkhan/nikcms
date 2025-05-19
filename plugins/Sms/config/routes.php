<?php
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use Cake\Routing\Route\DashedRoute;

Router::plugin(
    'Sms',
    ['path' => '/admin/sms/'],
    function (RouteBuilder $routes) {
        $routes->connect('/', ['controller' => 'Home']);
        $routes->connect('/log', ['controller' => 'Home','action'=>'logs']);
        $routes->connect('/setting', ['controller' => 'Home','action'=>'setting']);
        $routes->connect('/sendsms', ['controller' => 'Home','action'=>'sendsms']);
        $routes->fallbacks(DashedRoute::class);
    }
);
Router::plugin(
    'Sms',
    ['path' => '/sms/activation'],
    function (RouteBuilder $routes) {
        $routes->connect('/activate', ['controller' => 'View','action'=>'active']);
        $routes->connect('/', ['controller' => 'View']);
        $routes->fallbacks(DashedRoute::class);
    }
);

Router::plugin(
    'Sms',
    ['path' => '/sms/'],
    function (RouteBuilder $routes) {
        $routes->connect('/autoactivate', ['controller' => 'View','action'=>'autoactivate']);
        $routes->connect('/', ['controller' => 'View']);
        $routes->fallbacks(DashedRoute::class);
    }
);