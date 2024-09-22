<?php

namespace App\Providers;

use App\Models\User;
use App\Policies\ActivityPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Spatie\Activitylog\Models\Activity;
use Filament\Models\Contracts\FilamentUser;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Policies\PermissionPolicy;
use App\Policies\RolePolicy;
use App\Policies\UserPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Permission::class => PermissionPolicy::class,
        Role::class => RolePolicy::class,
        FilamentUser::class => UserPolicy::class,
        User::class => UserPolicy::class,
        Activity::class => ActivityPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {



        $this->registerPolicies();
        Gate::before(function (User $user, string $ability) {
            return $user->isSuperAdmin() ? true: null;
        });
    }
}
