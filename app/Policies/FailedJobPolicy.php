<?php

namespace App\Policies;

use Amvisor\FilamentFailedJobs\Models\FailedJob;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class FailedJobPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return $user->can('view_any_failed::jobs');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \Amvisor\FilamentFailedJobs\Models\FailedJob  $failedJob
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, FailedJob $failedJob)
    {
        return $user->can('view_failed::jobs');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->can('create_failed::jobs');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \Amvisor\FilamentFailedJobs\Models\FailedJob  $failedJob
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, FailedJob $failedJob)
    {
        return $user->can('update_failed::jobs');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \Amvisor\FilamentFailedJobs\Models\FailedJob  $failedJob
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, FailedJob $failedJob)
    {
        return $user->can('delete_failed::jobs');
    }

    /**
     * Determine whether the user can bulk delete.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function deleteAny(User $user)
    {
        return $user->can('delete_any_failed::jobs');
    }

    /**
     * Determine whether the user can permanently delete.
     *
     * @param  \App\Models\User  $user
     * @param  \Amvisor\FilamentFailedJobs\Models\FailedJob  $failedJob
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, FailedJob $failedJob)
    {
        return $user->can('force_delete_failed::jobs');
    }

    /**
     * Determine whether the user can permanently bulk delete.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDeleteAny(User $user)
    {
        return $user->can('force_delete_any_failed::jobs');
    }

    /**
     * Determine whether the user can restore.
     *
     * @param  \App\Models\User  $user
     * @param  \Amvisor\FilamentFailedJobs\Models\FailedJob  $failedJob
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, FailedJob $failedJob)
    {
        return $user->can('restore_failed::jobs');
    }

    /**
     * Determine whether the user can bulk restore.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restoreAny(User $user)
    {
        return $user->can('restore_any_failed::jobs');
    }

    /**
     * Determine whether the user can replicate.
     *
     * @param  \App\Models\User  $user
     * @param  \Amvisor\FilamentFailedJobs\Models\FailedJob  $failedJob
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function replicate(User $user, FailedJob $failedJob)
    {
        return $user->can('replicate_failed::jobs');
    }

    /**
     * Determine whether the user can reorder.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function reorder(User $user)
    {
        return $user->can('reorder_failed::jobs');
    }
}
