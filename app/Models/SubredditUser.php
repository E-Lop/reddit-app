<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubredditUser extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    protected $table = 'subreddit_user';

    public function subreddit()
    {
        return $this->hasOne(Subreddit::class, 'id', 'subreddit_id');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'id', 'user_id');
    }
}
