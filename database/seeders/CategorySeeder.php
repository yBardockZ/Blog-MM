<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::factory()->create([
            'name' => 'Tecnologia'
        ]);

        Category::factory()->create([
            'name' => 'Inovação'
        ]);

        Category::factory()->count(8)->create();
    }
}
