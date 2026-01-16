<?php

namespace Tessera;

use Illuminate\Support\ServiceProvider;
use Tessera\Services\TesseraManager;

class TesseraServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/tessera.php', 'tessera'
        );

        $this->app->singleton(TesseraManager::class, function () {
            return new TesseraManager();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../config/tessera.php' => config_path('tessera.php'),
        ], 'tessera-config');

        $this->registerObservers();
    }

    /**
     * Register model observers
     */
    protected function registerObservers(): void
    {
    }
}
