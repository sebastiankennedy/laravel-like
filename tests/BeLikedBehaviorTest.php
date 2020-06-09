<?php

/*
 * This file is part of the sebastian-kennedy/laravel-like.
 *
 * (c) SebastianKennedy <sebastiankennedy@foxmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace SebastianKennedy\LaravelLike\Behaviors;

use SebastianKennedy\LaravelLike\Tests\LaravelLikeTest;
use SebastianKennedy\LaravelLike\Tests\Models\Book;
use SebastianKennedy\LaravelLike\Tests\Models\Post;
use SebastianKennedy\LaravelLike\Tests\Models\User;

class BeLikedBehaviorTest extends LaravelLikeTest
{
    public function testIsLikedBy()
    {
        $user = User::create(['name' => 'User']);
        $post = Post::create(['title' => 'Post']);
        $book = Book::create(['title' => 'Book']);

        $this->assertFalse($book->isLikedBy($user));
        $this->assertFalse($post->isLikedBy($user));
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
        $this->assertSame(3, $book->likes()->count());

        $user1->unlike($book);
        $this->assertSame(2, $book->likes()->count());
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
