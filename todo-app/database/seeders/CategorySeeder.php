<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Work', 'color' => '#ef4444'], // Red
            ['name' => 'Personal', 'color' => '#3b82f6'], // Blue
            ['name' => 'Study', 'color' => '#10b981'], // Emerald
            ['name' => 'Fitness', 'color' => '#f59e0b'], // Amber
            ['name' => 'Shopping', 'color' => '#8b5cf6'], // Violet
            ['name' => 'Health', 'color' => '#ec4899'], // Pink
            ['name' => 'Travel', 'color' => '#14b8a6'], // Teal
            ['name' => 'Home', 'color' => '#6b7280'], // Gray
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
