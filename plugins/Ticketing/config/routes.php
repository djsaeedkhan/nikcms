<?php
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use Cake\Routing\Route\DashedRoute;

/* Router::plugin(
    'Ticketing',
    ['path' => '/admin/ticketing/'],
    function (RouteBuilder $routes) {
        $routes->connect('/', ['controller' => 'Tickets']);
        $routes->fallbacks(DashedRoute::class);
    }
);

Router::plugin(
    'Ticketing',
    ['path' => '/tickets/'],
    function (RouteBuilder $routes) {
        $routes->connect('/submit/:id', ['controller' => 'My','action'=>'submit'])->setPass(['id']);
        $routes->connect('/question/', ['controller' => 'My','action'=>'query']);
        $routes->connect('/:id', ['controller' => 'My', 'action' => 'index'])->setPass(['id']);
        $routes->connect('/', ['controller' => 'My','action'=>'index']);
        $routes->fallbacks(DashedRoute::class);
    }
); */
