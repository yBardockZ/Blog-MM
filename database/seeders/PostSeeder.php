<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Post;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Post::factory()->create([
            'title' => 'Primeiro Post',
            'content' => 'Conteúdo do Primeiro Post',
            'published' => true,
            'image' => 'post1.png',
            'author_id' => 1,
            'category_id' => 1
        ]);

        Post::factory()->create([
            'title' => 'Segundo Post',
            'content' => 'Conteúdo do Segundo Post',
            'published' => true,
            'image' => 'post2.png',
            'author_id' => 1,
            'category_id' => 2
        ]);

        Post::factory()->count(18)->create();
    }
}
