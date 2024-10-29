<?php

namespace Mintellity\Comments\Traits;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Mintellity\Comments\Models\Comment;

trait WritesCommentsTrait
{
    /**
     * @return MorphMany
     */
    public function writesComment(): MorphMany
    {
        return $this->morphMany(Comment::class, 'userable');
    }

}
