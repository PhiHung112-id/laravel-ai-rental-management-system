<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notification;
use Throwable;

class NotificationController extends Controller
{
    public function index()
    {
        if (!session()->has('login_id')) {
            return redirect('/admin/login');
        }

        $notifications = Notification::orderByDesc('is_pinned')
            ->orderByDesc('created_at')
            ->get();

        return view('admin.notifications.index', compact('notifications'));
    }

    public function manage($id = null)
    {
        if (!session()->has('login_id')) {
            return response('Chưa đăng nhập admin', 401);
        }

        $notification = null;

        if (!empty($id)) {
            $notification = Notification::find($id);
        }

        return view('admin.notifications.manage', compact('notification'));
    }

    public function save(Request $request)
    {
        try {
            if (!session()->has('login_id')) {
                return response('0');
            }

            $request->validate([
                'title' => 'required|string|max:255',
                'content' => 'required|string',
            ]);

            $notification = $request->id
                ? Notification::find($request->id)
                : new Notification();

            if (!$notification) {
                return response('0');
            }

            $notification->title = trim($request->title);
            $notification->content = trim($request->content);
            $notification->is_pinned = $request->has('is_pinned') ? 1 : 0;

            $notification->save();

            return response('1');

        } catch (Throwable $e) {
            return response('Lỗi save notification: ' . $e->getMessage(), 500);
        }
    }

    public function delete($id)
    {
        try {
            if (!session()->has('login_id')) {
                return response('0');
            }

            $notification = Notification::find($id);

            if (!$notification) {
                return response('0');
            }

            $notification->delete();

            return response('1');

        } catch (Throwable $e) {
            return response('Lỗi delete notification: ' . $e->getMessage(), 500);
        }
    }
}