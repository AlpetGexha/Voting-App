<?php

namespace App\Http\Livewire\Action;

use App\Models\Comments;
use Livewire\Component;
use WireUi\Traits\Actions;

class SpamRemove extends Component
{
    use Actions;

    protected $listeners = ['setMarkAsNotSpamComment'];

    public $spam;

    public function setMarkAsNotSpamComment($spamId)
    {
        $this->spam = Comments::findOrFail($spamId);

        $this->emit('markAsNotSpamCommentWasSet');
    }

    public function removeAllSpams()
    {
        abort_if(! auth()->check() && ! auth()->user()->isAdmin(), 403);

        // remove all spams from this comment
        $this->spam->removeAllSpam();

        $this->notification()->success('Success', 'Comment marked as not spam successfully');
        $this->emit('commentWasMarkedAsNotSpam');
        $this->reset('spam');
    }

    public function render()
    {
        return view('livewire.action.spam-remove');
    }
}
