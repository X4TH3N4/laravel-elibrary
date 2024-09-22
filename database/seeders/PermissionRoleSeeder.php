<?php

namespace Database\Seeders;

use App\Models\User;
use Exception;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionRoleSeeder extends Seeder
{
    private $permissions = [
        [
            'id' => 189,
            'name' => 'view-any Permission',
            'guard_name' => 'web',
        ],
        [
            'id' => 190,
            'name' => 'view-any Role',
            'guard_name' => 'web',
        ],
        [
            'id' => 191,
            'name' => 'view Permission',
            'guard_name' => 'web',
        ],
        [
            'id' => 192,
            'name' => 'view Role',
            'guard_name' => 'web',
        ],
        [
            'id' => 193,
            'name' => 'create Permission',
            'guard_name' => 'web',
        ],
        [
            'id' => 194,
            'name' => 'create Role',
            'guard_name' => 'web',
        ],
        [
            'id' => 195,
            'name' => 'update Permission',
            'guard_name' => 'web',
        ],
        [
            'id' => 196,
            'name' => 'update Role',
            'guard_name' => 'web',
        ],
        [
            'id' => 197,
            'name' => 'delete Permission',
            'guard_name' => 'web',
        ],
        [
            'id' => 198,
            'name' => 'delete Role',
            'guard_name' => 'web',
        ],
        [
            'id' => 199,
            'name' => 'restore Permission',
            'guard_name' => 'web',
        ],
        [
            'id' => 200,
            'name' => 'restore Role',
            'guard_name' => 'web',
        ],
        [
            'id' => 201,
            'name' => 'force-delete Permission',
            'guard_name' => 'web',
        ],
        [
            'id' => 202,
            'name' => 'force-delete Role',
            'guard_name' => 'web',
        ],
        [
            'id' => 203,
            'name' => 'replicate Permission',
            'guard_name' => 'web',
        ],
        [
            'id' => 204,
            'name' => 'replicate Role',
            'guard_name' => 'web',
        ],
        [
            'id' => 205,
            'name' => 'reorder Permission',
            'guard_name' => 'web',
        ],
        [
            'id' => 206,
            'name' => 'reorder Role',
            'guard_name' => 'web',
        ],
        [
            'id' => 207,
            'name' => 'view-any Permission',
            'guard_name' => 'api',
        ],
        [
            'id' => 208,
            'name' => 'view-any Role',
            'guard_name' => 'api',
        ],
        [
            'id' => 209,
            'name' => 'view Permission',
            'guard_name' => 'api',
        ],
        [
            'id' => 210,
            'name' => 'view Role',
            'guard_name' => 'api',
        ],
        [
            'id' => 211,
            'name' => 'create Permission',
            'guard_name' => 'api',
        ],
        [
            'id' => 212,
            'name' => 'create Role',
            'guard_name' => 'api',
        ],
        [
            'id' => 213,
            'name' => 'update Permission',
            'guard_name' => 'api',
        ],
        [
            'id' => 214,
            'name' => 'update Role',
            'guard_name' => 'api',
        ],
        [
            'id' => 215,
            'name' => 'delete Permission',
            'guard_name' => 'api',
        ],
        [
            'id' => 216,
            'name' => 'delete Role',
            'guard_name' => 'api',
        ],
        [
            'id' => 217,
            'name' => 'restore Permission',
            'guard_name' => 'api',
        ],
        [
            'id' => 218,
            'name' => 'restore Role',
            'guard_name' => 'api',
        ],
        [
            'id' => 219,
            'name' => 'force-delete Permission',
            'guard_name' => 'api',
        ],
        [
            'id' => 220,
            'name' => 'force-delete Role',
            'guard_name' => 'api',
        ],
        [
            'id' => 221,
            'name' => 'replicate Permission',
            'guard_name' => 'api',
        ],
        [
            'id' => 222,
            'name' => 'replicate Role',
            'guard_name' => 'api',
        ],
        [
            'id' => 223,
            'name' => 'reorder Permission',
            'guard_name' => 'api',
        ],
        [
            'id' => 224,
            'name' => 'reorder Role',
            'guard_name' => 'api',
        ],
        [
            'id' => 225,
            'name' => 'view-any Activity',
            'guard_name' => 'web',
        ],
        [
            'id' => 226,
            'name' => 'view Activity',
            'guard_name' => 'web',
        ],
        [
            'id' => 227,
            'name' => 'view-any Activity',
            'guard_name' => 'api',
        ],
        [
            'id' => 228,
            'name' => 'view Activity',
            'guard_name' => 'api',
        ],
    ];

    private $roles = [
        [
            'id' => 1,
            'name' => 'Super Admin',
            'guard_name' => 'web',
        ],
        [
            'id' => 2,
            'name' => 'User',
            'guard_name' => 'web'
        ]
    ];

    private $rolePermissions = [
        [
            'role_id' => 1,
            'permission_ids' => [189, 190, 191, 192, 193, 194, 195, 196, 197, 198, 199, 200, 201, 202, 203, 204, 205, 206],
        ]
    ];


    public function run(): void
    {
        foreach ($this->permissions as $permission) {
            Permission::query()->updateOrCreate([
                'id' => $permission['id'],
            ], $permission);
        }
        foreach ($this->roles as $role) {
            Role::query()->updateOrCreate([
                'id' => $role['id'],
            ], $role);
        }
        $array = range(57, 162);
        foreach ($this->rolePermissions as $rolePermission) {
            /** @var Role $role */
            Role::query()->where('id', 1)
                ->first()
                ->givePermissionTo($rolePermission['permission_ids']);
            Role::query()->where('id', 1)
                ->first()
                ->givePermissionTo(Permission::query()->where('guard_name', 'web')->get());
        }
        try {
            $permissions = Permission::where('guard_name', '=', 'web')->get();
            foreach ($permissions as $permission) {
                Role::query()->where('id', 2)
                    ->first()
                    ->givePermissionTo($permission);
            }
            $permissionsX = DB::table('permissions')->where('id', '<', 59)->get();
            foreach ($permissionsX as $permission) {
                DB::table('role_has_permissions')->where('permission_id', $permission->id)->delete();
            }
        } catch (Exception $e) {
            echo $e;
        }
        try {
            $permissions = Permission::where('guard_name', '=', 'web')->get();
            foreach ($permissions as $permission) {
                Role::query()->where('id', 2)
                    ->first()
                    ->givePermissionTo($permission);
                Role::query()->where('id', 2)
                    ->first()
                    ->givePermissionTo(Permission::query()->where('guard_name', 'web')->get());
                Role::query()->where('id', 1)
                    ->first()
                    ->givePermissionTo(Permission::query()->where('guard_name', 'web')->get());
            }
            $permissionsX = DB::table('permissions')->where('id', '<', 163)->get();
            $permissionsY = DB::table('permissions')->where('id', '>', 162)->get();
            foreach ($permissionsX as $permission) {
                DB::table('role_has_permissions')->where('permission_id', $permission->id)->where('role_id', 1)->delete();
            }
            foreach ($permissionsY as $permission) {
                DB::table('role_has_permissions')->where('permission_id', $permission->id)->where('role_id', 2)->delete();
            }
        } catch (Exception $e) {
            echo $e;
        }
       Artisan::call('optimize:clear');

    }
}
