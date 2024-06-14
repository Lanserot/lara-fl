<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'login' => 'login',
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
        ]);

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

    }
}
