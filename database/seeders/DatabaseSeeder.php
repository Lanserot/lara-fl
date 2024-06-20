<?php

namespace Database\Seeders;

use App\Enums\RolePermissions;
use App\Enums\Roles;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            CategorySeeder::class,
            RolesSeeder::class,
        ]);

        if(env('APP_ENV') == 'local'){
            $this->call([
                DatabaseDevSeeder::class,
            ]);
        }
    }
}
