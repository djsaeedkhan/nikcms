<?php
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use Cake\Routing\Route\DashedRoute;

Router::plugin(
    'Scheduler',
    ['path' => '/admin/scheduler/'],
    function (RouteBuilder $routes) {
        $routes->connect('/', ['controller' => 'Home']);
        $routes->fallbacks(DashedRoute::class);
    }
);
Router::plugin(
    'Scheduler',
    ['path' => '/dowithcronjobs/'],
    function (RouteBuilder $routes) {
        $routes->connect('/', ['controller' => 'Cron']);
        $routes->fallbacks(DashedRoute::class);
    }
);