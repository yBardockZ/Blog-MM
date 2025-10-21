<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Tag;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\PostRequest;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

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

        }

        $posts = $query->orderByDesc('created_at')->paginate(10)->withQueryString();

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

    public function store(PostRequest $request) {
        $validated = $request->validated();


        $post = new Post($validated);

        $post->title = $request->title;
        $post->content = $request->content;
        $post->published = true;
        $post->category_id = $request->category_id;

        $user = Auth::user();
        $post->author_id = $user->id;

        if ($request->hasFile('image')) {
            $requestImage = $request->image;
            $imageName = $this->imageNameGeneration($requestImage);

            $this->imageSave($imageName, $requestImage);

            $post->image = $imageName;
        }

        $post->save();

        if (!empty($validated['tags'])) {
            $post->tags()->attach($validated['tags']);
        }
        
        return redirect()->route('dashboard')->with('msg', 'Post criado com sucesso!');
    }

    public function dashboard(Request $request) {
        $user = Auth::user();
        $query = Post::where('author_id', $user->id);

        $search = null;

        if ($request->filled('search')) {
            $search = $request->search;

            $query = Post::where('title', 'like', "%{$search}%")->where('author_id', $user->id);
        }

        $posts = $query->latest()->paginate(10)->withQueryString();

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

    public function update(PostRequest $request, $id) {
        $validated= $request->validated();

        $post = Post::where('id', $id)
            ->where('author_id', Auth::user()->id)
            ->firstOrFail();

        $post->title = $request->title;
        $post->content = $request->content;
        $post->published = true;
        $post->category_id = $request->category_id;

        if ($request->hasFile('image')) {
            $requestImage = $request->image;
            $imageName = $this->imageNameGeneration($requestImage);
            
            if (Storage::disk('public')->exists('images/posts/' . $post->image)) {
                Storage::disk('public')->delete('images/posts/' . $post->image);
                Storage::disk('public')->delete('images/posts/thumbnails/' . $post->image);
            }

            $this->imageSave($imageName, $requestImage);

            $post->image = $imageName;
        }

        $post->update($validated);

        $post->tags()->sync($request->tags);

        return redirect()->route('dashboard')->with('msg', 'Post atualizado com sucesso!');
    }

    public function destroy($id) {
        $post = Post::where('id', $id)
            ->where('author_id', Auth::user()->id)
            ->firstOrFail();

        if ($post->image && Storage::disk('public')->exists('images/posts/' . $post->image)) {

            if (Storage::disk('public')->exists('images/posts/thumbnails/' . $post->image)) {
                Storage::disk('public')->delete('images/posts/thumbnails/' . $post->image);
            }

            Storage::disk('public')->delete('images/posts/' . $post->image);
        }

        $post->delete();

        return redirect()->route('dashboard')->with('msg', 'Post removido com sucesso!');
    }

    private function imageNameGeneration($image) {
        $imageExtension = $image->extension();
            
        $imageName = md5($image->getClientOriginalName() . time()) . $imageExtension;

        return $imageName;
    }

    private function imageSave($imageName, $requestImage) {
        $destinationPath = public_path('images/posts');
        $thumbnailPath = public_path('images/posts/thumbnails');

        
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            if (!file_exists($destinationPath . '/thumbnails')) {
                mkdir($destinationPath . '/thumbnails', 0755, true);
            }

            $manager = new ImageManager(new Driver());

            // Imagem principal
            $image = $manager->read($requestImage);
            $image->scale(width: 1200)
                ->save($destinationPath . '/' . $imageName, quality: 90);

            // Thumbnail
            $thumbnail = $manager->read($requestImage);
            $thumbnail->cover(800, 500)
                    ->save($thumbnailPath . '/' . $imageName, quality: 85);
    }

}
