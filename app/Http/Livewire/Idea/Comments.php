<?php

namespace App\Http\Livewire\Idea;

use App\Models\Ideas;
use Livewire\Component;
use Livewire\WithPagination;

class Comments extends Component
{
    use WithPagination;

    public $idea;

    public $readyToLoad = false;
    protected $listeners = [
        'commentWasAdded' => '$refresh',
        'commentWasDeleted' => '$refresh',
        'statusUpdated' => '$refresh',
        'commentWasMarkedAsNotSpam' => '$refresh',
        'commentWasMarkedAsSpam' => '$refresh',
    ];

    public function mount(Ideas $idea)
    {
        if($this->readyToLoad)
            $this->idea = $idea;
    }

    public function loadComments()
    {
        $this->readyToLoad = true;
    }

    // public function isUpdated(): bool
    // {
    //     return !$this->is_status_update;
    // }

    public function render()
    {

        if (!$this->readyToLoad) {
            $comments = [];
        }

        $comments = $this->idea->comments()
            ->with('user.roles', 'status')
            ->isLikeByUser()
            ->withCount('spams')
            ->orderByDesc('id')
            // ->addSelect(['my_id' => auth()->id()])
            ->fastPaginate(5)
            ->withQueryString();
        // dd($comments);

        return view('livewire.idea.comments', compact('comments'));
    }
}
