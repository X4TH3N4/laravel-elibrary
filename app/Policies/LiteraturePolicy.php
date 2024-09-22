<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\Literature;
use App\Models\User;

class LiteraturePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view-any Literature');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Literature $literature): bool
    {
        return $user->can('view Literature');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create Literature');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Literature $literature): bool
    {
        return $user->can('update Literature');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Literature $literature): bool
    {
        return $user->can('delete Literature');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Literature $literature): bool
    {
        return $user->can('restore Literature');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Literature $literature): bool
    {
        return $user->can('force-delete Literature');
    }
}
