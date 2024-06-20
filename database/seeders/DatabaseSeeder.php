<?php

namespace Database\Seeders;

use App\Enums\RolePermissions;
use App\Enums\Roles;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        \Spatie\Permission\Models\Role::create(['name' => Roles::USER->value]);
        \Spatie\Permission\Models\Role::create(['name' => Roles::ADMIN->value]);
        \Spatie\Permission\Models\Permission::create(['name' => RolePermissions::API->value, 'guard_name' => 'web']);

        $categories = [
            'programing' => 'Программирование',
            '3d' => '3д',
        ];

        foreach ($categories as $name => $name_rus) {
            \App\Models\Category\Category::create([
                'name' => $name,
                'name_rus' => $name_rus,
            ]);
        }

        if(env('APP_ENV') == 'local'){
            $this->call([
                DatabaseDevSeeder::class,
            ]);
        }
    }
}
