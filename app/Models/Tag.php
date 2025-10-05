<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tag extends Model
{

    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function post() {
        return $this->belongsToMany(Post::class, 'post_tag', 'tag_id', 'post_id');
    }

}
