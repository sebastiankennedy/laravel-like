<?php

/*
 * This file is part of the sebastian-kennedy/laravel-like.
 *
 * (c) SebastianKennedy <sebastiankennedy@foxmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace SebastianKennedy\LaravelLike\Tests\Models;

use Illuminate\Database\Eloquent\Model;
use SebastianKennedy\LaravelLike\Behaviors\CanBeLikedBehavior;

class Post extends Model
{
    use CanBeLikedBehavior;

    protected $fillable = ['title'];
}
