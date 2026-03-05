<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class UserPostController extends Controller
{
    // عرض مقالات اليوزر الحالي في لوحة التحكم
    public function index()
    {
        $posts = auth()->user()->posts()->latest()->paginate(10);
        return view('dashboard', compact('posts'));
    }

    // عرض فورم إضافة مقال
    public function create()
    {
        return view('posts.create');
    }

    // حفظ المقال والمرفقات في الداتابيز
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'attachments.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf,mp4|max:10240', // أقصى حجم 10 ميجا
        ]);

        // 1. حفظ المقال
        $post = auth()->user()->posts()->create([
            'title' => $request->title,
            'slug' => Str::slug($request->title) . '-' . uniqid(), // توليد رابط فريد
            'content' => $request->content,
        ]);

        // 2. معالجة وحفظ المرفقات (إن وجدت)
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                // حفظ الملف في مجلد public/attachments
                $path = $file->store('attachments', 'public');

                // حفظ البيانات في قاعدة البيانات
                $post->attachments()->create([
                    'file_path' => $path,
                    'file_name' => $file->getClientOriginalName(),
                    'file_type' => $file->getClientOriginalExtension(),
                ]);
            }
        }

        return redirect()->route('dashboard')->with('success', 'تم نشر المقال بنجاح!');
    }
}
