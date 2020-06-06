<?php

namespace SebastianKennedy\LaravelLike;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use SebastianKennedy\Events\LikedEvent;
use SebastianKennedy\Events\UnLikedEvent;

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

    public function scopeWithType(Builder $query, $type)
    {
        return $query->where(config('like.morph_many_type'), app($type)->getMorphClass());
    }
}