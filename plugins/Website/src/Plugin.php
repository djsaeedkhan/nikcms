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
                $builder->setRouteClass(DashedRoute::class);

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

                $builder->connect(
                    '/{posttype}/{slug}/*',
                    ['controller' => 'Content', 'action' => 'single'],
                    [
                        'pass' => ['posttype', 'slug'],
                        'posttype' => '[a-zA-Z]+',
                        'slug' => '[a-zA-Z0-9\-]+',
                        //'trailingSlash' => '/?'
                    ]
                );
                $builder->connect(
                    '/{posttype}/{slug}/*',
                    ['controller' => 'Content', 'action' => 'single'],
                    [
                        'pass' => ['posttype', 'slug'],
                        'posttype' => '[a-zA-Z]+',
                        'slug' => '[a-zA-Z0-9\-]+',
                        //'trailingSlash' => '/?'
                    ]
                );
                $builder->connect(
                    '/{posttype}/{slug}/*',
                    ['controller' => 'Content', 'action' => 'single'],
                    [
                        'pass' => ['posttype', 'slug'],
                        'posttype' => '[a-zA-Z]+',
                        'slug' => '[a-zA-Z0-9\-]+',
                        'trailingSlash' => '/?'
                    ]
                );


               // روت‌های خاص دیگه (مثل اونایی که کار می‌کنن)
               $builder->connect('/', ['controller' => 'Content', 'action' => 'home']);
               $builder->connect('/sitemap.xml', ['controller' => 'Content', 'action' => 'sitemap']);
               $builder->connect('/sitemap_index.xml', ['controller' => 'Content', 'action' => 'sitemap_index']);
               $builder->connect('/{posttype}-sitemap.xml', ['controller' => 'Content', 'action' => 'sitemap_index'], ['pass' => ['posttype'], 'posttype' => '[a-zA-Z]+']);
               $builder->connect('/robots.txt', ['controller' => 'Content', 'action' => 'robots']);
               $builder->connect('/content/Getdata', ['controller' => 'Content', 'action' => 'Getdata']);

               // فال‌بک برای بقیه کنترلرها (بعد از روت‌های خاص)
               //$builder->fallbacks();
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