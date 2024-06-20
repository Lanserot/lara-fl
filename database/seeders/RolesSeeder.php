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
        Role::create(['name' => Roles::USER->value]);
        Role::create(['name' => Roles::ADMIN->value]);
        Permission::create(['name' => RolePermissions::API->value, 'guard_name' => 'web']);
    }
}
