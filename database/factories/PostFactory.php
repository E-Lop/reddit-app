<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Subreddit;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::inRandomOrder()->first()->id,
            'title' => fake()->sentence(),
            'body' => fake()->paragraph(10),
            'image' => fake()->imageUrl(),
            'link' => fake()->url(),
            'created_at' => fake()->date('Y-m-d H:i:s', 'now'),
            'subreddit_id' => Subreddit::inRandomOrder()->first()->id,
        ];
    }
}
