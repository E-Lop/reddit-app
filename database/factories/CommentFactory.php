<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
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
            'parent_id' => rand(0, 1) == 1 ? null : (Comment::all()->count()!= 0 ? Comment::inRandomOrder()->first()->id :  null),
            'post_id' => Post::inRandomOrder()->first()->id,
            'body' => fake()->paragraph(5),
        ];
    }
}
