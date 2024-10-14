<?php

namespace Mintellity\Comments\Services;

use Mintellity\Comments\Contracts\HasComments;
use Mintellity\Comments\Contracts\WritesComments;
use Mintellity\Comments\Models\Comment;

class CommentService
{
    public function store(HasComments $model, WritesComments $author, string $commentContent)
    {
        $comment = Comment::create([
            'modelable_id' => $model->getKey(),
            'modelable_type' => get_class($model),
            'userable_id' => $author->getKey(),
            'userable_type' => get_class($author),
            'comment_content' => $commentContent,
        ]);

        return $comment;
    }

    public function update($commentId)
    {
        $comment = Comment::findOrFail($commentId);

        if(auth()->id() !== $comment->userable()->id())
        {
            abort(403);
        }

        $comment->update([
            'comment_content' => $this->comment_content,
            'updated_at' => now()
        ]);

        $comment->save();
    }

    public function destroy ($commentId)
    {
        $comment = Comment::findOrFail($commentId);

        if(auth()->id() !== $comment->userable()->id())
        {
            abort(403);
        }

        $comment->delete();
    }
}
