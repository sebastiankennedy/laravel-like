<?php

namespace SebastianKennedy\LaravelLike\Tests;

use SebastianKennedy\LaravelLike\Like;
use SebastianKennedy\LaravelLike\Tests\Models\Book;
use SebastianKennedy\LaravelLike\Tests\Models\Post;
use SebastianKennedy\LaravelLike\Tests\Models\User;

class LikeTest extends LaravelLikeTest
{
    public function testLikable()
    {
        $user = User::create(['name' => 'User']);
        $book = Book::create(['title' => 'Book']);
        $post = Post::create(['title' => 'Post']);

        $like1 = $user->like($book);
        $like2 = $user->like($post);

        $this->assertInstanceOf(Book::class, $like1->likable);
        $this->assertInstanceOf(Post::class, $like2->likable);
    }

    public function testLiker()
    {
        $user = User::create(['name' => 'User']);
        $book = Book::create(['title' => 'Book']);
        $like = $user->like($book);
        $this->assertInstanceOf(User::class, $like->liker);
    }

    public function testUser()
    {
        $user = User::create(['name' => 'User']);
        $book = Book::create(['title' => 'Book']);
        $like = $user->like($book);

        $this->assertInstanceOf(User::class, $like->user);
    }

    public function testScopeWithType()
    {
        $user = User::create(['name' => 'User']);
        $book1 = Book::create(['title' => 'Book1']);
        $book2 = Book::create(['title' => 'Book2']);
        $post1 = Post::create(['title' => 'Post1']);
        $post2 = Post::create(['title' => 'Post2']);
        $post3 = Post::create(['title' => 'Post3']);
        $user->like($book1);
        $user->like($book2);
        $user->like($post1);
        $user->like($post2);
        $user->like($post3);

        $books = Like::withType(Book::class)->get();
        $posts = Like::withType(Post::class)->get();

        $this->assertSame(2, $books->count());
        $this->assertSame(3, $posts->count());
    }
}