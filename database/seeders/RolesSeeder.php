<?php

namespace Database\Seeders;

use App\Enums\RolePermissionsEnum;
use App\Enums\RolesEnum;
use Illuminate\Database\Seeder;
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
    }
}
