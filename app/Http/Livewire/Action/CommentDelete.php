<?php

namespace App\Http\Livewire\Action;

use App\Models\Comments;
use Livewire\Component;
use WireUi\Traits\Actions;

class CommentDelete extends Component
{
    use Actions;

    public $comment;

    protected $listeners = ['setDeleteComment'];

    public function setDeleteComment($commentId)
    {
        $this->comment = Comments::findOrFail($commentId);

        $this->emit('deleteCommentWasSet');
    }

    public function delete()
    {
        abort_if(auth()->guest() || auth()->user()->cannot('delete', $this->comment), 403);

        Comments::destroy($this->comment->id);

        $this->emit('commentWasDeleted');
        $this->notification()->success('Success', 'Comment was deleted successfully');
        $this->reset('comment');
    }

    public function render()
    {
        return view('livewire.action.comment-delete');
    }
}
