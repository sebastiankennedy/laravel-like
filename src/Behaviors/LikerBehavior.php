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

trait LikerBehavior
{
    public function toggleLike(Model $model)
    {
        return $this->hasLiked($model) ? $this->unlike($model) : $this->like($model);
    }

    public function unlike(Model $model)
    {
        $relation = $model->likes()
            ->where(config('like.morph_many_id'), $model->getKey())
            ->where(config('like.morph_many_type'), $model->getMorphClass())
            ->where(config('like.foreign_key'), $this->getKey())
            ->first();

        if ($relation) {
            return $relation->delete();
        }

        return null;
    }

    public function like(Model $model)
    {
        if (!$this->hasLiked($model)) {
            $like = app(config('like.model'));
            $like->{config('like.foreign_key')} = $this->getKey();
            $like->{config('like.morph_many_id')} = $model->getKey();
            $like->{config('like.morph_many_type')} = $model->getMorphClass();

            return $this->likes()->save($like);
        }

        return null;
    }

    public function hasLiked(Model $model)
    {
        return ($this->relationLoaded('likes') ? $this->likes : $this->likes())
                ->where(config('like.morph_many_id'), $model->getKey())
                ->where(config('like.morph_many_type'), $model->getMorphClass())
                ->count() > 0;
    }

    public function likes()
    {
        return $this->hasMany(config('like.model'), config('like.foreign_key'), $this->getKeyName());
    }
}
