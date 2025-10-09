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
        $comment = Comment::findOrFail($id);

        if (Auth::user()->id != $comment->author_id && Auth::user()->id != $comment->post->author_id) {
            abort(403, 'Você não tem permissão para deletar este comentário.');
        }

        $comment->delete();

        return redirect()->route('posts.show', $comment->post_id)->with('msg', 'Comentário removido!');
    }

    public function update(Request $request, $id) {
        $comment = Comment::findOrFail($id);

        if (Auth::user()->id != $comment->author_id && Auth::user()->id != $comment->post->author_id) {
            abort(403, 'Você não tem permissão para deletar este comentário.');
        }

        $comment->content = $request->content;
        $comment->save();

        return redirect()->route('posts.show', $comment->post_id)->with('msg', 'Comentário atualizado!');

    }
    //
}
