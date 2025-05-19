<?php
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use Cake\Routing\Route\DashedRoute;

Router::plugin('Seo',['path' => '/admin/seo/'],
    function (RouteBuilder $routes) {
        $routes->connect('/', ['controller' => 'Home', 'action' => 'index']);
        $routes->fallbacks(DashedRoute::class);
    }
);
Router::plugin('Seo', ['path' => ''], 
    function ($routes) {
        $routes->connect('/', ['controller' => 'Url', 'action' => 'index']);
        $routes->fallbacks(DashedRoute::class);
    }
);