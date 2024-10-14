<div>
    <div>
        @if($comments->isEmpty())
            <p>No comments available.</p>
        @endif
    </div>
    <div>
        <ul>
            @foreach($comments as $comment)
                <li>
                    From: <strong> {{ $comment->userable->getName() }}</strong>
                    <br><br>
                    <p>{{ $comment->comment_content }}</p>
                    <small>Created at: {{ $comment->created_at->format('d M Y') }}</small>

{{--                    @if($editCommentId === $comment->userable_id)--}}
{{--                        <form wire:submit.prevent="update">--}}
{{--                            <input type="text" wire:model="editContent" wire:keydown.enter="update" class="form-control"--}}
{{--                                   name="comment_content"--}}
{{--                                   id="comment_content" value="{{ $comment->comment_content }}">--}}
{{--                            <button type="submit" class="btn btn-success">Save</button>--}}
{{--                            <button wire:click.prevent="edit({{ $comment->userable_id }})" class="btn btn-warning">--}}
{{--                                Edit--}}
{{--                            </button>--}}
{{--                            <button wire:click.prevent="destroy({{ $comment->userable_id }})"--}}
{{--                                    wire:confirm="Are you sure you want to delete this comment?" class="btn btn-danger">--}}
{{--                                Delete--}}
{{--                            </button>--}}
{{--                        </form>--}}
{{--                    @endif--}}
                </li>
            @endforeach
        </ul>
    </div>
    <div>
        <form wire:submit="store">
            <div class="card mb-6">
                <div class="card-body">
                    <div class="form-group">
                        <label for="commentContent">Comment</label>
                        <textarea wire:model="commentContent" class="form-control" name="commentContent"
                                  id="commentContent" wire:keydown.enter="store"
                                  rows="4" placeholder="Write a comment..."></textarea>
                    </div>
                    <button wire:confirm="Do you want to submit the comment?" type="submit" class="btn btn-success">
                        Save
                    </button>
                    <button wire:click="resetForm" class="btn btn-secondary">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>
