<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Subreddit;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SubredditUser>
 */
class SubredditUserFactory extends Factory
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
            'subreddit_id' => Subreddit::inRandomOrder()->first()->id,
            'is_owner' => rand(0, 99) == 99 ? true : false,
        ];
    }
}
