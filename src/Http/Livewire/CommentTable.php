<?php

namespace Mintellity\Comments\Http\Livewire;

use Livewire\Component;
use Mintellity\Comments\Contracts\HasComments;
use Mintellity\Comments\Contracts\WritesComments;
use Mintellity\Comments\Http\Requests\CommentRequest;
use Mintellity\Comments\Models\Comment;

class CommentTable extends Component
{
    public $comments;
    public $content;
    public $editCommentId = null;
    public $editContent = '';
    public $commentContent = '';
    public $model;
    public $author;

    protected $listeners = ['edit', 'update', 'destroy'];

    public function mount(HasComments $model, WritesComments $author)
    {
        $this->model = $model;
        $this->author = $author;
        $this->comments = Comment::with(['modelable', 'userable'])->get();
    }

    public function render()
    {
        return view('comment-package::livewire.comment-table');
    }


    public function store()
    {
        $this->validate([
            'comment_content' => 'required|string'
        ]);

        // Create a new comment
        Comment::create([
            'modelable_id' => $this->modelable_id,
            'modelable_type' => $this->modelable_type,
            'userable_id' => auth()->id(),
            'userable_type' => $this->userable_type,
            'comment_content' => $this->commentContent,
            'created_at' => now(),
            'updated_at' => now(),
            'deleted_at' => null
        ]);

        // Reset form
        $this->resetForm();
        $this->comments = Comment::with(['modelable', 'userable'])->get(); // Refresh comments after storing
    }

    public function resetForm()
    {
        $this->content = '';
    }

    public function edit($commentId)
    {
        $this->editCommentId = $commentId;
        $this->content = Comment::findOrFail($commentId)->comment_content; // fetch the comment_content
    }

    public function update($commentId)
    {
        $this->validate([
            'comment_content' => 'required|string'
        ]);

        $comment = Comment::findOrFail($commentId);

        if(auth()->id() !== $comment->userable_id) { // check whether the commenter is the same as the authenticated user
            abort(403);
        }

        // Update the comment
        $comment->update([
           'comment_content' => $this->editContent,
           'updated_at' => now()
        ]);

        $this->editCommentId = null;
        $this->editContent = '';
        $this->comments = Comment::with(['modelable', 'userable'])->get(); // refresh comments after updating
    }

    public function destroy($commentId)
    {
        $comment = Comment::findOrFail($commentId);

        if(auth()->id() !== $comment->userable_id) { // check whether the commenter is the same as the authenticated user
            abort(403);
        }
        $comment->delete();

        $this->comments = Comment::with(['modelable', 'userable'])->get(); // Refresh comments after deleting

    }

}