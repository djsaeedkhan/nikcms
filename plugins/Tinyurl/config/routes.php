<?php
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use Cake\Routing\Route\DashedRoute;

/* Router::plugin('Tinyurl',['path' => '/admin/url/'],
    function (RouteBuilder $routes) {
        $routes->connect('/', ['controller' => 'Home', 'action' => 'index']);
        $routes->fallbacks(DashedRoute::class);
    }
);
Router::plugin('Tinyurl',['path' => '/admin/tinyurl/'],
    function (RouteBuilder $routes) {
        $routes->connect('/', ['controller' => 'Home', 'action' => 'index']);
        $routes->fallbacks(DashedRoute::class);
    }
);
Router::plugin('Tinyurl', ['path' => '/url/*'], 
    function ($routes) {
        $routes->connect('/', ['controller' => 'Url', 'action' => 'index']);
        $routes->fallbacks(DashedRoute::class);
    }
); */