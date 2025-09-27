<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model

{

    use HasFactory;

    //    @var array<int, string> -> usado para definir a tipagem do array abaixo 
    //(IDE detecta caso um valor errado for inserido)
    //    atributos que podem ser alterados abaixo

    protected $fillable = [
    'title',
    'content',
    'published',
    'author_id',
    'category_id'
    ]   ;

    public function author() {
        return $this->belongsTo(User::class);
    }

    public function comments() {
        return $this->hasMany(Comment::class);
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function tag() {
        return $this->hasMany(Tag::class, 'post_tag', 'post_id', 'tag_id');
    }




}
