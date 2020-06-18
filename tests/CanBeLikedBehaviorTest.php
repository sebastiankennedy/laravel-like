<?php

/*
 * This file is part of the sebastian-kennedy/laravel-like.
 *
 * (c) SebastianKennedy <sebastiankennedy@foxmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace SebastianKennedy\LaravelLike\Behaviors;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use SebastianKennedy\LaravelLike\Tests\LaravelLikeTest;
use SebastianKennedy\LaravelLike\Tests\Models\Book;
use SebastianKennedy\LaravelLike\Tests\Models\Post;
use SebastianKennedy\LaravelLike\Tests\Models\User;

class CanBeLikedBehaviorTest extends LaravelLikeTest
{
    public function testIsLikedBy()
    {
        $post = Post::create(['title' => 'Post']);
        $book = Book::create(['title' => 'Book']);
        $user1 = User::create(['name' => 'User']);
        $user2 = User::create(['name' => 'User']);

        $user1->like($post);
        $this->assertTrue($post->isLikedBy($user1));
        $this->assertFalse($book->isLikedBy($user1));

        $user2->like($post);
        $this->assertSame(2, $post->likers->count());
        $this->assertTrue($post->isLikedBy($user2));

        $post->isLikedBy($book);
    }

    public function testLikes()
    {
        $book = Book::create(['title' => 'Book']);
        $user1 = User::create(['name' => 'User 1']);
        $user2 = User::create(['name' => 'User 2']);
        $user3 = User::create(['name' => 'User 3']);

        $user1->like($book);
        $user2->like($book);
        $user3->like($book);
        $this->isInstanceOf(MorphMany::class, get_class($book->likes()));
        $this->assertSame(3, $book->likes()->count());

        $user1->unlike($book);
        $this->assertSame(2, $book->likes()->count());

        $user2->unlike($book);
        $user3->unlike($book);
        $this->isInstanceOf(Collection::class, get_class($book->likes()->get()));
    }

    public function testLikers()
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
