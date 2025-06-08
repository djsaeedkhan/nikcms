<?php
declare(strict_types=1);

use Cake\Routing\RouteBuilder;
use Cake\Routing\Route\DashedRoute;

return function (RouteBuilder $routes): void {
    $routes->plugin(
        'Website',
        ['path' => '/'],
        function (RouteBuilder $builder) {
            $builder->setRouteClass(DashedRoute::class);

            // روت برای /post/single یا /post/single/
            $builder->connect(
                '/{posttype}/{slug}{trailingSlash}',
                ['controller' => 'Content', 'action' => 'single'],
                [
                    'pass' => ['posttype', 'slug'],
                    'posttype' => '[a-zA-Z]+',
                    'slug' => '[a-zA-Z0-9\-]+',
                    'trailingSlash' => '/?'
                ]
            );

            // روت‌های پیش‌فرض برای بقیه کنترلرها
            $builder->fallbacks(DashedRoute::class);
        }
    );
};