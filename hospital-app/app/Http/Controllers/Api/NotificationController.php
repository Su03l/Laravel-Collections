<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    use HttpResponses;

    public function index()
    {
        $notifications = auth()->user()->notifications()->paginate(10);
        return $this->success($notifications);
    }

    public function unread()
    {
        $notifications = auth()->user()->unreadNotifications;
        return $this->success($notifications);
    }

    public function markAsRead($id)
    {
        $notification = auth()->user()->notifications()->findOrFail($id);
        $notification->markAsRead();

        return $this->success(null, 'Notification marked as read');
    }

    public function markAllAsRead()
    {
        auth()->user()->unreadNotifications->markAsRead();
        return $this->success(null, 'All notifications marked as read');
    }
}
