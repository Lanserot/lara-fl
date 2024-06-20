<?php

namespace Database\Seeders;

use App\Models\Category\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    private array $categories = [
        'programming' => 'Программирование',
        '3d' => '3д',
        'websites' => 'Сайты',
        'games' => 'Игры',
        'design' => 'Дизайн',
        'texts' => 'Тексты',
    ];

    public function run(): void
    {
        foreach ($this->categories as $name => $name_rus) {
            Category::create([
                'name' => $name,
                'name_rus' => $name_rus,
            ]);
        }
    }
}
