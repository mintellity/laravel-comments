<?php

namespace Mintellity\Comments\Services;

use Mintellity\Comments\Contracts\HasComments;
use Mintellity\Comments\Contracts\WritesComments;
use Mintellity\Comments\Models\Comment;

class CommentService
{
    public function store(HasComments $model, WritesComments $author, array $comment)
    {
        $model->comments()->create($comment);
        $author->writesComment()->create($comment);

        $comment = Comment::create([
            'modelable_id' => $model->id,
            'modelable_type' => get_class($model),
            'userable_id' => $author->id,
            'userable_type' => get_class($author),
            'comment_content' => $comment['comment_content'],
        ]);

        return $comment;
    }
}