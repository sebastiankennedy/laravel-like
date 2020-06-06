<?php

/*
 * This file is part of the sebastian-kennedy/laravel-like.
 *
 * (c) SebastianKennedy <sebastiankennedy@foxmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace SebastianKennedy\LaravelLike\Events;

use SebastianKennedy\LaravelLike\Like;

class UnLikedEvent
{
    public $like;

    public function __construct(Like $like)
    {
        $this->like = $like;
    }
}
