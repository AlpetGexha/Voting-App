<?php

namespace App\Http\Livewire\Action;

use App\Traits\WithAuthRedirects;
use Illuminate\Support\Facades\Redis;
use Livewire\Component;

class Like extends Component
{
    use WithAuthRedirects;

    public $model;

    public $model_id;

    public $count;

    public $likedBy;

    public $isLike;

    public function mount($model, $model_id, $likedBy, $count)
    {
        $this->model = $model;
        $this->model_id = $model_id;
        $this->likedBy = $likedBy;
        $this->count = $count;
        $this->isLike = auth()->check() && $likedBy == auth()->id() ? true : false;
    }

    public function like()
    {
        if (! auth()->check()) {
            return $this->redirectToLogin();
        }

        $model = $this->model::findOrFail($this->model_id);
        $this->toggleLike($model);

        $this->emit('liked');
    }

    private function toggleLike($model)
    {
        if (auth()->user()->hasLiked($model)) {
            auth()->user()->unlike($model);
            Redis::decr('ideas.comments.like.'.$this->model_id);
        } else {
            auth()->user()->like($model);
            Redis::incr('ideas.comments.like.'.$this->model_id);
        }
    }

    public function render()
    {
        return view('livewire.action.like');
    }
}
