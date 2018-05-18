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

        $this->app->singleton('Aylien', function($app) {
            $config = config('aylien');
            if (!$config) {
                throw new \RunTimeException('Aylien configuration not found. Please run `php artisan vendor:publish`');
            }

            return new TextAPI($config['app_id'] , $config['app_key']);
        });
    }
}
