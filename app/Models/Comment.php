<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{

    use HasFactory;

    //    @var array<int, string>
    //    atributos que podem ser alterados pelo cliente abaixo

    protected $fillable = [
        'content',
        'post_id',
        'author_id'
    ];

    public function post() {
        return $this->belongsTo(Post::class);
    }

    public function author() {
        return $this->belongsTo(User::class);
    }

    public function likes() {
        return $this->morphMany(Like::class, 'likeable');
    }

    public function isLikedBy(User $user) {
        return $this->likes()->where('user_id', $user->id)->exists();
    }
}
