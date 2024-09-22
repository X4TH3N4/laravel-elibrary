<?php

namespace App\Models;

use Althinect\FilamentSpatieRolesPermissions\Concerns\HasSuperAdmin;
use Filament\Facades\Filament;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasAvatar;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;
use Rappasoft\LaravelAuthenticationLog\Models\AuthenticationLog;
use Rappasoft\LaravelAuthenticationLog\Traits\AuthenticationLoggable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements HasMedia, FilamentUser, HasAvatar
{
    use HasApiTokens, HasFactory, Notifiable, HasSuperAdmin, HasRoles, InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_active'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed'
    ];


    public function canLogin(): bool
    {
        return $this->is_active;
    }
    public function canAccessPanel(Panel $panel): bool
    {
        if (!($this->canLogin())) {
           if (Auth::check()) Auth::logout();
        }
        return true;
    }

    public function getFilamentAvatarUrl(): ?string
    {
        return $this->avatar_url;
    }

}
