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
    public $editCommentId = null;
    public $editContent = '';
    public $commentContent = '';
    public $model;
    public $author;
    private $commentService;

//    protected $listeners = ['edit', 'update', 'destroy'];

    public function __construct()
    {
        $this->commentService = new CommentService();
    }

    public function mount(HasComments $model, WritesComments $author)
    {
        $this->model = $model;
        $this->author = $author;

//        $this->comments = $this->model->comments()->with(['userable'])->get();
        $this->comments = Comment::with('userable')->get();
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
        $this->comments = Comment::with(['modelable', 'userable'])->get();
    }

    public function resetForm()
    {
        $this->content = '';
    }

    public function edit($commentId)
    {
        $this->editCommentId = $commentId;
        $this->content = Comment::findOrFail($commentId)->comment_content; // Fetch the comment_content
    }

//    public function update($commentId)
//    {
//        $this->validate([
//            'comment_content' => 'required|string'
//        ]);
//
//        // Use service function to update comment
//        $this->commentService->update($commentId);
//
//        $comment = Comment::findOrFail($commentId);
//
//        if(auth()->id() !== $comment->userable_id) { // Check whether the commenter is the same as the authenticated user
//            abort(403);
//        }
//
//        $this->editCommentId = null; // Set comment_id to null after updating
//        $this->editContent = ''; // Set content to null after updating
//        $this->comments = Comment::with(['modelable', 'userable'])->get(); // Refresh comments after updating
//    }

    public function destroy($commentId)
    {

        $this->commentService->destroy($commentId); // Use service function to destroy comment

        $this->comments = Comment::with(['modelable', 'userable'])->get(); // Refresh comments after deleting

    }

}
