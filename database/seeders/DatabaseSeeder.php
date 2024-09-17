<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Subreddit;
use App\Models\Flair;
use App\Models\Post;
use App\Models\Comment;
use App\Models\FlairPost;
use App\Models\SubredditUser;
use App\Models\Like;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();
        Subreddit::factory(30)->create();
        SubredditUser::factory(50)->create();
        Flair::factory(50)->create();
        Post::factory(100)->create();
        Comment::factory(25)->create();
        Comment::factory(25)->create();
        Comment::factory(25)->create();
        Comment::factory(25)->create();
        Like::factory(100)->create();
        FlairPost::factory(100)->create();

        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
