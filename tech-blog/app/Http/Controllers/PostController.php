<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        // سحب المقالات مع الكاتب والهاشتاقات (ترتيب من الأحدث للأقدم) مع 10 مقالات في كل صفحة
        $posts = Post::with(['user', 'tags'])->latest()->paginate(10);

        return view('posts.index', compact('posts'));
    }
}
