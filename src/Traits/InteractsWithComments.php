<?php

namespace Mintellity\Comments\Traits;

use Mintellity\Comments\Models\Comment;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait InteractsWithComments
{
    /**
     * @return MorphMany
     */
    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'modelable');
    }

    public function writesComment(): MorphMany
    {
        return $this->morphMany(Comment::class, 'userable');
    }
}