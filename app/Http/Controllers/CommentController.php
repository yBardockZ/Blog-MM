<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;

class CommentController extends Controller
{

    public function store(Request $request) {
        $comment = new Comment();

        $comment->post_id=$request->post_id;
        $comment->author_id= 1;
        $comment->content=$request->content;

        $comment->save();

        return redirect()->route('posts.show', $comment->post_id)->with('msg', 'Comentário adicionado!');
    }

    public function destroy($id) {
        $comment = Comment::findOrFail($id);
        $comment->delete();

        return redirect('/posts/'.$comment->post_id)->with('msg', 'Comentário removido!');
    }

    public function update(Request $request, $id) {
        $comment = Comment::findOrFail($id);

        $comment->content = $request->content;
        $comment->save();

        return redirect()->route('posts.show', $comment->post_id)->with('msg', 'Comentário atualizado!');

    }
    //
}
