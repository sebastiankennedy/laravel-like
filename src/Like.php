<?php

/*
 * This file is part of the sebastian-kennedy/laravel-like.
 *
 * (c) SebastianKennedy <sebastiankennedy@foxmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace SebastianKennedy\LaravelLike;

use Illuminate\Database\Eloquent\Model;
use SebastianKennedy\LaravelLike\Events\LikedEvent;
use SebastianKennedy\LaravelLike\Events\UnLikedEvent;

/**
 * Class Like
 *
 * @package SebastianKennedy\LaravelLike
 */
class Like extends Model
{
    protected $dispatchesEvents = [
        'created' => LikedEvent::class,
        'deleted' => UnLikedEvent::class,
    ];

    public function __construct(array $attributes = [])
    {
        $this->table = config('like.like_table');

        parent::__construct($attributes);
    }

    public function likable()
    {
        return $this->morphTo();
    }

    public function liker()
    {
        return $this->relationLoaded('user') ? $this->user : $this->user();
    }

    public function user()
    {
        return $this->belongsTo(config('auth.providers.users.model'), config('like.foreign_key'));
    }

    public function scopeWithType($query, $type)
    {
        return $query->where(config('like.morph_many_type'), app($type)->getMorphClass());
    }
}
