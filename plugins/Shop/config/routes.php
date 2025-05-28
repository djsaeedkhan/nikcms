<?php
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use Cake\Routing\Route\DashedRoute;

/* Router::plugin(
    'Shop',
    ['path' => '/admin/shop/'],
    function (RouteBuilder $routes) {
        $routes->connect('/', ['controller' => 'Home']);
        $routes->connect('/logestics/:action/*', ['controller' => 'Logestics']);
        $routes->connect('/logesticusers/:action/*', ['controller' => 'Logesticusers']);
        $routes->connect('/logesticlists/:action/*', ['controller' => 'Logesticlists']);
        $routes->fallbacks(DashedRoute::class);
    }
);

Router::plugin(
    'Shop',
    ['path' => '/shop/'],
    function (RouteBuilder $routes) {
        $routes->connect('/search/', ['controller' => 'Content', 'action' => 'index']);
        $routes->connect('/compare/:id', ['controller' => 'Manage', 'action' => 'compare'])->setPass(['id']);
        $routes->connect('/compare/', ['controller' => 'Manage', 'action' => 'compare'])->setPass(['id']);
        $routes->connect('/profile/logestic/:id', ['controller' => 'Profile', 'action' => 'logestics'])->setPass(['id']);
        $routes->connect('/profile/logestic/:id/detail/:id2', 
            ['controller' => 'Profile', 'action' => 'logdetail'])->setPass(['id','id2']);
        $routes->connect('/profile/logestic/*', ['controller' => 'Profile', 'action' => 'logestics'])->setPass(['id']);
        $routes->connect('/profile/:id', ['controller' => 'Profile', 'action' => 'index'])->setPass(['id']);
        $routes->connect('/addrefund/:trackcode/',['controller' => 'Profile', 'action' => 'addrefund'],['[a-z]']);
        $routes->connect('/refund/:trackcode/',['controller' => 'Profile', 'action' => 'refund'],['[a-z]']);
        $routes->connect('/price/', ['controller' => 'Content', 'action' => 'Price']);
        $routes->connect('/', ['controller' => 'Profile', 'action' => 'index']);
        $routes->fallbacks(DashedRoute::class);
    }
);

Router::plugin(
    'Shop',
    ['path' => '/product/'],
    function (RouteBuilder $routes) {
        $routes->connect('/', ['controller' => 'Content', 'action' => 'home']);
        $routes->connect('/add/*',['controller' => 'Manage', 'action' => 'add']);
        $routes->connect('/cart/:product_action/:product_id/',['controller' => 'Manage', 'action' => 'cart']);
        $routes->connect('/cart/*',['controller' => 'Manage', 'action' => 'cart']);

        $routes->connect('/checkout/profile',['controller' => 'Manage', 'action' => '_complete_profile']);
        $routes->connect('/checkout/*',['controller' => 'Manage', 'action' => 'checkout']);
        $routes->connect('/factor/',['controller' => 'Manage', 'action' => 'factor']);
        $routes->connect('/factor/logestic/:orderid/',['controller' => 'Manage', 'action' => 'logestics']);


        $routes->connect('/payment/:orderid/',['controller' => 'Manage', 'action' => 'payment']);
        $routes->connect('/payment/*',['controller' => 'Manage', 'action' => 'payment']);

        $routes->connect('/home/*',['controller' => 'Content', 'action' => 'home']);
        $routes->connect('/search/*',['controller' => 'Content', 'action' => 'search']);
        $routes->connect('/content/Getdata',['controller' => 'Content', 'action' => 'Getdata']);

        $routes->connect('/ajax/:posttype/:catid/:catslug/*',['controller' => 'Content', 'action' => 'ajax'],['[a-z]','[0-9]','[a-z]']);
        $routes->connect('/ajax/:posttype/*',['controller' => 'Content', 'action' => 'ajax'],['[a-z]']);
        $routes->connect('/ajax',['controller' => 'Content', 'action' => 'ajax'],['[a-z]']);

        $routes->connect('/json/:posttype/:catid/:catslug/*',['controller' => 'Content', 'action' => 'index'],['[a-z]','[0-9]','[a-z]']);
        $routes->connect('/json/:posttype/*',['controller' => 'Content', 'action' => 'index'],['[a-z]']);
        $routes->connect('/json',['controller' => 'Content', 'action' => 'index','json'],['[a-z]']);

        //index
        $routes->connect('/index/:catid/:catslug/*',['controller' => 'Content', 'action' => 'index'],['[a-z]','[0-9]','[a-z]']);
        $routes->connect('/index/:catid/',['controller' => 'Content', 'action' => 'index'],['[0-9]']);
        $routes->connect('/index/*',['controller' => 'Content', 'action' => 'index'],['[a-z]'],['_name' => 'product-page',]);
        $routes->connect('/index',['controller' => 'Content', 'action' => 'index'],['[a-z]']);
        //$routes->connect('/index/:catid/:catslug/*',['controller' => 'Content', 'action' => 'index'],['[a-z]','[0-9]','[a-z]']);
        //$routes->connect('/index/*',['controller' => 'Content', 'action' => 'index'],['[a-z]']);
        
        

        //single
        $routes->connect('/single/:id/:slug/',['controller' => 'Content', 'action' => 'single'],['[a-z]','[a-z]','[a-z]']);
        $routes->connect('/single/:id/:slug/',['controller' => 'Content', 'action' => 'single'],['[a-z]','[a-z]']);
        $routes->connect('/:slug/*',['controller' => 'Content', 'action' => 'single'],['[a-z]',]);
        $routes->connect('/single/*',['controller' => 'Content', 'action' => 'single'],['[a-z]','[a-z]']);
        
        //category single
        $routes->connect('/category/:posttype/single/:catid/:catslug/*',['controller' => 'Content', 'action' => 'catsingle']);
        $routes->connect('/category/:posttype/single/*',['controller' => 'Content', 'action' => 'catsingle'],['[a-z]','[a-z]']);
        

        //Brand Page
        //$routes->connect('/brand/',['controller' => 'Content', 'action' => 'brand']);
        //$routes->connect('/brands/*', ['controller' => 'Content', 'action' => 'brand'],['[a-z]','[a-z]']);
        //$routes->connect('/brands/*', ['controller' => 'Content', 'action' => 'index','?'=>['brands'=>[':product_id'] ]],['[a-z]']);
        //$routes->connect('/label/*', ['controller' => 'Content', 'action' => 'label'],['[a-z]','[a-z]']);

        $routes->connect('/brand/:brands',['controller' => 'Content', 'action' => 'index'])->setPass(['brands']);
        $routes->connect('/label/:label',['controller' => 'Content', 'action' => 'index'])->setPass(['label']);
        $routes->connect('/amazing/',['controller' => 'Content', 'action' => 'index','amazing']);

        //category index
        $routes->connect('/category/:posttype/:catid/:catslug/*',['controller' => 'Content', 'action' => 'category'],['[a-z]','[a-z]']);
        $routes->connect('/category/:catid/:catslug/*',['controller' => 'Content', 'action' => 'category'],['[a-z]','[a-z]']);
        $routes->connect('/category/:posttype/',['controller' => 'Content', 'action' => 'category'],['[a-z]','[a-z]']);

        //other page
        $routes->connect('/archive/*',['controller' => 'Content', 'action' => 'archive']);
        $routes->connect('/tag/*',['controller' => 'Content', 'action' => 'tag'],['[a-z]']);
        $routes->connect('/search/*',['controller' => 'Content', 'action' => 'search']);

        $routes->fallbacks(DashedRoute::class);
    }
); */