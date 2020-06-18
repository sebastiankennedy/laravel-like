<?php

/*
 * This file is part of the sebastian-kennedy/laravel-like.
 *
 * (c) SebastianKennedy <sebastiankennedy@foxmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace SebastianKennedy\LaravelLike\Behaviors;

use Illuminate\Database\Eloquent\Model;

trait CanBeLikedBehavior
{
    public function isLikedBy(Model $user)
    {
        if (is_a($user, config('auth.providers.users.model'))) {
            if ($this->relationLoaded('likers')) {
                return $this->likers->contains($user);
            }

            return ($this->relationLoaded('likes') ? $this->likes : $this->likes())
                    ->where(config('like.foreign_key'), $user->getKey())
                    ->count() > 0;
        }

        return false;
    }

    public function likes()
    {
        return $this->morphMany(config('like.model'), config('like.morph_many_name'));
    }

    public function likers()
    {
        return $this->belongsToMany(
            config('auth.providers.users.model'),
            config('like.table_name'),
            config('like.morph_many_id'),
            config('like.foreign_key')
        )->where(config('like.morph_many_type'), $this->getMorphClass());
    }
}
