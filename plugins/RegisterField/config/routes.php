<?php
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use Cake\Routing\Route\DashedRoute;

Router::plugin(
    'RegisterField',
    ['path' => '/admin/registerfield/'],
    function (RouteBuilder $routes) {
        $routes->connect('/', ['controller' => 'Home']);
        $routes->fallbacks(DashedRoute::class);
    }
);
Router::plugin(
    'RegisterField',
    ['path' => '/admin/register-field/'],
    function (RouteBuilder $routes) {
        $routes->connect('/', ['controller' => 'Home']);
        $routes->fallbacks(DashedRoute::class);
    }
);