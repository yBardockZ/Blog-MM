<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Tag;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

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


    public function create() {
        $tags = Tag::all();
        $categories = Category::all();

        

        return view('posts.create', ['tags' => $tags, 'categories' => $categories]);

    }

    public function store(Request $request) {
        $post = new Post();

        $post->title = $request->title;
        $post->content = $request->content;
        $post->published = true;
        $post->category_id = $request->category_id;

        $user = Auth::user();
        $post->author_id = $user->id;

        if ($request->hasFile('image')) {
            $requestImage = $request->image;

            $requestExtension = $requestImage->extension();

            $imageName = md5($requestImage->getClientOriginalName() . time()) . $requestExtension;

            $requestImage->move(public_path('images/posts'), $imageName);

            $post->image = $imageName;
        }

        $post->save();

        if ($request->tags) {
            $post->tags()->attach($request->tags);
        }
        
        return redirect()->route('posts.index')->with('msg', 'Post criado com sucesso!');
    }

    public function dashboard(Request $request) {


    }

}
