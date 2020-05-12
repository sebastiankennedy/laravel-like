<?php

namespace SebastianKennedy\LaravelLike;

use Illuminate\Support\ServiceProvider;

/**
 * Class LikeServiceProvider
 *
 * @package SebastianKennedy\LaravelLike
 */
class LikeServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([__DIR__ . '/../config/like.php' => config_path('like.php')], 'config');
        $this->publishes([__DIR__ . '/../migrations/' => database_path('migrations')], 'migrations');

        if ($this->app->runningInConsole()) {
            $this->loadMigrationsFrom(__DIR__ . '/../migrations/');
        }
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/like.php', 'like');
    }
}