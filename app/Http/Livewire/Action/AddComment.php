<?php

namespace App\Http\Livewire\Action;

use App\Notifications\CommentAddedNotification;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use WireUi\Traits\Actions;

class AddComment extends Component
{
    use Actions;

    public $idea;

    public $body;

    protected $rules = [
        'body' => 'required|min:4',
    ];

    public function mount($idea)
    {
        $this->idea = $idea;
    }

    protected $listeners = [
        'statusUpdated' => '$refresh',
    ];

    public function create()
    {
        abort_if(auth()->guest(), 403);

        if ($this->idea->isClosed()) {
            return $this->notification()->warning('Wait', 'This Ideas is CLOSE');
        }

        $this->validate();

        DB::transaction(function () {
            $addComment = $this->idea->comments()->create([
                'body' => $this->body,
            ]);

            $this->reset('body');

            // check if the user is not the owner of the idea
            if (auth()->id() !== $this->idea->user_id) {
                $this->idea->user->notify(new CommentAddedNotification($addComment, $this->idea));
            }

            $this->emit('commentWasAdded');
            $this->notification()->success('Success', 'Comment was added successfully');
        });
    }

    public function render()
    {
        return view('livewire.action.add-comment');
    }
}
