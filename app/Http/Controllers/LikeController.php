<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Like;

class LikeController extends Controller
{

    public function toggle(Request $request) {

        $user = Auth::user();
        $likeableType = $request->likeable_type;
        $likeableId = $request->likeable_id;

        $model = match($likeableType) {
            'post' => Post::class,
            'comment' => Comment::class,
        };

        $likeable = $model::findOrFail($likeableId);

        $existingLike = $likeable->likes()->where('user_id', $user->id)->first();

        $status = '';

        if ($existingLike) {
            $existingLike->delete();
            $status = 'unliked';
        } else {
            $likeable->likes()->create([
                'user_id' => $user->id,
            ]);
            $status = 'liked';
        }

        return response()->json([
            'status' => $status,
            'likes_count' => $likeable->likes()->count(),
        ]);

    }
}
