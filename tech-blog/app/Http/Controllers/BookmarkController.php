<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class BookmarkController extends Controller
{
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
