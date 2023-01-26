<?php

namespace App\Http\Livewire\Action;

use App\Models\Comments;
use Livewire\Component;
use WireUi\Traits\Actions;

class SpamAdd extends Component
{
    use Actions;

    public $comment;

    protected $listeners = ['setMarkAsSpamComment'];

    public function setMarkAsSpamComment($commentId)
    {
        $this->comment = Comments::findOrFail($commentId);

        $this->emit('markAsSpamCommentWasSet');
    }

    public function markAsSpam()
    {
        abort_if(! auth()->check(), 403);

        $this->comment->markAsSpam();

        $this->notification()->success('Success', 'Comment marked as spam successfully');
        $this->emit('commentWasMarkedAsSpam');
        $this->reset('comment');
    }

    public function render()
    {
        return view('livewire.action.spam-add');
    }
}
