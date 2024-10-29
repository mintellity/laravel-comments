<?php

namespace Mintellity\Comments\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Livewire;
use Mintellity\Comments\Contracts\HasComments;
use Mintellity\Comments\Contracts\WritesComments;
use Mintellity\Comments\Models\Comment;
use Mintellity\Comments\Services\CommentService;

class CommentSection extends Component
{
    public $comments;
    public $content;
    public $commentContent = '';
    public $model;
    public $author;


    private $commentService;

    protected $queryString = ['selectedProject' => ['as' => 'projectId']];
    protected $listeners = ['refreshComments']; // Listen for event from other components

    public function __construct()
    {
        $this->commentService = new CommentService();
    }


    public function mount(HasComments $model, WritesComments $author)
    {
        $this->model = $model;
        $this->author = $author; // modify this to get the userable instance

        // Get all comments for the model
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
        $contentWithBr = nl2br(e($this->commentContent));

        $this->validate([
            'commentContent' => 'required|string'
        ]);

        // Use service function to store comment
        $this->commentService->store($this->model, $this->author, $contentWithBr);

        // Reset form
        $this->resetForm();

        // Refresh comments after storing
        $this->comments = Comment::with('userable')->where('modelable_id', $this->model->getKey())->orderByDesc('created_at')->get();
    }

    public function resetForm()
    {
        $this->commentContent = '';
    }


    public function destroy($commentId)
    {
        // Use service function to destroy comment
        $this->commentService->destroy($commentId);

        // Refresh comments after deleting
        $this->comments = Comment::with('userable')->where('modelable_id', $this->model->getKey())->orderByDesc('created_at')->get();
    }

    public function refreshComments($modelId)
    {
        $this->comments = Comment::with('userable')->where('modelable_id', $modelId)->orderByDesc('created_at')->get();
    }

    public function addNewLine()
    {
        $this->commentContent .= "\n";
    }
}
