<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\User;
use Filament\Models\Contracts\FilamentUser;

class UserPolicy
{
    /**
     * Determine whether the User can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view-any User');
    }

    /**
     * Determine whether the User can view the model.
     */
    public function view(User $user, User $test): bool
    {
        return $user->can('view User');
    }

    /**
     * Determine whether the User can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create User');
    }

    /**
     * Determine whether the User can update the model.
     */
    public function update(User $user, User $test): bool
    {
        return $user->can('update User');
    }

    /**
     * Determine whether the User can delete the model.
     */
    public function delete(User $user, User $test): bool
    {
        return $user->can('delete User');
    }

    /**
     * Determine whether the User can restore the model.
     */
    public function restore(User $user, User $test): bool
    {
        return $user->can('restore User');
    }

    /**
     * Determine whether the User can permanently delete the model.
     */
    public function forceDelete(User $user, User $test): bool
    {
        return $user->can('force-delete User');
    }
}
