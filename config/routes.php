<?php
/**
 * Routes configuration.
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
 *
 * It's loaded within the context of `Application::routes()` method which
 * receives a `RouteBuilder` instance `$routes` as method argument.
 *
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

use Cake\Routing\Route\DashedRoute;
use Cake\Routing\RouteBuilder;

/*
 * This file is loaded in the context of the `Application` class.
  * So you can use  `$this` to reference the application class instance
  * if required.
 */
return function (RouteBuilder $routes): void {
    /*
     * The default class to use for all routes
     *
     * The following route classes are supplied with CakePHP and are appropriate
     * to set as the default:
     *
     * - Route
     * - InflectedRoute
     * - DashedRoute
     *
     * If no call is made to `Router::defaultRouteClass()`, the class used is
     * `Route` (`Cake\Routing\Route\Route`)
     *
     * Note that `Route` does not do any inflections on URLs which will result in
     * inconsistently cased URLs when used with `{plugin}`, `{controller}` and
     * `{action}` markers.
     */
    $routes->setRouteClass(DashedRoute::class);

    $routes->scope('/', function (RouteBuilder $builder): void {
        /*
         * Here, we are connecting '/' (base path) to a controller called 'Pages',
         * its action called 'display', and we pass a param to select the view file
         * to use (in this case, templates/Pages/home.php)...
         */
        //$builder->connect('/', ['controller' => 'Pages', 'action' => 'display', 'home']);
        $builder->connect('/users/login',['controller' => 'Users','action'=>'login']);
        $builder->connect('/users/register',['controller' => 'Users','action'=>'register']);
        $builder->connect('/users/logout',['controller' => 'Users','action'=>'logout']);
        $builder->connect('/users/remember/token/*',['controller' => 'Users','action'=>'remember_token']);
        $builder->connect('/users/remember',['controller' => 'Users','action'=>'remember']);
        $builder->connect('/users/index',['controller' => 'Users','action'=>'index']);
        $builder->connect('/users/profile',['controller' => 'Users','action'=>'profile']);
        $builder->connect('/users/thumbnail/*',['controller' => 'Users','action'=>'thumbnail']);


        /*
         * ...and connect the rest of 'Pages' controller's URLs.
         */
        //$builder->connect('/pages/*', 'Pages::display');

        /*
         * Connect catchall routes for all controllers.
         *
         * The `fallbacks` method is a shortcut for
         *
         * ```
         * $builder->connect('/{controller}', ['action' => 'index']);
         * $builder->connect('/{controller}/{action}/*', []);
         * ```
         *
         * You can remove these routes once you've connected the
         * routes you want in your application.
         */

        //Website Plugin
        //home
        $builder->connect('/', ['plugin'=>'Website','controller' => 'Content', 'action' => 'home']);
        $builder->connect('/{posttype}-sitemap.xml', ['plugin'=>'Website','controller' => 'Content', 'action' => 'sitemap_index'])->setPass(['posttype']);
        $builder->connect('/sitemap.xml', ['plugin'=>'Website','controller' => 'Content', 'action' => 'sitemap']);
        $builder->connect('/sitemap_index.xml', ['plugin'=>'Website','controller' => 'Content', 'action' => 'sitemap_index']);
        $builder->connect('/robots.txt', ['plugin'=>'Website','controller' => 'Content', 'action' => 'robots']);
        $builder->connect('/home/*',['plugin'=>'Website','controller' => 'Content', 'action' => 'home']);
        $builder->connect('/content/Getdata',['plugin'=>'Website','controller' => 'Content', 'action' => 'Getdata']);
        $builder->connect(
            '/ajax/{posttype}/{catid}/{catslug}/*',
            ['plugin'=>'Website','controller' => 'Content', 'action' => 'ajax'],
            ['pass' => ['posttype','catid','catslug']]);
        $builder->connect('/ajax/{posttype}/*',['plugin'=>'Website','controller' => 'Content', 'action' => 'ajax'], ['pass' => ['posttype']]);
        $builder->connect('/ajax',['plugin'=>'Website','controller' => 'Content', 'action' => 'ajax'],['[a-z]']);
        $builder->connect('/p/{id}',['plugin'=>'Website','controller' => 'Content', 'action' => 'single'], ['pass' => ['id']]);

        //index
        $builder->connect(
            '/{posttype}/index/{catid}/{catslug}',
            ['plugin'=>'Website','controller' => 'Content', 'action' => 'index'],
            ['pass' => ['posttype','catid','catslug']]);
        $builder->connect(
            '/index/{posttype}/{catid}/{catslug}/*',
            ['plugin'=>'Website','controller' => 'Content', 'action' => 'index'],
            ['pass' => ['posttype','catid','catslug']]);

        $builder->connect(
            '/index/{posttype}/*',
            ['plugin'=>'Website','controller' => 'Content', 'action' => 'index'],
            ['pass' => ['posttype']],
            ['_name' => 'product-page',]);
        $builder->connect(
            '/index',
            ['plugin'=>'Website','controller' => 'Content', 'action' => 'index'],
            ['[a-z]']);
        $builder->connect(
            '/{posttype}/index/*',
            ['plugin'=>'Website','controller' => 'Content', 'action' => 'index'],
            ['pass' => ['posttype']]);
        
        //category single
        $builder->connect(
            '/category/{posttype}/single/{catid}/{catslug}/*',
            ['plugin'=>'Website','controller' => 'Content', 'action' => 'catsingle'],
            ['pass' => ['posttype','catid','catslug']]);
        $builder->connect('/category/{posttype}/single/*',['plugin'=>'Website','controller' => 'Content', 'action' => 'catsingle'], ['pass' => ['posttype']]);
        
        //category index
        $builder->connect('/category/{posttype}/{catid}/{catslug}/*',
            ['plugin'=>'Website','controller' => 'Content', 'action' => 'category'],
            ['pass' => ['posttype','catid','catslug']]);
        $builder->connect('/category/{catid}/{catslug}/*',['plugin'=>'Website','controller' => 'Content', 'action' => 'category'], ['pass' => ['catid','catslug']]);
        $builder->connect('/category/{posttype}/',['plugin'=>'Website','controller' => 'Content', 'action' => 'category'], ['pass' => ['id']]);
        $builder->connect(
            '/{posttype}/category/{catid}/{catslug/',
            ['plugin'=>'Website','controller' => 'Content', 'action' => 'category'],
            ['pass' => ['posttype','catid','catslug']]);
        $builder->connect(
            '/{posttype}/category/{catid}/{catslug}/*',
            ['plugin'=>'Website','controller' => 'Content', 'action' => 'category'],
            ['pass' => ['posttype','catid','catslug']]);
        $builder->connect('/category/{catid}/{catslug}/*',['plugin'=>'Website','controller' => 'Content', 'action' => 'category'], ['pass' => ['catid','catslug']]);
        $builder->connect('/{posttype}/category/',['plugin'=>'Website','controller' => 'Content', 'action' => 'category'], ['pass' => ['posttype']]);
        $builder->connect('/uploadss/*',['plugin'=>'Website','controller' => 'Content', 'action' => 'image'],['[a-z]','[a-z]']);

        //single
        $builder->connect('/{posttype}/single/{id}/{slug}/',['plugin'=>'Website','controller' => 'Content', 'action' => 'single'], ['pass' => ['posttype','id','slug']]);
        $builder->connect('/single/{id}/{slug}/',['plugin'=>'Website','controller' => 'Content', 'action' => 'single'], ['pass' => ['id','slug']]);
        $builder->connect('/{posttype}/{slug}/',
            ['plugin' => 'Website','controller' => 'Content','action' => 'single'],
            ['pass' => ['posttype', 'slug'],]
        );
        $builder->connect('/{posttype}',['plugin'=>'Website','controller' => 'Content', 'action' => 'single'], ['pass' => ['posttype']]);
        //$builder->connect('/product/:slug/*',['controller' => 'Content', 'action' => 'single','product'],['[a-z]']);
        $builder->connect('/{posttype}/single/*',['plugin'=>'Website','controller' => 'Content', 'action' => 'single'], ['pass' => ['posttype']]);

        //other page
        $builder->connect('/archive/*',['plugin'=>'Website','controller' => 'Content', 'action' => 'archive']);
        $builder->connect('/tag/*',['plugin'=>'Website','controller' => 'Content', 'action' => 'tag'],['[a-z]']);
        $builder->connect('/tags/*',['plugin'=>'Website','controller' => 'Content', 'action' => 'tag'],['[a-z]']);
        $builder->connect('/search/*',['plugin'=>'Website','controller' => 'Content', 'action' => 'search']);
        
        $builder->fallbacks(DashedRoute::class);
    });

    /*
     * If you need a different set of middleware or none at all,
     * open new scope and define routes there.
     *
     * ```
     * $routes->scope('/api', function (RouteBuilder $builder): void {
     *     // No $builder->applyMiddleware() here.
     *
     *     // Parse specified extensions from URLs
     *     // $builder->setExtensions(['json', 'xml']);
     *
     *     // Connect API actions here.
     * });
     * ```
     */
};