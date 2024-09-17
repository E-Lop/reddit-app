<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subreddit extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    protected $table = 'subreddits';

    public function flairs()
    {
        return $this->hasMany(Flair::class, 'subreddit_id', 'id');
    }

    public function ordered_posts()
    {
        return $this->hasMany(Post::class, 'subreddit_id', 'id')->orderBy('title', 'asc');
    }

    public function posts()
    {
        return $this->hasMany(Post::class, 'subreddit_id', 'id');
    }

    public function subreddit_user()
    {
        return $this->hasMany(SubredditUser::class, 'subreddit_id', 'id');
    }
}
