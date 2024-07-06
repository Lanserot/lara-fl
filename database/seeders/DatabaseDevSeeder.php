<?php

namespace Database\Seeders;

use App\Models\User\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Infrastructure\Enums\RolePermissionsEnum;
use Infrastructure\Enums\RolesEnum;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseDevSeeder extends Seeder
{
    public function run(): void
    {
        User::factory(9)->create();

        $user = User::factory()->create([
            'login' => 'login',
            'email' => 'test@example.com',
            'role_id' => Role::findByName(RolesEnum::ADMIN->value, 'api'),
            'password' => Hash::make('password'),
        ]);

        $permission = Permission::findByName(RolePermissionsEnum::API->value, 'api');
        $user->givePermissionTo($permission);
        $user->assignRole(RolesEnum::ADMIN->value);
        $user->save();

        $this->call([
            OrderSeeder::class,
        ]);
    }

}
