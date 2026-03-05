<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class BookmarkController extends Controller
{
    // أضف هذه الدالة داخل الكلاس
    public function index()
    {
        // نجيب المحفوظات الخاصة باليوزر الحالي مع المقالات وأصحاب المقالات
        $bookmarks = auth()->user()->bookmarks()->with('post.user')->latest()->paginate(10);

        return view('bookmarks.index', compact('bookmarks'));
    }

    public function toggle(Post $post)
    {
        // نبحث: هل اليوزر مسجل حفظ مسبقاً على هذا المقال؟
        // نستخدم العلاقة bookmarks() المعرفة في موديل Post
        $bookmark = $post->bookmarks()->where('user_id', auth()->id())->first();

        if ($bookmark) {
            $bookmark->delete();
            $message = 'تم إزالة المقال من المحفوظات.';
        } else {
            $post->bookmarks()->create(['user_id' => auth()->id()]);
            $message = 'تم حفظ المقال بنجاح!';
        }

        return back()->with('success', $message);
    }
}
