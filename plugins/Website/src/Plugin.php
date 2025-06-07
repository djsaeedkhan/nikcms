<?php
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
    public function deactivation( $drop = false){}
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
            function (RouteBuilder $routes) {

                //home
                $routes->connect('/', ['controller' => 'Content', 'action' => 'home']);
                $routes->connect('/{posttype}-sitemap.xml', ['controller' => 'Content', 'action' => 'sitemap_index'])->setPass(['posttype']);
                $routes->connect('/sitemap.xml', ['controller' => 'Content', 'action' => 'sitemap']);
                $routes->connect('/sitemap_index.xml', ['controller' => 'Content', 'action' => 'sitemap_index']);
                $routes->connect('/robots.txt', ['controller' => 'Content', 'action' => 'robots']);
                $routes->connect('/home/*',['controller' => 'Content', 'action' => 'home']);
                $routes->connect('/content/Getdata',['controller' => 'Content', 'action' => 'Getdata']);
                $routes->connect(
                    '/ajax/{posttype}/{catid}/{catslug}/*',
                    ['controller' => 'Content', 'action' => 'ajax'],
                    ['pass' => ['posttype','catid','catslug']]);
                $routes->connect('/ajax/{posttype}/*',['controller' => 'Content', 'action' => 'ajax'], ['pass' => ['posttype']]);
                $routes->connect('/ajax',['controller' => 'Content', 'action' => 'ajax'],['[a-z]']);
                $routes->connect('/p/{id}',['controller' => 'Content', 'action' => 'single'], ['pass' => ['id']]);

                //index
                $routes->connect(
                    '/{posttype}/index/{catid}/{catslug}',
                    ['controller' => 'Content', 'action' => 'index'],
                    ['pass' => ['posttype','catid','catslug']]);
                $routes->connect(
                    '/index/{posttype}/{catid}/{catslug}/*',
                    ['controller' => 'Content', 'action' => 'index'],
                    ['pass' => ['posttype','catid','catslug']]);

                $routes->connect(
                    '/index/{posttype}/*',
                    ['controller' => 'Content', 'action' => 'index'],
                    ['pass' => ['posttype']],
                    ['_name' => 'product-page',]);
                $routes->connect(
                    '/index',
                    ['controller' => 'Content', 'action' => 'index'],
                    ['[a-z]']);
                $routes->connect(
                    '/{posttype}/index/*',
                    ['controller' => 'Content', 'action' => 'index'],
                    ['pass' => ['posttype']]);
                
                //category single
                $routes->connect(
                    '/category/{posttype}/single/{catid}/{catslug}/*',
                    ['controller' => 'Content', 'action' => 'catsingle'],
                    ['pass' => ['posttype','catid','catslug']]);
                $routes->connect('/category/{posttype}/single/*',['controller' => 'Content', 'action' => 'catsingle'], ['pass' => ['posttype']]);
                
                //category index
                $routes->connect('/category/{posttype}/{catid}/{catslug}/*',
                    ['controller' => 'Content', 'action' => 'category'],
                    ['pass' => ['posttype','catid','catslug']]);
                $routes->connect('/category/{catid}/{catslug}/*',['controller' => 'Content', 'action' => 'category'], ['pass' => ['catid','catslug']]);
                $routes->connect('/category/{posttype}/',['controller' => 'Content', 'action' => 'category'], ['pass' => ['id']]);
                $routes->connect(
                    '/{posttype}/category/{catid}/{catslug/',
                    ['controller' => 'Content', 'action' => 'category'],
                    ['pass' => ['posttype','catid','catslug']]);
                $routes->connect(
                    '/{posttype}/category/{catid}/{catslug}/*',
                    ['controller' => 'Content', 'action' => 'category'],
                    ['pass' => ['posttype','catid','catslug']]);
                $routes->connect('/category/{catid}/{catslug}/*',['controller' => 'Content', 'action' => 'category'], ['pass' => ['catid','catslug']]);
                $routes->connect('/{posttype}/category/',['controller' => 'Content', 'action' => 'category'], ['pass' => ['posttype']]);
                $routes->connect('/uploadss/*',['controller' => 'Content', 'action' => 'image'],['[a-z]','[a-z]']);

                //single
                $routes->connect('/{posttype}/single/{id}/{slug}/',['controller' => 'Content', 'action' => 'single'], ['pass' => ['posttype','id','slug']]);
                $routes->connect('/single/{id}/{slug}/',['controller' => 'Content', 'action' => 'single'], ['pass' => ['id','slug']]);
                $routes->connect(
                    '/{posttype}/{slug}/*',
                    ['controller' => 'Content', 'action' => 'single'],
                    [
                        'pass' => ['posttype','slug'],
                        'routeClass' => DashedRoute::class
                    ]);

                $routes->connect('/{posttype}',['controller' => 'Content', 'action' => 'single'], ['pass' => ['posttype']]);
                //$routes->connect('/product/:slug/*',['controller' => 'Content', 'action' => 'single','product'],['[a-z]']);
                $routes->connect('/{posttype}/single/*',['controller' => 'Content', 'action' => 'single'], ['pass' => ['posttype']]);

                //other page
                $routes->connect('/archive/*',['controller' => 'Content', 'action' => 'archive']);
                $routes->connect('/tag/*',['controller' => 'Content', 'action' => 'tag'],['[a-z]']);
                $routes->connect('/tags/*',['controller' => 'Content', 'action' => 'tag'],['[a-z]']);
                $routes->connect('/search/*',['controller' => 'Content', 'action' => 'search']);
                $routes->fallbacks(DashedRoute::class);
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