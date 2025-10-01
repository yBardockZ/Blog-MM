<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{

    public function index() {
        $post = Post::All();

        return view('welcome', ['posts' => $post]);
    }
    
    public function show($id) {
        $post = Post::findOrFail($id);

        return view('posts.show', ['post' => $post]);
    }
    //
}
