<h1 align="center"> laravel-like </h1>

<p align="center"> User like feature for laravel application.</p>

<p align="center">
<a href="https://travis-ci.org/sebastiankennedy/laravel-like"><img src="https://travis-ci.org/sebastiankennedy/laravel-like.svg?branch=master" alt="Build Status"></a>
<a href="https://packagist.org/packages/sebastian-kennedy/laravel-like"><img src="https://poser.pugx.org/sebastian-kennedy/laravel-like/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/sebastian-kennedy/laravel-like"><img src="https://poser.pugx.org/sebastian-kennedy/laravel-like/v/unstable.svg" alt="Latest Unstable Version"></a>
<a href="https://scrutinizer-ci.com/g/sebastiankennedy/laravel-like/?branch=master"><img src="https://scrutinizer-ci.com/g/sebastiankennedy/laravel-like/badges/quality-score.png?b=master" alt="Scrutinizer Code Quality"></a>
<a href="https://scrutinizer-ci.com/g/sebastiankennedy/laravel-like/?branch=master"><img src="https://scrutinizer-ci.com/g/sebastiankennedy/laravel-like/badges/coverage.png?b=master" alt="Code Coverage"></a>
<a href="https://packagist.org/packages/sebastian-kennedy/laravel-like"><img src="https://poser.pugx.org/sebastian-kennedy/laravel-like/downloads" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/sebastian-kennedy/laravel-like"><img src="https://poser.pugx.org/sebastian-kennedy/laravel-like/license" alt="License"></a>
</p>

## References

- https://github.com/overtrue/laravel-like
- https://github.com/overtrue/laravel-follow

## Requires

- PHP >= 7.3
- Laravel >= ^6.0

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
use SebastianKennedy\LaravelLike\Behaviors\LikerBehavior;

class User extends Model
{
    use LikerBehavior;
    protected $fillable = ['name'];
}
```

## API
```php
<?php

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

_The code contribution process is not very formal. You just need to make sure that you follow the PSR-0, PSR-1, and PSR-12 coding guidelines. Any new code contributions must be accompanied by unit tests where applicable._

## License

MIT