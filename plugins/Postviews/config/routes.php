<?php
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use Cake\Routing\Route\DashedRoute;

Router::plugin('Postviews',['path' => '/admin/postviews/setting/*'],
    function (RouteBuilder $routes) {
        $routes->connect('/', ['controller' => 'Home','action'=>'setting']);
        $routes->fallbacks(DashedRoute::class);
    }
);
Router::plugin('Postviews',['path' => '/admin/postviews/*'],
    function (RouteBuilder $routes) {
        $routes->connect('/', ['controller' => 'Home','action'=>'index']);
        $routes->fallbacks(DashedRoute::class);
    }
);