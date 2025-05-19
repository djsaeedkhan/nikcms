<?php
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use Cake\Routing\Route\DashedRoute;
Router::plugin('Website',['path' => '/'],
    function (RouteBuilder $routes) {

        //home
        $routes->connect('/', ['controller' => 'Content', 'action' => 'home']);
        $routes->connect('/{posttype}-sitemap.xml', ['controller' => 'Content', 'action' => 'sitemap_index'])->setPass(['posttype']);
        $routes->connect('/sitemap.xml', ['controller' => 'Content', 'action' => 'sitemap']);
        $routes->connect('/sitemap_index.xml', ['controller' => 'Content', 'action' => 'sitemap_index']);
        $routes->connect('/robots.txt', ['controller' => 'Content', 'action' => 'robots']);
        $routes->connect('/home/*',['controller' => 'Content', 'action' => 'home']);
        $routes->connect('/content/Getdata',['controller' => 'Content', 'action' => 'Getdata']);
        $routes->connect('/ajax/:posttype/:catid/:catslug/*',['controller' => 'Content', 'action' => 'ajax']);
        $routes->connect('/ajax/:posttype/*',['controller' => 'Content', 'action' => 'ajax'],['[a-z]']);
        $routes->connect('/ajax',['controller' => 'Content', 'action' => 'ajax'],['[a-z]']);
        $routes->connect('/p/:id',['controller' => 'Content', 'action' => 'single'],['[a-z]']);

        //index
        $routes->connect('/:posttype/index/:catid/:catslug',['controller' => 'Content', 'action' => 'index'],['[a-z]','[0-9]','[a-z]']);
        $routes->connect('/index/:posttype/:catid/:catslug/*',['controller' => 'Content', 'action' => 'index'],['[a-z]','[0-9]','[a-z]']);
        $routes->connect('/index/:posttype/*',['controller' => 'Content', 'action' => 'index'],['[a-z]'],['_name' => 'product-page',]);
        $routes->connect('/index',['controller' => 'Content', 'action' => 'index'],['[a-z]']);
        $routes->connect('/:posttype/index/*',['controller' => 'Content', 'action' => 'index'],['[a-z]','[a-z]']);
        
        //category single
        $routes->connect('/category/:posttype/single/:catid/:catslug/*',['controller' => 'Content', 'action' => 'catsingle']);
        $routes->connect('/category/:posttype/single/*',['controller' => 'Content', 'action' => 'catsingle'],['[a-z]','[a-z]']);
        
        //category index
        $routes->connect('/category/:posttype/:catid/:catslug/*',['controller' => 'Content', 'action' => 'category'],['[a-z]','[a-z]']);
        $routes->connect('/category/:catid/:catslug/*',['controller' => 'Content', 'action' => 'category'],['[a-z]','[a-z]']);
        $routes->connect('/category/:posttype/',['controller' => 'Content', 'action' => 'category'],['[a-z]','[a-z]']);
        $routes->connect('/:posttype/category/:catid/:catslug/',['controller' => 'Content', 'action' => 'category'],['[a-z]','[a-z]']);
        $routes->connect('/:posttype/category/:catid/:catslug/*',['controller' => 'Content', 'action' => 'category'],['[a-z]','[a-z]']);
        $routes->connect('/category/:catid/:catslug/*',['controller' => 'Content', 'action' => 'category'],['[a-z]','[a-z]']);
        $routes->connect('/:posttype/category/',['controller' => 'Content', 'action' => 'category'],['[a-z]','[a-z]']);
        $routes->connect('/uploadss/*',['controller' => 'Content', 'action' => 'image'],['[a-z]','[a-z]']);

        //single
        $routes->connect('/:posttype/single/:id/:slug/',['controller' => 'Content', 'action' => 'single'],['[a-z]','[a-z]','[a-z]']);
        $routes->connect('/single/:id/:slug/',['controller' => 'Content', 'action' => 'single'],['[a-z]','[a-z]']);
        $routes->connect('/:posttype/:slug/*',['controller' => 'Content', 'action' => 'single'],['[a-z]','[a-z]']);
        $routes->connect('/:posttype',['controller' => 'Content', 'action' => 'single'],['[a-z]','[a-z]']);
        //$routes->connect('/product/:slug/*',['controller' => 'Content', 'action' => 'single','product'],['[a-z]']);
        $routes->connect('/:posttype/single/*',['controller' => 'Content', 'action' => 'single'],['[a-z]','[a-z]']);

        //other page
        $routes->connect('/archive/*',['controller' => 'Content', 'action' => 'archive']);
        $routes->connect('/tag/*',['controller' => 'Content', 'action' => 'tag'],['[a-z]']);
        $routes->connect('/tags/*',['controller' => 'Content', 'action' => 'tag'],['[a-z]']);
        $routes->connect('/search/*',['controller' => 'Content', 'action' => 'search']);
        $routes->fallbacks(DashedRoute::class);
    }
);