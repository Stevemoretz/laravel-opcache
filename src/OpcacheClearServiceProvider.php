<?php

namespace SteveMoretz\LaravelOpcacheClear;

use Illuminate\Support\ServiceProvider;

class OpcacheClearServiceProvider extends ServiceProvider {
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot() {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register() {
        include __DIR__ . "/routes.php";
        $this->app->make(
            "SteveMoretz\LaravelOpcacheClear\OpcacheClearController"
        );

        $this->app->bind("command.opcache:clear", OpcacheClearCommand::class);

        $this->mergeConfigFrom(__DIR__ . "/opcache.php", "opcache");

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . "/opcache.php" => config_path("opcache.php"),
            ]);
        }

        $this->commands(["command.opcache:clear"]);
    }
}
