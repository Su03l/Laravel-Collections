<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Post;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // 1. عرض لوحة الإدارة (إحصائيات + قائمة المستخدمين)
    public function index()
    {
        $stats = [
            'users_count' => User::count(),
            'posts_count' => Post::count(),
        ];

        // نجيب كل اليوزرات (ما عدا الأدمن الحالي عشان ما يحظر نفسه بالغلط)
        $users = User::where('id', '!=', auth()->id())->latest()->paginate(20);

        return view('admin.dashboard', compact('stats', 'users'));
    }

    // 2. تفعيل / حظر مستخدم
    public function toggleUserStatus(User $user)
    {
        // نعكس حالة المستخدم (إذا true تصير false والعكس)
        $user->update(['is_active' => !$user->is_active]);

        $status = $user->is_active ? 'نشط' : 'محظور';
        return back()->with('success', "تم تغيير حالة المستخدم ({$user->username}) إلى: {$status}");
    }

    // 3. حذف أي مقال مخالف
    public function destroyPost(Post $post)
    {
        $post->delete();
        return back()->with('success', 'تم حذف المقال بواسطة الإدارة.');
    }
}
