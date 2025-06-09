<?php
declare(strict_types=1);

namespace Website;

use Cake\Core\BasePlugin;
use Cake\Console\CommandCollection;
use Cake\Core\ContainerInterface;
use Cake\Core\PluginApplicationInterface;
use Cake\Http\MiddlewareQueue;
use Cake\Routing\Route\DashedRoute;
use Cake\Routing\RouteBuilder;

class Plugin extends BasePlugin
{
    public $name= 'Website';
    public function preload(){}
    public function activation(){}
    public function deactivation(){}
    public function config(){
        return [
            'name'=>'Website',
            'show' => false,
            'title'=>__d('Website','مدیریت وبسایت'),
            'icon'=>'fa fa-item',
            'description'=>__d('Website','مدیریت سایت'),
            'author'=>'Mahan',
            'version'=>'1.0',
            //'sys'=> true, //system plugin
            'path' =>[
                'index' =>'',
                'admin' =>'',
                'setting' =>'',
                ]
        ];
    }

    public function routes(RouteBuilder $routes): void
    {
        $routes->plugin(
            'Website',
            ['path' => '/'],
            function (RouteBuilder $builder) {
                //$builder->setRouteClass(DashedRoute::class);
                // روت پویا برای /post/single یا /post/single/
                $builder->connect(
                    '{posttype}/{slug}/',
                    ['controller' => 'Content', 'action' => 'single'],
                    [
                        'pass' => ['posttype', 'slug'],
                        'posttype' => '[a-zA-Z]+',
                        'slug' => '[a-zA-Z0-9\-]+',
                        //'trailingSlash' => '/?'
                    ]
                );
            }
       )
        ->plugin(
            'Website',
            ['path' => '/ajax'],
            function (RouteBuilder $builder) {
                $builder->connect(
                    '/{posttype}/{catid}/{catslug}/',
                    ['controller' => 'Content', 'action' => 'ajax'],
                    ['pass' => ['posttype','catid','catslug']]);
                $builder->connect('/{posttype}/',['controller' => 'Content', 'action' => 'ajax'], ['pass' => ['posttype']]);
                $builder->connect('/',['controller' => 'Content', 'action' => 'ajax'],['[a-z]']);
            
            }
        )

        ->plugin(
            'Website',
            ['path' => '/category'],
            function (RouteBuilder $builder) {
                $builder->connect(
                    '/category/{posttype}/single/{catid}/{catslug}/',
                    ['controller' => 'Content', 'action' => 'catsingle'],
                    ['pass' => ['posttype','catid','catslug']]);
                $builder->connect(
                    '/category/{posttype}/single/*',
                    ['controller' => 'Content', 'action' => 'catsingle'],
                    ['pass' => ['posttype']]);
                $builder->connect(
                    '/category/{posttype}/{catid}/{catslug}/*',
                    ['controller' => 'Content', 'action' => 'category'],
                    ['pass' => ['posttype','catid','catslug']]);
                $builder->connect(
                    '/category/{catid}/{catslug}/',
                    ['controller' => 'Content', 'action' => 'category'], 
                    ['pass' => ['catid','catslug']]);
                $builder->connect(
                    '/category/{posttype}/',
                    ['controller' => 'Content', 'action' => 'category'],
                    ['pass' => ['id']]);
                $builder->connect(
                    '/{posttype}/category/{catid}/{catslug/',
                    ['controller' => 'Content', 'action' => 'category'],
                    ['pass' => ['posttype','catid','catslug']]);
                $builder->connect(
                    '/{posttype}/category/{catid}/{catslug}/*',
                    ['controller' => 'Content', 'action' => 'category'],
                    ['pass' => ['posttype','catid','catslug']]);
                $builder->connect(
                    '/category/{catid}/{catslug}/',
                    ['controller' => 'Content', 'action' => 'category'],
                    ['pass' => ['catid','catslug']]);
                $builder->connect(
                    '/{posttype}/category/',
                    ['controller' => 'Content', 'action' => 'category'],
                    ['pass' => ['posttype']]);
                $builder->fallbacks();
            }
        )

        ->plugin(
            'Website',
            ['path' => '/'],
            function (RouteBuilder $builder) {
                $builder->setRouteClass(DashedRoute::class);

                $builder->connect(
                    '/{post}/{slug}/',
                    ['controller' => 'Content', 'action' => 'single'],
                    ['pass' => ['post', 'slug'],
                    'post' => '[a-zA-Z]+',
                    'slug' => '[a-zA-Z0-9\-]+'
                ]);

                //home
                $builder->connect('/', ['controller' => 'Content', 'action' => 'home']);
                $builder->connect('/{posttype}-sitemap.xml', ['controller' => 'Content', 'action' => 'sitemap_index'])->setPass(['posttype']);
                $builder->connect('/sitemap.xml', ['controller' => 'Content', 'action' => 'sitemap']);
                $builder->connect('/sitemap_index.xml', ['controller' => 'Content', 'action' => 'sitemap_index']);
                $builder->connect('/robots.txt', ['controller' => 'Content', 'action' => 'robots']);
                $builder->connect('/home/',['controller' => 'Content', 'action' => 'home']);
                $builder->connect('/content/Getdata',['controller' => 'Content', 'action' => 'Getdata']);
                $builder->connect('/p/{id}',['controller' => 'Content', 'action' => 'single'], ['pass' => ['id']]);

                //index
                $builder->connect(
                    '/{posttype}/index/{catid}/{catslug}',
                    ['controller' => 'Content', 'action' => 'index'],
                    ['pass' => ['posttype','catid','catslug']]);
                $builder->connect(
                    '/index/{posttype}/{catid}/{catslug}/*',
                    ['controller' => 'Content', 'action' => 'index'],
                    ['pass' => ['posttype','catid','catslug']]);

                $builder->connect(
                    '/index/{posttype}/',
                    ['controller' => 'Content', 'action' => 'index'],
                    ['pass' => ['posttype']],
                    ['_name' => 'product-page',]);
                $builder->connect(
                    '/index',
                    ['controller' => 'Content', 'action' => 'index'],
                    ['[a-z]']);
                $builder->connect(
                    '/{posttype}/index/',
                    ['controller' => 'Content', 'action' => 'index'],
                    ['pass' => ['posttype']]);
                
                
                $builder->connect(
                    '/uploadss/',
                    ['controller' => 'Content', 'action' => 'image'],
                    ['[a-z]','[a-z]']);

                //single
                $builder->connect('/{posttype}/single/{id}/{slug}/',['controller' => 'Content', 'action' => 'single'], ['pass' => ['posttype','id','slug']]);
                $builder->connect('/single/{id}/{slug}/',['controller' => 'Content', 'action' => 'single'], ['pass' => ['id','slug']]);
                
                $builder->connect('/{posttype}',['controller' => 'Content', 'action' => 'single'], ['pass' => ['posttype']]);
                //$routes->connect('/product/:slug/*',['controller' => 'Content', 'action' => 'single','product'],['[a-z]']);
                

                //other page
                $builder->connect('/archive/*',['controller' => 'Content', 'action' => 'archive']);
                $builder->connect('/tag/*',['controller' => 'Content', 'action' => 'tag'],['[a-z]']);
                $builder->connect('/tags/*',['controller' => 'Content', 'action' => 'tag'],['[a-z]']);
                $builder->connect('/search/*',['controller' => 'Content', 'action' => 'search']);
                
                $builder->fallbacks();
            }
        ); 
           
        parent::routes($routes);
    }

    public function bootstrap(PluginApplicationInterface $app): void
    {
    }
    public function middleware(MiddlewareQueue $middlewareQueue): MiddlewareQueue
    {
        // Add your middlewares here
        return $middlewareQueue;
    }

    public function console(CommandCollection $commands): CommandCollection
    {
        // Add your commands here
        $commands = parent::console($commands);
        return $commands;
    }
    public function services(ContainerInterface $container): void
    {
    }
}