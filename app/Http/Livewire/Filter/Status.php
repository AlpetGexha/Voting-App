<?php

namespace App\Http\Livewire\Filter;

use App\Models\Status as ModelsStatus;
use Illuminate\Support\Facades\Route;
use Livewire\Component;

class Status extends Component
{
    public $status;

    public $countStatus;

    public function mount()
    {
        $this->countStatus = cache()->remember('countStatus', now()->addDay(), function () {
            return ModelsStatus::getCount();
        });

        $this->status = request()->status ?? 'All';

        if (Route::currentRouteName() === 'idea.show') {
            $this->status = null;
            $this->queryString = [];
        }
    }

    public function setStatus($status)
    {
        $this->status = $status;
        $this->emit('statusWasUpdated', $this->status);
        if ($this->getPreviousRouteName() == 'ideas.show') {
            return to_route('ideas.ideas', [
                'status' => $this->status,
            ]);
        }
    }

    public function render()
    {
        return view('livewire.filter.status');
    }

    private function getPreviousRouteName()
    {
        return app('router')->getRoutes()->match(app('request')->create(url()->previous()))->getName();
    }
}
