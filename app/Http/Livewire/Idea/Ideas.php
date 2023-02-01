<?php

namespace App\Http\Livewire\Idea;

use App\Models\Categorie;
use App\Models\Ideas as ModelsIdeas;
use App\Models\Status;
use App\Traits\WithAuthRedirects;
use Livewire\Component;
use Livewire\WithPagination;

class Ideas extends Component
{
    use WithPagination, WithAuthRedirects;

    public $status = 'All';

    public $category;

    public $filter;

    // public $;
    public $search;

    public $isReatyToLoad = false;

    public function loadData()
    {
        $this->isReatyToLoad = true;
    }

    protected $queryString = [
        'status' => ['except' => 'All'],
        'category' => ['except' => ''],
        'search' => ['except' => ''],
        'filter' => ['except' => ''],
    ];

    protected $listeners = [
        'statusWasUpdated',
        'ideaCreate' => '$refresh',
    ];

    public function render()
    {
        // $states = redisGet('status.all', function () {
        //     return Status::select('name', 'id')->pluck('id', 'name');
        // });

        $ideas = [];
        $categorys = [];
        
        if ($this->isReatyToLoad) {
//             sleep(4);
            $states = Status::select('name', 'id')->pluck('id', 'name');

                 $ideas = ModelsIdeas::query()
                ->when(strlen($this->search) > 3, function ($query) {
                    return $query->where('title', 'like', '' . $this->search . '%');
                })
                ->when($this->status && $this->status !== 'All', function ($query) use ($states) {
                    return $query->where('status_id', $states->get($this->status));
                })
                ->when($this->category, function ($query) {
                    return $query->where('category_id', $this->category);
                })
                ->addVotedBy()
                ->filterBy($this->filter)
                ->with('user:id,name,profile_photo_path,is_verified', 'category:id,name', 'status')
                ->withCount(['votes', 'comments', 'report', 'spams'])
                ->orderByDesc('id')
                ->fastPaginate(10)
                ->withQueryString();

            $categorys = redisRememberForever('categorys.all', function () {
                return  Categorie::toBase()->select('id', 'name')->get();
            });
        }

        return view('livewire.idea.ideas', compact('ideas', 'categorys'));
    }

    public function statusWasUpdated($status)
    {
        $this->status = $status;
        $this->resetPage();
    }

    public function updatedCategory()
    {
        $this->resetPage();
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedFilter()
    {
        if ($this->filter === 'myIdeas') {
            if (!auth()->check()) {
                return $this->redirectToLogin();
            }
        }
        $this->resetPage();
    }

    public function updatedStatus()
    {
        $this->resetPage();
    }
}
