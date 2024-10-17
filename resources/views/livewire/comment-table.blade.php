<div>
    <div>
        @if($comments->isEmpty())
            <p>No comments available.</p>
        @endif
    </div>
    <div>
        @foreach($comments as $comment)
            <div class="card mb-3">
                <div class="card-body p-3">
                    From: <strong> {{ $comment->userable?->getName() ?? 'No user found' }}</strong>
                    <br>
                    <p class="mb-0">{{ $comment->comment_content }}</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <small style="font-size: 10px">Created
                            at: {{ $comment->created_at->format('d M Y, h:i:s') }}</small>
                        @if($comment->userable_id === auth()->user()->userable->getKey())
                            <button
                                type="button"
                                wire:click="destroy('{{ $comment->comment_id }}')"
                                class="btn btn-danger btn-sm fa fa-trash-alt">
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div>
        <form wire:submit="store">
            <div class="card mb-6">
                <div class="card-body">
                    <div class="form-group">
                        <textarea wire:model="commentContent" class="form-control" name="commentContent"
                                  id="commentContent" wire:keydown.enter="store"
                                  rows="4" placeholder="Write a comment..."></textarea>
                    </div>
                    <button type="button" class="btn btn-success">
                        Save
                    </button>
                    <button wire:click="resetForm" class="btn btn-secondary">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>
