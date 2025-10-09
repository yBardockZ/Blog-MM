<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{

    public function store(Request $request) {
        $comment = new Comment();

        $comment->post_id=$request->post_id;
        $comment->author_id= Auth::user()->id;
        $comment->content=$request->content;

        $comment->save();

        return redirect()->route('posts.show', $comment->post_id)->with('msg', 'Comentário adicionado!');
    }

    public function destroy($id) {
        $comment = Comment::where('id', $id)
            ->where('author_id', Auth::user()->id)
            ->firstOrFail();

        $comment->delete();

        return redirect('/posts/'.$comment->post_id)->with('msg', 'Comentário removido!');
    }

    public function update(Request $request, $id) {
        $comment = Comment::where('id', $id)
            ->where('author_id', Auth::user()->id)
            ->firstOrFail();

        $comment->content = $request->content;
        $comment->save();

        return redirect()->route('posts.show', $comment->post_id)->with('msg', 'Comentário atualizado!');

    }
    //
}
