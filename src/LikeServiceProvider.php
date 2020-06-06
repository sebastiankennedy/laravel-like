<?php

/*
 * This file is part of the sebastian-kennedy/laravel-like.
 *
 * (c) SebastianKennedy <sebastiankennedy@foxmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

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
        $this->publishes([dirname(__DIR__) . '/config/like.php' => config_path('like.php')], 'config');
        $this->publishes([dirname(__DIR__) . '/migrations/' => database_path('migrations')], 'migrations');

        if ($this->app->runningInConsole()) {
            $this->loadMigrationsFrom(dirname(__DIR__) . '/migrations/');
        }
    }

    public function register()
    {
        $this->mergeConfigFrom(dirname(__DIR__) . '/config/like.php', 'like');
    }
}
