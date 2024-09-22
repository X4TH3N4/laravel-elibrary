<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\Prose;
use App\Models\User;

class ProsePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view-any Prose');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Prose $prose): bool
    {
        return $user->can('view Prose');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create Prose');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Prose $prose): bool
    {
        return $user->can('update Prose');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Prose $prose): bool
    {
        return $user->can('delete Prose');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Prose $prose): bool
    {
        return $user->can('restore Prose');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Prose $prose): bool
    {
        return $user->can('force-delete Prose');
    }
}
