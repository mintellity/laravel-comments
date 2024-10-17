<?php

namespace Mintellity\Comments\Services;

use Mintellity\Comments\Contracts\HasComments;
use Mintellity\Comments\Contracts\WritesComments;
use Mintellity\Comments\Models\Comment;

class CommentService
{
    public function store(HasComments $model, WritesComments $author, string $commentContent)
    {
        /** @var Comment $comment */

        // Create a new comment instance
        $comment = Comment::make([
            'comment_content' => $commentContent,
        ]);

        // Attach the author and the model to the comment
        $comment->userable()->associate($author);
        $comment->modelable()->associate($model);

        $comment->save();

        return $comment;
    }


    public function destroy ($commentId)
    {
        // Find the comment
        $comment = Comment::findOrFail($commentId);

        // Check if the user is the author of the comment
        if(auth()->user()->userable->getKey() !== $comment->userable_id)
        {
            abort(403);
        }

        $comment->delete();
    }
}
