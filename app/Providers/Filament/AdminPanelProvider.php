<?php

namespace App\Providers\Filament;

use Althinect\FilamentSpatieRolesPermissions\FilamentSpatieRolesPermissionsPlugin;
use Althinect\FilamentSpatieRolesPermissions\Resources\PermissionResource;
use Althinect\FilamentSpatieRolesPermissions\Resources\RoleResource;
use App\Filament\Resources\UserResource;
use App\Models\Copy;
use App\Models\User;
use Awcodes\FilamentQuickCreate\QuickCreatePlugin;
use Awcodes\LightSwitch\Enums\Alignment;
use Awcodes\LightSwitch\LightSwitchPlugin;
use BezhanSalleh\FilamentLanguageSwitch\FilamentLanguageSwitchPlugin;
use EightyNine\ExcelImport\ExcelImportPlugin;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Hasnayeen\Themes\Http\Middleware\SetTheme;
use Hasnayeen\Themes\ThemesPlugin;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Kainiklas\FilamentScout\Providers\ScoutGlobalSearchProvider;
use Njxqlus\FilamentProgressbar\FilamentProgressbarPlugin;
use Orion\FilamentBackup\BackupPlugin;
use pxlrbt\FilamentSpotlight\SpotlightPlugin;
use Shanerbaner82\PanelRoles\PanelRoles;
use ShuvroRoy\FilamentSpatieLaravelBackup\FilamentSpatieLaravelBackupPlugin;
use Spatie\Activitylog\Models\Activity;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tapp\FilamentAuthenticationLog\FilamentAuthenticationLogPlugin;
use Z3d0X\FilamentLogger\Resources\ActivityResource;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->authGuard('web')
            ->profile(Pages\Auth\EditProfile::class)
            ->font('Poppins')
            ->colors([
                'danger' => Color::Rose,
                'info' => Color::Blue,
                'primary' => Color::Amber,
                'success' => Color::Emerald,
                'warning' => Color::Orange,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
            ])
            ->middleware([
                SetTheme::class,
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->plugins([
                FilamentSpatieRolesPermissionsPlugin::make(),
                SpotlightPlugin::make(),
                FilamentSpatieLaravelBackupPlugin::make(),
                LightSwitchPlugin::make()
                    ->position(Alignment::TopCenter),
                FilamentProgressbarPlugin::make()->color('#FBBF24'),
                QuickCreatePlugin::make()->excludes([
                    ActivityResource::class,
                    RoleResource::class,
                    PermissionResource::class,
                    UserResource::class,
                ])->sort(false)->slideOver(),
                ThemesPlugin::make(),
                ExcelImportPlugin::make(),
                PanelRoles::make()->roleToAssign('User')->restrictedRoles(['User']),
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->resources([
                config('filament-logger.activity_resource')
            ]);


    }
}
