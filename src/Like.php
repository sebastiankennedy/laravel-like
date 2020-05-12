<?php

namespace SebastianKennedy\LaravelLike;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Like
 *
 * @package SebastianKennedy\LaravelLike
 */
class Like extends Model
{
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->table = config('like.like_table');
    }

    protected static function boot()
    {
        parent::boot();

        self::saving(
            function ($like) {
                $foreign_key = config('like.foreign_key');
                $like->{$foreign_key} = $like->{$foreign_key} ?: auth()->user()->getKey();
            }
        );
    }

    public function likable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(config_path('auth.providers.users.model'), config('like.foreign_key'));
    }
}