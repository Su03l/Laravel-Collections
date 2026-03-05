<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Carbon\Carbon;

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

    // عرض صفحة التعديل (بشرط ما يكون مر ساعتين)
    public function edit(Post $post)
    {
        // حماية: هل اليوزر هو صاحب المقال؟
        abort_if($post->user_id !== auth()->id(), 403, 'غير مصرح لك بتعديل هذا المقال.');

        // التحقق من شرط الساعتين
        if ($post->created_at->diffInHours(now()) >= 2) {
            return redirect()->route('dashboard')->with('error', 'عذراً، لا يمكن تعديل المقال بعد مرور ساعتين على نشره.');
        }

        return view('posts.edit', compact('post'));
    }

    // حفظ التعديلات
    public function update(Request $request, Post $post)
    {
        abort_if($post->user_id !== auth()->id(), 403);

        if ($post->created_at->diffInHours(now()) >= 2) {
            return redirect()->route('dashboard')->with('error', 'عذراً، انتهى وقت التعديل المسموح.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $post->update([
            'title' => $request->title,
            'content' => $request->content,
        ]);

        return redirect()->route('dashboard')->with('success', 'تم تعديل المقال بنجاح!');
    }

    // حذف المقال
    public function destroy(Post $post)
    {
        abort_if($post->user_id !== auth()->id(), 403);

        // سيتم حذف المرفقات والتعليقات تلقائياً بسبب (cascadeOnDelete) في قاعدة البيانات
        $post->delete();

        return redirect()->route('dashboard')->with('success', 'تم حذف المقال بشكل نهائي.');
    }
}
