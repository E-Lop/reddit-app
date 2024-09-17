<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Post;
use App\Models\Comment;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Like>
 */
class LikeFactory extends Factory
{


    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $rnd = rand(0, 1);
        if ($rnd == 0) {
            $likeable_id = Post::inRandomOrder()->first()->id;
            $likeable_type = 'App\Models\Post';
        } else {
            $likeable_id = Comment::inRandomOrder()->first()->id;
            $likeable_type = 'App\Models\Comment';
        }
        $rnd2 = rand(0, 4);
        if ($rnd2 < 4) {
            $is_upvoted = true;
        } else {
            $is_upvoted = false;
        }

        return [
            'user_id' => User::inRandomOrder()->first()->id,
            'likeable_id' => $likeable_id,
            'likeable_type' => $likeable_type,
            'is_upvoted' => $is_upvoted,
        ];
    }
}
