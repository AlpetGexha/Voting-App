<?php

namespace App\Http\Livewire\Idea;

use App\Models\Categorie;
use App\Models\Ideas;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Component;
use Spatie\Honeypot\Http\Livewire\Concerns\HoneypotData;
use WireUi\Traits\Actions;

class Create extends Component
{
    use AuthorizesRequests, Actions;

    public $title;

    public $body;

    public $category = 1;

    protected $rules = [
        'title' => 'required|min:3|max:255',
        'body' => 'required|min:10',
        'category' => 'required',
    ];

    // public HoneypotData $extraFields;

    public function mount()
    {
        // $this->extraFields = new HoneypotData();
    }

    public function create()
    {
        abort_if(auth()->guest(), 403, 'You must be logged in to create an idea');

        if (auth()->user()->isBanned()) {
            return $this->notification()->error('Error', 'You are banned');
        }

        if (auth()->user()->isBlackList()) {
            return $this->notification()->error('Error', 'You are on blacklist');
        }

        $this->validate();

        // check if category exist
        $category = Categorie::find($this->category);
        if (! $category) {
            $this->notification()->error('Error', 'Category not found');

            return;
        }

        $executed = RateLimiter::attempt(
            'send-idea:'.auth()->id(),
            1,
            function () {
                // $this->protectAgainstSpam(); // if is spam, will abort the request
                $idea = Ideas::create([
                    'category_id' => $this->category,
                    'status_id' => 1,
                    'title' => $this->title,
                    'body' => $this->body,
                ]);

                $idea->vote();

                $this->notification()->success('Success', 'Ideas created Successfull');
                $this->emit('ideaCreate');
                $this->reset();
            }
        );

        if (! $executed) {
            $seconds = RateLimiter::availableIn('send-idea:'.auth()->id());
            $this->notification()->warning('Warning', "You have reached the limit. Plz wait for next {$seconds}");
        }
        // return to_route('ideas.ideas');
    }

    public function render()
    {
        $categories = redisGet('categorys.all', function () {
            return Categorie::toBase()->select('id', 'name')->get();
        });

        return view('livewire.idea.create', compact('categories'));
    }
}
