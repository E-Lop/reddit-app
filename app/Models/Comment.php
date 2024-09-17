<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    protected $table = 'comments';

    public static function booted(): void
    {
        static::addGlobalScope('likes', function (Builder $builder) {
            $builder->withCount('likes')->with('likes');
        });
    }

    /*public static function scopeAllLikes(Builder $builder): void
    {
        $builder->withCount('likes')->with('likes');
    }*/

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function post()
    {
        return $this->hasOne(Post::class, 'id', 'post_id');
    }

    public function parent()
    {
        return $this->hasOne(Comment::class, 'id', 'parent_id');
    }

    public function child()
    {
        return $this->hasMany(Comment::class, 'parent_id', 'id')->with('child');
    }

    public function child_by_likes()
    {
        return $this->hasMany(Comment::class, 'parent_id', 'id')->with('child')->orderBy('likes_count', 'desc');
    }

    public function child_by_date()
    {
        return $this->hasMany(Comment::class, 'parent_id', 'id')->with('child')->orderBy('created_at', 'desc');
    }

    public function likes()
    {
        return $this->morphMany(Like::class, 'likeable');
    }
}
