<?php

namespace SebastianKennedy\LaravelLike\Tests\Models;

use Illuminate\Database\Eloquent\Model;
use SebastianKennedy\LaravelLike\Behaviors\ToLikeBehavior;

class User extends Model
{
    use ToLikeBehavior;
    protected $fillable = ['title'];
}