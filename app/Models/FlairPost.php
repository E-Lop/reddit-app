<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FlairPost extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    protected $table = 'flair_post';

    public function flair()
    {
        return $this->hasOne(Flair::class, 'id', 'flair_id');
    }

    public function post()
    {
        return $this->hasOne(Post::class, 'id', 'post_id');
    }
}
