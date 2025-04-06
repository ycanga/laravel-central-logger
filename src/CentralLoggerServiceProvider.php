<?php
namespace ycanga\CentralLogger;

use Illuminate\Support\ServiceProvider;

class CentralLoggerServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // config publish edilecek
        $this->publishes([
            __DIR__.'/../config/central-logger.php' => config_path('central-logger.php'),
        ], 'config');

        // log sistemi extend edilecek
        $this->app['log']->extend('central_logger', function ($app) {
            return new \Monolog\Logger('central', [
                new LoggerHandler()
            ]);
        });
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/central-logger.php', 'central-logger');
    }
}
