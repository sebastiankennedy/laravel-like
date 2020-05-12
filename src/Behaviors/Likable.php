<?php

namespace SebastianKennedy\LaravelLike\Behaviors;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Likable
 *
 * @package SebastianKennedy\LaravelLike\Behaviors
 */
class Likable extends Model
{
    /**
     * @return HasMany
     */
    public function likes()
    {
        return $this->hasMany(config('like.model'), config('like.foreign_key'), $this->getKeyName());
    }

    /**
     * @param  Model  $model
     *
     * @return bool
     */
    public function hasLiked(Model $model)
    {
        return ($this->relationLoaded('likes') ? $this->likes : $this->likes())
                ->where('likable_id', $model->getKey())
                ->where('likable_type', $model->getMorphClass())
                ->count() > 0;
    }

    /**
     * @param  Model  $model
     *
     * @return Application|mixed|null
     */
    public function like(Model $model)
    {
        if (!$this->hasLiked($model)) {
            $like = app(config('like.model'));
            $like->{config('like.foreign_key')} = $this->getKey();
            $like = $model->likes()->save($like);

            return $like;
        }

        return null;
    }

    /**
     * @param  Model  $model
     *
     * @return null
     */
    public function unlike(Model $model)
    {
        $relation = $model->likes()
            ->where(config('like.morph_many_name').'_id', $model->getKey())
            ->where(config('like.morph_many_name').'_type', $model->getMorphClass())
            ->where(config('like.foreign_key'), $model->getKey())
            ->first();

        if ($relation) {
            return $relation->delete();
        }

        return null;
    }

    /**
     * @param  Model  $model
     *
     * @return Application|mixed|null
     */
    public function toggleLike(Model $model)
    {
        return $this->hasLiked($model) ? $this->unlike($model) : $this->like($model);
    }

    /**
     * @param  null  $model
     *
     * @return mixed
     */
    public function likedItems($model = null)
    {
        $this->load([
            'likes' => function ($query) use ($model) {
                $model && $query->where(config('like.morph_many_name').'_type', app($model)->getMorphClass());
            }, 'likes.'.config('like.morph_many_name'),
        ]);

        return $this->likes->pluck(config('like.morph_many_name'));
    }
}