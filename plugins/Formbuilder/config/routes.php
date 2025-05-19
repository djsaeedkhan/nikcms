<?php
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use Cake\Routing\Route\DashedRoute;

Router::plugin(
    'Formbuilder',
    ['path' => '/admin/formbuilder/'],
    function (RouteBuilder $routes) {
        $routes->connect('/', ['controller' => 'Home']);
        $routes->fallbacks(DashedRoute::class);
    }
);

Router::plugin(
    'Formbuilder',
    ['path' => '/form/*'],
    function (RouteBuilder $routes) {
        $routes->connect('/', ['controller' => 'View','action'=>'index']);
        $routes->fallbacks(DashedRoute::class);
    }
);