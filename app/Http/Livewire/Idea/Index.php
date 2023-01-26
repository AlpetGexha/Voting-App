<?php

namespace App\Http\Livewire\Idea;

use App\Models\Ideas;
use App\Traits\WithAuthRedirects;
use Livewire\Component;
use WireUi\Traits\Actions;

class Index extends Component
{
    use WithAuthRedirects, Actions;

    public $idea;

    public $voteCount;

    public $hasVoted;

    public function mount(Ideas $idea, int $voteCount)
    {
        $this->idea = $idea;
        $this->voteCount = $voteCount;
        $this->hasVoted = $idea->isVotedBy;
    }

    public function vote()
    {
        if (! auth()->check()) {
            return $this->redirectToLogin();
        }

        if ($this->idea->isClosed()) {
            return $this->notification()->warning('Wait', 'This Ideas is CLOSE');
        }

        if ($this->hasVoted) {
            $this->voted();
        } else {
            $this->unVoted();
        }
    }

    private function voted()
    {
        $this->idea->unVote();
        $this->voteCount--;
        $this->hasVoted = false;
    }

    private function unVoted()
    {
        $this->idea->vote();
        $this->voteCount++;
        $this->hasVoted = true;
    }

    public function render()
    {
        return view('livewire.idea.index');
    }
}
