<?php

/*
 * This file is part of the sebastian-kennedy/laravel-like.
 *
 * (c) SebastianKennedy <sebastiankennedy@foxmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace SebastianKennedy\LaravelLike\Tests;

use Illuminate\Support\Facades\Event;
use Orchestra\Testbench\TestCase;
use SebastianKennedy\LaravelLike\LikeServiceProvider;
use SebastianKennedy\LaravelLike\Tests\Models\User;

abstract class LaravelLikeTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [LikeServiceProvider::class];
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->loadMigrationsFrom(__DIR__ . '/migrations');
        $this->loadMigrationsFrom(dirname(__DIR__) . '/migrations');

        Event::fake();
        config(['auth.providers.users.model' => User::class]);
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'testing');
        $app['config']->set(
            'database.connections.testing',
            [
                'driver' => 'sqlite',
                'database' => ':memory:',
                'prefix' => '',
            ]
        );
    }
}
