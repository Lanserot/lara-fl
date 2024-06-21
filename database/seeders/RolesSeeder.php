<?php

namespace Database\Seeders;

use App\Enums\RolePermissions;
use App\Enums\Roles;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    public function run(): void
    {
        $role_user = Role::create(['name' => Roles::USER->value, 'guard_name' => 'api']);
        $permission = Permission::create(['name' => RolePermissions::API_USER->value, 'guard_name' => 'api']);
        $role_user->givePermissionTo($permission);

        $role_user = Role::create(['name' => Roles::ADMIN->value, 'guard_name' => 'api']);
        $permission = Permission::create(['name' => RolePermissions::API->value, 'guard_name' => 'api']);
        $role_user->givePermissionTo($permission);
    }
}
