<?php

namespace EvgenyBukharev\Skote;

use EvgenyBukharev\Skote\Components\Menu\MenuRenderer;
use EvgenyBukharev\Skote\Components\Menu\MenuRendererInterface;
use EvgenyBukharev\Skote\Console\Commands\InstallElfinder;
use EvgenyBukharev\Skote\Crud\Panel\CrudPanel;
use EvgenyBukharev\Skote\Http\ViewComposers\SkoteComposer;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\View\Factory;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;


class SkoteServiceProvider extends ServiceProvider
{
    public $routeFilePath = '/routes/base.php';

    protected $commands = [
        InstallElfinder::class,
    ];

    /**
     *
     */
    public function register()
    {
        $this->app->singleton(Skote::class, function (Container $app) {
            return new Skote(
                $app['events'],
                $app
            );
        });

        $this->app->bind(MenuRendererInterface::class,MenuRenderer::class);

        // Bind the CrudPanel object to Laravel's service container
        $this->app->singleton('crud', function ($app) {
            return new CrudPanel($app);
        });

        // load a macro for Route,
        // helps developers load all routes for a CRUD resource in one line
        if (! Route::hasMacro('crud')) {
            $this->addRouteMacro();
        }
    }

    /**
     * @param Factory    $view
     * @param Dispatcher $events
     * @param Repository $config
     */
    public function boot(Factory $view, Dispatcher $events, Repository $config)
    {
        $this->loadViews();

        $this->setupRoutes($this->app->router);

        $this->loadTranslations();

        $this->publishConfig();

        $this->publishAssets();

        $this->loadHelpers();

        $this->registerViewComposers($view);

        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }

    /**
     * The route macro allows developers to generate the routes for a CrudController,
     * for all operations, using a simple syntax: Route::crud().
     *
     * It will go to the given CrudController and get the setupRoutes() method on it.
     */
    private function addRouteMacro()
    {
        Route::macro('crud', function ($name, $controller) {
            // put together the route name prefix,
            // as passed to the Route::group() statements
            $routeName = '';
            if ($this->hasGroupStack()) {
                foreach ($this->getGroupStack() as $key => $groupStack) {
                    if (isset($groupStack['name'])) {
                        if (is_array($groupStack['name'])) {
                            $routeName = implode('', $groupStack['name']);
                        } else {
                            $routeName = $groupStack['name'];
                        }
                    }
                }
            }
            // add the name of the current entity to the route name prefix
            // the result will be the current route name (not ending in dot)
            $routeName .= $name;

            // get an instance of the controller
            if ($this->hasGroupStack()) {
                $groupStack = $this->getGroupStack();
                $groupNamespace = $groupStack && isset(end($groupStack)['namespace']) ? end($groupStack)['namespace'].'\\' : '';
            } else {
                $groupNamespace = '';
            }
            $namespacedController = $groupNamespace.$controller;
            $controllerInstance = App::make($namespacedController);

            return $controllerInstance->setupRoutes($name, $routeName, $controller);
        });
    }


    /**
     * Define the routes for the application.
     *
     * @param \Illuminate\Routing\Router $router
     *
     * @return void
     */
    public function setupRoutes(Router $router)
    {
        // by default, use the routes file provided in vendor
        $routeFilePathInUse = __DIR__.$this->routeFilePath;

        // but if there's a file with the same name in routes/backpack, use that one
        if (file_exists(base_path().$this->routeFilePath)) {
            $routeFilePathInUse = base_path().$this->routeFilePath;
        }

        $this->loadRoutesFrom($routeFilePathInUse);
    }

    /**
     * Load the Backpack helper methods, for convenience.
     */
    public function loadHelpers()
    {
        require_once __DIR__.'/helpers.php';
    }

    /**
     *
     */
    private function loadViews()
    {
        $viewsPath = $this->packagePath('resources/views');

        $this->loadViewsFrom($viewsPath, 'skote');

        $this->publishes([$viewsPath => base_path('resources/views/vendor/skote'),], 'views');
    }

    /**
     *
     */
    private function loadTranslations()
    {
        $translationsPath = $this->packagePath('resources/lang');

        $this->loadTranslationsFrom($translationsPath, 'skote');

        $this->publishes([$translationsPath => base_path('resources/lang/vendor/skote')], 'translations');
    }

    /**
     *
     */
    private function publishConfig()
    {
        $this->publishes([$this->packagePath('config/skote.php') => config_path('skote.php')], 'config');
        $this->publishes([$this->packagePath('config/elfinder.php') => config_path('elfinder.php')], 'config');

        $this->mergeConfigFrom($this->packagePath('config/skote.php'), 'skote');
        $this->mergeConfigFrom($this->packagePath('config/elfinder.php'), 'elfinder');
    }

    /**
     *
     */
    private function publishAssets()
    {
        $this->publishes([$this->packagePath('resources/assets/dist') => public_path('assets/vendor/skote'),], 'assets');
    }

    /**
     * @param $path
     *
     * @return string
     */
    private function packagePath($path)
    {
        return __DIR__ . "/../$path";
    }

    /**
     * @param Factory $view
     */
    private function registerViewComposers(Factory $view)
    {
        $view->composer('skote::page', SkoteComposer::class);
    }


    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole()
    {
        // Registering package commands.
        $this->commands($this->commands);

        // Mapping the elfinder prefix, if missing
        if (! Config::get('elfinder.route.prefix')) {
            Config::set('elfinder.route.prefix', Config::get('skote.base.route_prefix').'/elfinder');
        }
    }
}
