<?php
namespace CloudCart\Econt;

use Illuminate\Support\ServiceProvider;

/**
 * EcontServiceProvider for Laravel 5.1+
 *
 * @package    CloudCart\Econt
 * @version    1.0
 * @license    CloudCart License
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
        $this->publishes([__DIR__ . '/config/econt.php' => config_path('econt.php')],'config');
        $this->publishes([__DIR__ . '/database/migrations/' => database_path('migrations')], 'migrations');

        $this->mergeConfigFrom(__DIR__ . '/config/econt.php', 'econt');
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