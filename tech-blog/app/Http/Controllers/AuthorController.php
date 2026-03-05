<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function show($username)
    {
        // جلب بيانات الكاتب
        $author = User::where('username', $username)->firstOrFail();

        // جلب مقالات الكاتب مع الـ Pagination
        $posts = $author->posts()->with('tags')->latest()->paginate(10);

        return view('author.show', compact('author', 'posts'));
    }
}
