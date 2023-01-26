<?php

namespace App\Http\Livewire\Action;

use App\Models\Comments;
use App\Models\Ideas;
use App\Models\Status;
use App\Notifications\StatusUpdatedNotification;
use Livewire\Component;
use WireUi\Traits\Actions;

class SetStatus extends Component
{
    use Actions;

    public $status;

    public $idea;

    public $comment;

    public $notifyUsers = false;

    public function mount(Ideas $idea)
    {
        $this->idea = $idea;
        $this->status = $this->idea->status_id;
    }

    public function setStatus()
    {
        if ($this->status == $this->idea->status_id) {
            $this->notification()->error('Error', 'Please select a different status.');

            return;
        }

        $this->idea->status_id = $this->status;
        $this->idea->save();

        if ($this->notifyUsers) {
            $this->notifiyAllUser();
        }

        Comments::create([
            'ideas_id' => $this->idea->id,
            'status_id' => $this->status,
            'body' => $this->comment ?? 'No comment was added.',
            'is_status_update' => true,
        ]);

        $this->reset('comment');
        $this->notification()->success('Success', 'Status updated successfully');
        $this->emit('statusUpdated');
    }

    private function notifiyAllUser()
    {
        $this->idea->votes()
            ->each(function ($user) {
                // dd($user);
                $user->notify(new StatusUpdatedNotification());
            });
    }

    public function render()
    {
        $statuss = cache()->rememberForever('status.all', function () {
            return Status::toBase()->select('id', 'name')->get();
        });

        return view('livewire.action.set-status', compact('statuss'));
    }
}
