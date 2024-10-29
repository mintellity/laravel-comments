<?php

namespace Mintellity\Comments\Http\Livewire;

use Livewire\Component;
use Mintellity\Comments\Contracts\HasComments;
use Mintellity\Comments\Contracts\WritesComments;
use Mintellity\Comments\Models\Comment;
use Mintellity\Comments\Services\CommentService;

class CommentTable extends Component
{
    public $comments;
    public $content;
    public $commentContent = '';
    public $model;
    public $author;
    private $commentService;


    public function __construct()
    {
        $this->commentService = new CommentService();
    }

    public function mount(HasComments $model, WritesComments $author)
    {
        $this->model = $model;
        $this->author = $author;

        $this->comments = Comment::with('userable')->where('modelable_id', $model->getKey())->orderByDesc('created_at')->get();
    }

    public function render()
    {
        return view('comment-package::livewire.comment-table', [
            'model' => $this->model,
            'author' => $this->author,
            'comments' => $this->comments
        ]);
    }


    public function store()
    {
        $this->validate([
            'commentContent' => 'required|string'
        ]);

        // Use service function to store comment
        $this->commentService->store($this->model, $this->author, $this->commentContent);

        // Reset form
        $this->resetForm();
        // Refresh comments after storing
        $this->comments = Comment::with('userable')->where('modelable_id', $this->model->getKey())->orderByDesc('created_at')->get();
    }

    public function resetForm()
    {
        $this->commentContent = '';
    }

    public function edit($commentId)
    {
        $this->editCommentId = $commentId;
        // Fetch the comment_content
        $this->content = Comment::findOrFail($commentId)->comment_content;
    }

    public function destroy($commentId)
    {
        // Use service function to destroy comment
        $this->commentService->destroy($commentId);

        // Refresh comments after deleting
        $this->comments = Comment::with('userable')->where('modelable_id', $this->model->getKey())->orderByDesc('created_at')->get();
    }
}
