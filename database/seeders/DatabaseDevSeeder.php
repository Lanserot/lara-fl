<?php

namespace Database\Seeders;

use App\Enums\RolePermissions;
use App\Enums\Roles;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseDevSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User\User::factory(9)->create();

        $user = \App\Models\User\User::factory()->create([
            'login' => 'login',
            'email' => 'test@example.com',
            'role_id' => \Spatie\Permission\Models\Role::findByName(Roles::ADMIN->value),
            'password' => Hash::make('password'),
        ]);

        $permission = \Spatie\Permission\Models\Permission::findByName(RolePermissions::API->value);
        $user->givePermissionTo($permission);
        $user->save();
    }
}
