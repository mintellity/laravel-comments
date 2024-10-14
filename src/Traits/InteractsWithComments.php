<?php

namespace Mintellity\Comments\Traits;

use Mintellity\Comments\Models\Comment;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Collection;

trait InteractsWithComments
{
    /**
     * @return MorphMany
     */
    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'modelable');
    }

    /**
     * @param string $collectionName
     * @return Collection
     */
    public function getComments(string $collectionName = 'default'): Collection
    {
        $commentsQuery = $this->comments();

        $comments = $commentsQuery->get();

        $sortedComments = $comments->sortByDesc('created_at');

        return $sortedComments;
    }

}
