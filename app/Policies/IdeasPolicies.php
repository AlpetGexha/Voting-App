<?php

namespace App\Policies;

use App\Models\Ideas;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class IdeasPolicies
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        //
    }

    public function view(User $user, Ideas $idea)
    {
        //
    }

    public function create(User $user)
    {
        //
    }

    public function update(User $user, Ideas $idea)
    {
        return $user->id === (int) $idea->user_id && now()->subHour() <= $idea->created_at;
    }

    public function delete(User $user, Ideas $idea)
    {
        return $user->id === (int) $idea->user_id;
    }

    // can report
    public function report(User $user, Ideas $idea)
    {
        if ($user->id == $idea->id) {
            return false;
        }

        if ($idea->isNotClose()) {
            return false;
        }

        if ($idea->report()->where('user_id', $user->id)->exists()) {
            return false;
        }

        if ($idea->report()->whereIsNull('user_id')) {
            if ($idea->report()->where('ip', request()->ip())->where('user_agent', request()->userAgent())->exists()) {
                return false;
            }
        }

        return false;
    }

    public function restore(User $user, Ideas $idea)
    {
        //
    }

    public function forceDelete(User $user, Ideas $idea)
    {
        //
    }
}
