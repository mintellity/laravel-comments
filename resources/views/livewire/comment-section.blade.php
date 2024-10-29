<div>
    <div>
        <form wire:submit="store">
            <div class="card mb-6">
                <div class="card-body p-2">
                    <div class="form-group">
                            <textarea wire:model.defer="commentContent" class="form-control" name="comment_content"
                                      id="comment_content" rows="4" placeholder="Schreibe einen Kommentar..."
                                      x-data
                                      @keydown.enter.prevent="if (!$event.shiftKey) { $wire.store() } else { $event.target.value += '\n'; $event.target.dispatchEvent(new Event('input')) }"></textarea>

                    </div>
                    {{-- Button Group --}}
                    <div class="d-flex justify-content-end mt-3 gap-1">
                        <button wire:click="store" type="button" class="btn btn-success btn-sm">
                            Speichern
                        </button>
                        <button wire:click="resetForm" class="btn btn-sm btn-secondary">
                            Abbrechen
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div>
        @if($comments->isEmpty())
            <p>Es sind noch keine Kommentare vorhanden.</p>
        @endif
    </div>
    <div>
        @foreach($comments as $comment)
            <div class="card mb-3">
                <div class="card-body p-2">
                    <div class="d-flex justify-content-between align-items-center ">
                        <strong> {{ $comment->userable?->getName() ?? 'No user found' }}</strong>
                        <small style="font-size: 10px" class="mb-5">{{ $comment->created_at->format('d M Y, h:i:s') }}</small>
                    </div>
                    <div style="position: relative;">
                        <p class="mb-0" style="padding-right: 50px;">{!! $comment->comment_content !!}</p>

                        @if($comment->userable_id === auth()->user()->userable->getKey())
                            <button
                                    type="button"
                                    wire:click="destroy('{{ $comment->comment_id }}')"
                                    class="btn btn-outline-danger btn-sm fa fa-trash-alt"
                                    style="position: absolute; bottom: 0; right: 0;">
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
