<?php

namespace SebastianKennedy\LaravelLike\Tests\Models;

use Illuminate\Database\Eloquent\Model;
use SebastianKennedy\LaravelLike\Behaviors\BeLikedBehavior;

class Book extends Model
{
    use BeLikedBehavior;

    protected $fillable = ['title'];
}