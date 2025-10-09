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
            $imageName = $this->imageNameGeneration($requestImage);

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
        $user = Auth::user();
        $query = Post::where('author_id', $user->id);

        $search = null;

        if ($request->filled('search')) {
            $search = $request->search;

            $query = Post::where('title', 'like', "%{$search}%")->where('author_id', $user->id);
        }

        $posts = $query->latest()->paginate(10);

        return view('dashboard', ['posts' => $posts, 'search' => $search]);

    }

    public function edit($id) {
        $user = Auth::user();
        $post = Post::where('id', $id)
            ->where('author_id', $user->id)
            ->firstOrFail();

        $tags = Tag::all();
        $categories = Category::all();

        return view('posts.edit', ['post' => $post, 'tags' => $tags, 'categories' => $categories]);
    }

    public function update(Request $request, $id) {
        $post = Post::where('id', $id)
            ->where('author_id', Auth::user()->id)
            ->firstOrFail();

        $validatedData = $request->validate([
        'title' => 'required|max:255',
        'content' => 'required',
        'category_id' => 'required|exists:categories,id',
        'image' => 'nullable|image|max:2048', // Opcional: Nova imagem
        'tags' => 'array',
        'tags.*' => 'exists:tags,id',
        ]);

        $post->title = $request->title;
        $post->content = $request->content;
        $post->published = true;
        $post->category_id = $request->category_id;

        if ($request->hasFile('image')) {
            $requestImage = $request->image;
            $imageName = $this->imageNameGeneration($requestImage);

            $requestImage->move(public_path('images/posts'), $imageName);

            $post->image = $imageName;
        }

        $post->update($validatedData);

        $post->tags()->sync($request->tags);

        return redirect()->route('dashboard')->with('msg', 'Post atualizado com sucesso!');
    }

    private function imageNameGeneration($image) {
        $imageExtension = $image->extension();
            
        $imageName = md5($image->getClientOriginalName() . time()) . $imageExtension;

        return $imageName;
    }

}
