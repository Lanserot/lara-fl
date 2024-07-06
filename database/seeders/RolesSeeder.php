<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Infrastructure\Enums\RolePermissionsEnum;
use Infrastructure\Enums\RolesEnum;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    public function run(): void
    {
        $role_user = Role::create(['name' => RolesEnum::USER->value, 'guard_name' => 'api']);
        $permission = Permission::create(['name' => RolePermissionsEnum::API_USER->value, 'guard_name' => 'api']);
        $role_user->givePermissionTo($permission);

        $role_user = Role::create(['name' => RolesEnum::ADMIN->value, 'guard_name' => 'api']);
        $permission = Permission::create(['name' => RolePermissionsEnum::API->value, 'guard_name' => 'api']);
        $role_user->givePermissionTo($permission);

        Role::create(['name' => RolesEnum::ADMIN->value]);
    }
}
