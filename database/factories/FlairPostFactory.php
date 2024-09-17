<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Post;
use App\Models\Flair;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FlairPost>
 */
class FlairPostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'post_id' => Post::inRandomOrder()->first()->id,
            'flair_id' => Flair::inRandomOrder()->first()->id,
        ];
    }
}
