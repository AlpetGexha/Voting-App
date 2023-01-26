<?php

namespace App\Http\Livewire\Idea;

use App\Models\Ideas;
use Livewire\Component;
use WireUi\Traits\Actions;

class Delete extends Component
{
    use Actions;

    public $idea;

    public function mount(Ideas $idea)
    {
        $this->idea = $idea;
    }

    public function delete()
    {
        abort_if(auth()->guest() || auth()->user()->cannot('delete', $this->idea), 403);

        Ideas::destroy($this->idea->id);

        $this->notification()->success('Success', 'Idea deleted successfully');
        $this->emit('ideaWasDeleted', $this->idea->id);

        return to_route('ideas.ideas');
    }

    public function render()
    {
        return view('livewire.idea.delete');
    }
}
