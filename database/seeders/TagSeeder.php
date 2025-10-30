<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = [
            'Java',
            'PHP',
            'Laravel',
            'Spring',
            'MySQL',
            'JavaScript',
            'Vue.js',
            'Bootstrap',
            'Alpine.js',
            'Git',
        ];

        foreach ($tags as $tag) {
            Tag::firstOrCreate(['name' => $tag]);
        }
    }
}