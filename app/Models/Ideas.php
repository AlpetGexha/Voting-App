<?php

namespace App\Models;

use App\Traits\Report\Reported;
use App\Traits\Spam\Spamable;
use App\Traits\Vote\Votable;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable as  AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;

class Ideas extends Model implements Auditable
{
    use HasFactory, Sluggable, Votable, Spamable, AuditableTrait, Reported;

    protected $fillable = [
        'user_id', 'category_id', 'status_id', 'title', 'body', 'slug',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Categorie::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function comments()
    {
        return $this->hasMany(Comments::class);
    }

    public function isClosed(): bool
    {
        return $this->status_id === Status::CLOSED;
    }

    public function isOpen(): bool
    {
        return $this->status_id === Status::OPEN;
    }

    public function isNotClose()
    {
        return $this->status_id !== Status::CLOSED;
    }

    public function getVoteCountAttribute()
    {
        return $this->votes()->count();
    }

    public function scopeAddVotedBy($query): Builder
    {
        return $query
            ->addSelect([
                'isVotedBy' => Vote::select('id')
                    ->where('user_id', auth()->id())
                    ->whereColumn('ideas_id', 'ideas.id'),
            ]);
    }

    public function scopeFilterBy($query, $filter)
    {
        if ($filter === 'trending') {
            return $query->orderBy('votes_count', 'desc');
        }

        if ($filter === 'mostVotedOnWeek') {
            return $query->orderBy('votes_count', 'desc')
                ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
        }

        if ($filter === 'mostVotedOnMounth') {
            return $query->orderBy('votes_count', 'desc')
                ->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()]);
        }

        if ($filter === 'myIdeas') {
            return $query->where('user_id', auth()->id());
        }

        if ($filter === 'spamIdeas') {
            if (auth()->user()->isAdmin()) {
                return $query->orderByDesc('spam_count');
            }
        }

        if ($filter === 'reportedIdeas') {
            if (auth()->user()->isAdmin()) {
                return $query->orderByDesc('report_count');
            }
        }

        return $query;
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title',
            ],
        ];
    }

    // make user id auth id while creating event

    public function getStatusClass()
    {
        // dd($this->status);
        $allStatus = [
            1 => 'bg-gray-200 ',
            2 => 'bg-red-500 text-white ',
            3 => 'bg-purple-500 text-white ',
            4 => 'bg-yellow-500 text-white ',
            5 => 'bg-green-500 text-white ',
        ];

        return $allStatus[$this->status_id] ?? null;
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($idea) {
            if (auth()->check()) {
                $idea->user_id = auth()->id();
            }
        });

        // remove cache after created
        static::created(function ($idea) {
            cache()->forget('countStatus');
        });
    }
}
