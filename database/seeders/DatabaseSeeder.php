<?php

namespace Database\Seeders;

use Althinect\FilamentSpatieRolesPermissions\Commands\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Artisan::call('permissions:sync');

    $this->call([
        CitySeeder::class,
        OccupationSeeder::class,
        PermissionRoleSeeder::class,
        AdminSeeder::class,
    ]);
    }
}
