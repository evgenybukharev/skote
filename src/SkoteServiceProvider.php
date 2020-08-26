<?php

namespace EvgenyBukharev\Skote;

use EvgenyBukharev\Skote\Components\Menu\MenuRenderer;
use EvgenyBukharev\Skote\Components\Menu\MenuRendererInterface;
use EvgenyBukharev\Skote\Http\ViewComposers\SkoteComposer;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\View\Factory;
use Illuminate\Support\ServiceProvider;


class SkoteServiceProvider extends ServiceProvider
{

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
    }

    /**
     * @param Factory    $view
     * @param Dispatcher $events
     * @param Repository $config
     */
    public function boot(Factory $view, Dispatcher $events, Repository $config)
    {
        $this->loadViews();

        $this->loadTranslations();

        $this->publishConfig();

        $this->publishAssets();

        $this->registerViewComposers($view);
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
        $configPath = $this->packagePath('config/skote.php');

        $this->publishes([$configPath => config_path('skote.php')], 'config');

        $this->mergeConfigFrom($configPath, 'adminlte');
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
}
