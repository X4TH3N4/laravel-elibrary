<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\Copy;
use App\Models\User;

class CopyPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view-any Copy');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Copy $copy): bool
    {
        return $user->can('view Copy');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create Copy');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Copy $copy): bool
    {
        return $user->can('update Copy');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Copy $copy): bool
    {
        return $user->can('delete Copy');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Copy $copy): bool
    {
        return $user->can('restore Copy');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Copy $copy): bool
    {
        return $user->can('force-delete Copy');
    }
}
