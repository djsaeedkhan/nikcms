<?php
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use Cake\Routing\Route\DashedRoute;

/* Router::plugin('Challenge', 
    ['path' => '/challenge'], 
    function ($routes) {
        $routes->scope('/admin', [], function ($routes) {
            $routes->connect('/', ['controller' => 'Home']);
            // This route's name will be `contacts:api:ping`
            $routes->connect('/:controller/:action');
        });
    }
); */



/* Router::plugin(
    'Challenge',
    ['path' => '/challenge/api'],
    function (RouteBuilder $routes) {
        $routes->connect('/', ['controller' => 'Api']);
        $routes->fallbacks(DashedRoute::class);
    }
);
 */

/* Router::plugin(
    'Challenge',
    ['path' => '/admin/challenge/'],
    function (RouteBuilder $routes) {
        $routes->connect('/', ['controller' => 'Admin']);
        $routes->fallbacks(DashedRoute::class);
    }
);
Router::plugin(
    'Challenge',
    ['path' => '/challenge'],
    function (RouteBuilder $routes) {
        $routes->connect('/profile/*', ['controller' => 'Challenges','action'=>'profile']);
        $routes->connect('/:slug/', ['controller' => 'Challenges','action'=>'View']);
        //$routes->connect('/:slug/solution', ['controller' => 'Challenges','action'=>'solution']);
        $routes->connect('/:slug/:method', ['controller' => 'Challenges','action'=>'View']);
        $routes->connect('/follow/:slug/', ['controller' => 'Challenges','action'=>'follow']);
        $routes->connect('/', ['controller' => 'Challenges']);
        $routes->fallbacks(DashedRoute::class);
    }
); */
/* Router::plugin(
    'Challenge',
    ['path' => '/challenge/'],
    function (RouteBuilder $routes) {
        $routes->connect('/', ['controller' => 'Home']);
        $routes->fallbacks(DashedRoute::class);
    }
); */