<?php

namespace SebastianKennedy\Events;

use SebastianKennedy\LaravelLike\Like;

class UnLikedEvent
{
    public $like;

    public function __construct(Like $like)
    {
        $this->like = $like;
    }
}