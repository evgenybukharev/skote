<?php

namespace EvgenyBukharev\Skote;

use EvgenyBukharev\Skote\Http\ViewComposers\SkoteComposer;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\Container\Container;


class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    public function register()
    {
        $this->app->singleton(Skote::class, function (Container $app) {
            return new Skote(
                $app['events'],
                $app
            );
        });
    }

    public function boot(Factory $view, Dispatcher $events, Repository $config)
    {
        $this->loadViews();

        $this->loadTranslations();

        $this->publishConfig();

        $this->publishAssets();

        $this->registerViewComposers($view);
    }

    private function loadViews()
    {
        $viewsPath = $this->packagePath('resources/views');

        $this->loadViewsFrom($viewsPath, 'skote');

        $this->publishes([$viewsPath => base_path('resources/views/vendor/skote'),], 'views');
    }

    private function loadTranslations()
    {
        $translationsPath = $this->packagePath('resources/lang');

        $this->loadTranslationsFrom($translationsPath, 'skote');

        $this->publishes([$translationsPath => base_path('resources/lang/vendor/skote')], 'translations');
    }

    private function publishConfig()
    {
        $configPath = $this->packagePath('config/skote.php');

        $this->publishes([$configPath => config_path('skote.php')], 'config');

        $this->mergeConfigFrom($configPath, 'adminlte');
    }

    private function publishAssets()
    {
        $this->publishes([$this->packagePath('resources/assets/dist') => public_path('assets/vendor/skote'),], 'assets');
    }

    private function packagePath($path)
    {
        return __DIR__ . "/../$path";
    }

    private function registerViewComposers(Factory $view)
    {
        $view->composer('skote::page', SkoteComposer::class);
    }
}
