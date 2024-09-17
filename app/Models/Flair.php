<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Flair extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    protected $table = 'flairs';

    public function subreddit()
    {
        return $this->hasOne(Subreddit::class, 'id', 'subreddit_id');
    }

    public function flair_post()
    {
        return $this->hasMany(Post::class, 'flair_id', 'id');
    }
}
