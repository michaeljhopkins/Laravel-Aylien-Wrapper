<?php namespace Hopkins\LaravelAylienWrapper\Providers;

use AYLIEN\TextAPI;
use Illuminate\Support\ServiceProvider;

class AylienServiceProvider extends ServiceProvider {

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([__DIR__ . '/../config/config.php' => config_path('aylien.php')]);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/config.php', 'aylien');

        $this->app['hopkins.aylien'] = $this->app->share(function($app)
        {
            return new TextAPI(
                $app['config']->get('aylien.app_id'),
                $app['config']->get('aylien.app_key')
            );
        });
    }
}
