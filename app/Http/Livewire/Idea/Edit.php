<?php

namespace App\Http\Livewire\Idea;

use App\Models\Categorie;
use App\Models\Ideas;
use Livewire\Component;
use WireUi\Traits\Actions;

class Edit extends Component
{
    use Actions;

    public $idea;

    public $title;

    public $body;

    public $category;

    protected $rules = [
        'title' => 'required|min:4',
        'category' => 'required|integer|exists:categories,id',
        'body' => 'required|min:4',
    ];

    public function mount(Ideas $idea)
    {
        $this->idea = $idea;
        $this->title = $idea->title;
        $this->body = $idea->body;
        $this->category = $idea->category_id;
    }

    public function updateIdea()
    {
        abort_if(auth()->guest() || auth()->user()->cannot('update', $this->idea), 403);
        $this->validate();

        $this->idea->update([
            'title' => $this->title,
            'category_id' => $this->category,
            'body' => $this->body,
        ]);

        $this->emit('ideaWasUpdated');
        $this->notification()->success('Success', 'Idea updated successfully');
    }

    public function render()
    {
        return view('livewire.idea.edit', [
            'categories' => Categorie::select('id', 'name')->get(),
        ]);
    }
}
