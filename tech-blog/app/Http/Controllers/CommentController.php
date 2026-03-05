<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Post $post)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
            'parent_id' => 'nullable|exists:comments,id', // حقل اختياري للردود
        ]);

        $post->comments()->create([
            'user_id' => auth()->id(), // اليوزر المسجل دخوله حالياً
            'parent_id' => $request->parent_id, // إذا كان رد، بينحفظ رقم التعليق الأب
            'content' => $request->content,
        ]);

        return back()->with('success', 'تم إضافة التعليق بنجاح!');
    }
}
