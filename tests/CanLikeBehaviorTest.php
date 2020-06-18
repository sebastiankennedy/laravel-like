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
use SebastianKennedy\LaravelLike\Events\LikedEvent;
use SebastianKennedy\LaravelLike\Events\UnLikedEvent;
use SebastianKennedy\LaravelLike\Tests\Models\Book;
use SebastianKennedy\LaravelLike\Tests\Models\Post;
use SebastianKennedy\LaravelLike\Tests\Models\User;

class CanLikeBehaviorTest extends LaravelLikeTest
{
    public function testLike()
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

    public function testUnlike()
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

    public function testToggleLike()
    {
        $user = User::create(['name' => 'User']);
        $book = Book::create(['title' => 'Book']);
        $this->assertIsObject($user->toggleLike($book));
        $this->assertTrue($user->toggleLike($book));
    }

    public function testHasLiked()
    {
        $user = User::create(['name' => 'User']);
        $book = Book::create(['title' => 'Book']);
        $post = Post::create(['title' => 'Post']);

        $user->like($book);
        $this->assertTrue($user->hasLiked($book));
        $this->assertFalse($user->hasLiked($post));
    }

    public function testLikes()
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
}
