<?php
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use Cake\Routing\Route\DashedRoute;

Router::plugin(
    'Widget',
    ['path' => '/admin/widget/'],
    function (RouteBuilder $routes) {
        $routes->connect('/', ['controller' => 'Home', 'action' => 'index']);
        $routes->fallbacks(DashedRoute::class);
    }
);
