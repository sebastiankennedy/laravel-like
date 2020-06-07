<h1 align="center"> laravel-like </h1>

<p align="center"> User like features for laravel application..</p>

[![Build Status](https://travis-ci.org/sebastiankennedy/laravel-like.svg?branch=master)](https://travis-ci.org/sebastiankennedy/laravel-like)
[![Latest Stable Version](https://poser.pugx.org/sebastian-kennedy/laravel-like/v)](//packagist.org/packages/sebastian-kennedy/laravel-like) 
[![Total Downloads](https://poser.pugx.org/sebastian-kennedy/laravel-like/downloads)](//packagist.org/packages/sebastian-kennedy/laravel-like) 
[![Latest Unstable Version](https://poser.pugx.org/sebastian-kennedy/laravel-like/v/unstable)](//packagist.org/packages/sebastian-kennedy/laravel-like) 
[![License](https://poser.pugx.org/sebastian-kennedy/laravel-like/license)](//packagist.org/packages/sebastian-kennedy/laravel-like)

## Installing

```shell
$ composer require sebastian-kennedy/laravel-like -vvv
```

## Configuration

```shell
$ php artisan vendor:publish --provider="SebastianKennedy\\LaravelLike\\LikeServiceProvider" --tag=config
```

## Migrations

```shell
$ php artisan vendor:publish --provider="SebastianKennedy\\LaravelLike\\LikeServiceProvider" --tag=migrations
```

## Usage

#### BeLikedBehavior.php
```php
<?php

namespace SebastianKennedy\LaravelLike\Tests\Models;

use Illuminate\Database\Eloquent\Model;
use SebastianKennedy\LaravelLike\Behaviors\BeLikedBehavior;

class Book extends Model
{
    use BeLikedBehavior;

    protected $fillable = ['title'];
}
```

#### ToLikeBehavior.php
```php
<?php

namespace SebastianKennedy\LaravelLike\Tests\Models;

use Illuminate\Database\Eloquent\Model;
use SebastianKennedy\LaravelLike\Behaviors\ToLikeBehavior;

class User extends Model
{
    use ToLikeBehavior;
    protected $fillable = ['name'];
}
```

## API
```
$user = User::first();
$book = Book::first();

$user-like($book);
$user->unlike($book);
$user->toggleLike($book);
$user->hasLiked($book);
$user->likes();

$book->isLikedBy($user);
$book->likes();
$book->likers();
```

## Contributing

You can contribute in one of three ways:

1. File bug reports using the [issue tracker](https://github.com/sebastian-kennedy/laravel-like/issues).
2. Answer questions or fix bugs on the [issue tracker](https://github.com/sebastian-kennedy/laravel-like/issues).
3. Contribute new features or update the wiki.

_The code contribution process is not very formal. You just need to make sure that you follow the PSR-0, PSR-1, and PSR-2 coding guidelines. Any new code contributions must be accompanied by unit tests where applicable._

## License

MIT