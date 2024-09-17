<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Subreddit;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Flair>
 */
class FlairFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->word(),
            'subreddit_id' => Subreddit::inRandomOrder()->first()->id,
        ];
    }
}
