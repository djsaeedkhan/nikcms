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
    public function routes(RouteBuilder $routes): void {

        // Create a builder with a different route class.
        $routes->scope('/', function (RouteBuilder $routes) {
            $routes->setRouteClass(DashedRoute::class);
            $routes->connect('/:page/{id}', ['plugin'=>'Website','controller' => 'Content', 'action' => 'single'],)
                ->setPatterns([
                    'page' => '[a-z]+',
                    'id' => '[0-9]+'
                ]);

            $routes->connect(
                '/{controller}/{id}',
                ['action' => 'view'],
                ['id' => '[0-9]+']
            );
        });


        /* $routes->scope('/', function (RouteBuilder $routes) {
            // Connect the generic fallback routes.

            $routes->connect(
                        '/:postType/:slug/*',
                        ['plugin'=>'Website','controller' => 'Content', 'action' => 'single'],
                        [
                            'postType' => '\d+', 
                            'slug' => '\d+', 
                            'pass' => ['postType','slug']]
                    )
                    ;


            $routes->fallbacks(DashedRoute::class);
        });
 */

        /* $routes->plugin(
                'Website',
                ['path' => '/'],
                function (RouteBuilder $builder) {
                    // Add custom routes here
                    $builder->connect(
                        '/:postType/:slug/*',
                        ['plugin'=>'Website','controller' => 'Content', 'action' => 'single'],
                        [
                            'postType' => '\d+', 
                            'slug' => '\d+', 
                            'pass' => ['postType','slug']]
                    )
                    ;

            $builder->fallbacks();
        }
        ); */
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