<?php

namespace Database\Seeders;

use App\Models\Category\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        foreach (\Infrastructure\Enums\CategoryEnum::cases() as $case) {
            Category::create([
                'name' => $case->value,
                'name_rus' => $case->getNameRus(),
            ]);
        }
    }
}
