<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{

    public function index(Request $request) {

        $query = Post::query();
        $search = null;

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                ->orWhere('content', 'like', "%{$search}%");
            });

            $posts = $query->paginate(10);
        } else {
            $posts = $query->paginate(10);
        }

        return view('welcome', ['posts' => $posts, 'search' => $search]);
    }
    
    public function show($id) {
        $post = Post::findOrFail($id);

        return view('posts.show', ['post' => $post]);
    }
    //
}
