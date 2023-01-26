<?php

namespace App\Policies;

use App\Models\Comments;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommentPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        //
    }

    public function view(User $user, Comments $comments)
    {
        return $user->id === (int) $comments->user_id;
    }

    public function create(User $user)
    {
        return auth()->check();
    }

    public function update(User $user, Comments $comments)
    {
        return $user->id === (int) $comments->user_id;
    }

    public function delete(User $user, Comments $comments)
    {
        return (int) $user->id === (int) $comments->user_id || $user->can('comment_delete');
    }

    public function restore(User $user, Comments $comments)
    {
        //
    }

    public function forceDelete(User $user, Comments $comments)
    {
        //
    }

    public function mark_as_spam(User $user, Comments $comments)
    {
        return ! $comments->is_status_update && ! (auth()->id() == $comments->user_id);
    }
}
