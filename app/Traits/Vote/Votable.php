<?php

namespace App\Traits\Vote;

use App\Models\User;

trait Votable
{
    public function votes()
    {
        return $this->belongsToMany(User::class, 'votes')->withTimestamps();
    }

    public function isVotedBy(?User $user)
    {
        if (! $user) {
            return false;
        }

        return $this->votes()->where('user_id', $user->id)->exists();
    }

    public function vote(?User $user = null)
    {
        if (! $user) {
            $user = auth()->user();
        }

        if ($this->isVotedBy($user)) {
            return;
        }

        $this->votes()->attach($user);
    }

    public function unVote(User $user = null)
    {
        // check if user is null
        if (! $user) {
            $user = auth()->user();
        }

        // check if vote exist
        if (! $this->isVotedBy($user)) {
            return;
        }

        $this->votes()->detach($user);
    }
}
