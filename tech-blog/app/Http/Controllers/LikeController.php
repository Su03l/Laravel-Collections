<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    // تفاعل اللايك مع المقال
    public function togglePost(Post $post)
    {
        // نبحث: هل اليوزر مسجل لايك مسبقاً على هذا المقال؟
        $like = $post->likes()->where('user_id', auth()->id())->first();

        if ($like) {
            $like->delete(); // إذا موجود، احذفه (إزالة اللايك)
        } else {
            $post->likes()->create(['user_id' => auth()->id()]); // إذا مو موجود، ضفه
        }

        return back(); // نرجعه لنفس الصفحة بدون ريفريش مزعج
    }

    // تفاعل اللايك مع التعليق
    public function toggleComment(Comment $comment)
    {
        $like = $comment->likes()->where('user_id', auth()->id())->first();

        if ($like) {
            $like->delete();
        } else {
            $comment->likes()->create(['user_id' => auth()->id()]);
        }

        return back();
    }
}
