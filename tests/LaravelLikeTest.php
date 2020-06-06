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
use SebastianKennedy\LaravelLike\Events\LikedEvent;
use SebastianKennedy\LaravelLike\Events\UnLikedEvent;
use SebastianKennedy\LaravelLike\LikeServiceProvider;
use SebastianKennedy\LaravelLike\Tests\Models\Book;
use SebastianKennedy\LaravelLike\Tests\Models\Post;
use SebastianKennedy\LaravelLike\Tests\Models\User;

class LaravelLikeTest extends TestCase
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

    public function test_to_like_behavior_like()
    {
        $user = User::create(['name' => 'User']);
        $book = Book::create(['title' => 'Book']);
        $this->assertIsObject($user->like($book));

        Event::assertDispatched(
            LikedEvent::class,
            function ($event) use ($user, $book) {
                return $event->like->{config('like.morph_many_name')} instanceof Book
                    && $event->like->{config('like.morph_many_name')}->id === $book->id
                    && $event->like->user instanceof User
                    && $event->like->user->id === $user->id;
            }
        );

        $this->assertNull($user->like($book));
    }

    public function test_to_like_behavior_unlike()
    {
        $user = User::create(['name' => 'User']);
        $book = Book::create(['title' => 'Book']);
        $this->assertNull($user->unlike($book));

        $this->assertIsObject($user->like($book));
        $this->assertTrue($user->unlike($book));
        Event::assertDispatched(
            UnLikedEvent::class,
            function ($event) use ($user, $book) {
                return $event->like->{config('like.morph_many_name')} instanceof Book
                    && $event->like->{config('like.morph_many_name')}->id === $book->id
                    && $event->like->user instanceof User
                    && $event->like->user->id === $user->id;
            }
        );
    }

    public function test_to_like_behavior_toggle_like()
    {
        $user = User::create(['name' => 'User']);
        $book = Book::create(['title' => 'Book']);
        $this->assertIsObject($user->toggleLike($book));
        $this->assertTrue($user->toggleLike($book));
    }

    public function test_to_like_behavior_has_liked()
    {
        $user = User::create(['name' => 'User']);
        $book = Book::create(['title' => 'Book']);
        $post = Post::create(['title' => 'Post']);

        $user->like($book);
        $this->assertTrue($user->hasLiked($book));
        $this->assertFalse($user->hasLiked($post));
    }

    public function test_to_like_behavior_likes()
    {
        $user = User::create(['name' => 'User']);
        $book = Book::create(['title' => 'Book']);
        $post = Post::create(['title' => 'Post']);
        $user->like($book);
        $user->like($post);

        $this->assertSame(2, $user->likes()->count());
        $this->assertSame(1, $user->likes()->withType(Book::class)->count());
        $this->assertSame(1, $user->likes()->withType(Post::class)->count());
    }

    public function test_be_liked_behavior_is_liked_by()
    {
        $user = User::create(['name' => 'User']);
        $post = Post::create(['title' => 'Post']);
        $book = Book::create(['title' => 'Book']);

        $this->assertFalse($book->isLikedBy($user));
        $this->assertFalse($post->isLikedBy($user));
    }

    public function test_be_liked_behavior_likes()
    {
        $book = Book::create(['title' => 'Book']);
        $user1 = User::create(['name' => 'User 1']);
        $user2 = User::create(['name' => 'User 2']);
        $user3 = User::create(['name' => 'User 3']);

        $user1->like($book);
        $user2->like($book);
        $user3->like($book);
        $this->assertSame(3, $book->likes()->count());

        $user1->unlike($book);
        $this->assertSame(2, $book->likes()->count());
    }

    public function test_be_liked_behavior_likers()
    {
        $book = Book::create(['title' => 'Book']);
        $user1 = User::create(['name' => 'User 1']);
        $user2 = User::create(['name' => 'User 2']);
        $user3 = User::create(['name' => 'User 3']);

        $user1->like($book);
        $user2->like($book);
        $user3->like($book);

        $this->assertSame(3, $book->likers()->count());

        $user3->unlike($book);
        $this->assertSame(2, $book->likers()->count());
    }
}
