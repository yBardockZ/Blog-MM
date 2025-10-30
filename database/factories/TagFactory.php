<?php

namespace Database\Factories;

use App\Models\Tag;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tag>
 */
class TagFactory extends Factory
{
    protected $model = Tag::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $tags = ['Java', 'PHP', 'Python', 'JavaScript', 'Laravel', 'React', 'Vue', 'Angular', 'Node.js', 'MySQL'];
        
        return [
            'name' => $tags[array_rand($tags)] . ' ' . rand(1, 100),
        ];
    }
}