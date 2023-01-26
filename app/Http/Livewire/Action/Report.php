<?php

namespace App\Http\Livewire\Action;

use Illuminate\Support\Facades\RateLimiter;
use Livewire\Component;
use WireUi\Traits\Actions;

class Report extends Component
{
    use Actions;

    public $model;

    public $model_id;

    public $subject = 'Spam';

    public $reason = 'The post contains offensive or inappropriate content that violates our community guidelines.';

    protected $rules = [
        'subject' => 'required|min:3|max:255',
        'reason' => 'required|min:10',
    ];

    public function mount($model, $model_id)
    {
        $this->model = $model;
        $this->model_id = $model_id;
    }

    public function reported()
    {
        $this->validate();

        $executed = RateLimiter::attempt(
            'send-report:'.auth()->id(),
            $perMinute = 1,
            function () {
                $this->model::find($this->model_id)->report()->create([
                    'user_id' => auth()->id(),
                    'subject' => $this->subject,
                    'reason' => $this->reason,
                ]);
                $this->emit('reportWasMake');
                $this->notification()->success('Success', 'Reported successfully');
            }
        );

        if (! $executed) {
            return $this->notification()->error('Error', 'Plz wait a until u do next report');
        }

        // $this->reset();
    }

    public function render()
    {
        return view('livewire.action.report');
    }
}
