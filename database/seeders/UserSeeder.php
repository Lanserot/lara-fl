<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = json_decode(file_get_contents(database_path('fixtures/user.fixture.json')), true);

        foreach ($users as $user) {
            User::create([
                'login' => $user['login'],
                'email' => $user['email'],
                'password' => Hash::make($user['password']),
            ]);
        }
    }
}
//php artisan db:seed --class=UserSeeder
