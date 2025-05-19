<?php
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use Cake\Routing\Route\DashedRoute;

Router::plugin(
    'Predata',
    ['path' => '/admin/Predata/'],
    function (RouteBuilder $routes) {
        $routes->connect('/', ['controller' => 'Home']);
        $routes->fallbacks(DashedRoute::class);
    }
);