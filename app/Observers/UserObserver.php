<?php

namespace App\Observers;

use App\Models\User;
use Illuminate\Support\Facades\Log;
use Mockery\Exception;

class UserObserver
{
    public function created(User $user): void
    {
        $rol = 'User';

        $user->assignRole($rol);

        Log::info('User created with role: ' . $rol);
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        try {
            $rol = 'User';

            $user->assignRole($rol);
        } catch (Exception $e) {
            Log::info($e);
        }
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        // ...
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        // ...
    }

    /**
     * Handle the User "forceDeleted" event.
     */
    public function forceDeleted(User $user): void
    {
        // ...
    }
}
