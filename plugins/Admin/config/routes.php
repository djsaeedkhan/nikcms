<?php
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use Cake\Routing\Route\DashedRoute;

/* Router::plugin(
    'Admin',
    ['path' => '/admin'],
    function (RouteBuilder $routes) {
        $routes->connect('/', ['controller' => 'Dashboard', 'action' => 'index', 'home']);
        $routes->fallbacks(DashedRoute::class);
    }
);

Router::plugin(
    'Admin',
    ['path' => '/savecomments'],
    function (RouteBuilder $routes) {
        $routes->connect('/', ['controller' => 'Comments', 'action' => 'save'])->setMethods(['POST']);
        $routes->fallbacks(DashedRoute::class);
    }
); */
