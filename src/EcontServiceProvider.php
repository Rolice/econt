<?php
namespace Rolice\Econt;

use Illuminate\Support\ServiceProvider;
use Rolice\Econt\Commands\Sync;

/**
 * EcontServiceProvider for Laravel 5.1+
 *
 * @package    Rolice\Econt
 * @version    1.0
 */
class EcontServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([__DIR__ . '/../config/econt.php' => config_path('econt.php')], 'config');
        $this->publishes([__DIR__ . '/../database/migrations/' => database_path('migrations')], 'migrations');

        $this->mergeConfigFrom(__DIR__ . '/../config/econt.php', 'econt');

        $this->loadTranslationsFrom($this->app->basePath(). '/vendor/rolice/econt/resources/lang', 'econt');

        if (!$this->app->routesAreCached()) {
            require __DIR__ . '/Http/routes.php';
        }
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('Econt', function () {
            return new Econt;
        });

        $this->app['sync'] = $this->app->share(function ($app) {
            return new Sync;
        });

        $this->commands('sync');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['Econt'];
    }
}