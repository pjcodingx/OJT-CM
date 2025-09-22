<?php

namespace App\Http\Controllers\admin;

use App\Models\Notification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AdminNotificationController extends Controller
{
    public function index(){
    $admin = Auth::guard('admin')->user();

    $notifications = Notification::where('user_id', $admin->id)
    ->where('user_type', 'admin')
    ->orderBy('created_at', 'desc')
    ->paginate(10);

    Notification::Where('user_id', $admin->id)
    ->where('user_type', 'admin')
    ->where('is_read', false)
    ->update(['is_read' => 1]);

    return view('admin.notifications.index', compact('notifications', 'admin'));


    }

    public function markAsRead($id)
    {
        $notif = Notification::where('id', $id)
            ->where('user_id', auth('admin')->id())
            ->where('user_type', 'admin')
            ->first();

        if (! $notif) {
            return response()->json(['status' => 'not_found'], 404);
        }

        $notif->update(['is_read' => true]);

        return response()->json(['status' => 'success']);
    }




    public function deleteAll()
    {
        Notification::where('user_id', auth('admin')->id())
            ->where('user_type', 'admin')
            ->delete();

        return redirect()->back()->with('success', 'Successfully deleted!');
    }


}
