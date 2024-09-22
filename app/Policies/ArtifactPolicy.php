<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\Artifact;
use App\Models\User;

class ArtifactPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view-any Artifact');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Artifact $artifact): bool
    {
        return $user->can('view Artifact');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create Artifact');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Artifact $artifact): bool
    {
        return $user->can('update Artifact');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Artifact $artifact): bool
    {
        return $user->can('delete Artifact');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Artifact $artifact): bool
    {
        return $user->can('restore Artifact');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Artifact $artifact): bool
    {
        return $user->can('force-delete Artifact');
    }
}
