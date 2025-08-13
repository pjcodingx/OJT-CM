<?php

namespace App\Http\Controllers\student;

use App\Models\Notification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class StudentNotificationController extends Controller
{
    //

     public function index()
    {
        $student = Auth::guard('student')->user();

    $notifications = Notification::where('user_id', $student->id)
        ->where('user_type', 'student')
        ->orderBy('created_at', 'desc')
        ->paginate(5);


    Notification::where('user_id', $student->id)
        ->where('user_type', 'student')
        ->where('is_read', false)
        ->update(['is_read' => true]);

    return view('student.notifications.index', compact('notifications', 'student'));
    }

    public function markAllAsRead()
{
        Notification::where('user_id', Auth::id())
            ->where('user_type', 'student')
            ->update(['is_read' => true]);

        return response()->json(['status' => 'success']);
}



public function deleteAll()
{
    Notification::where('user_id', auth('student')->id())
        ->where('user_type', 'student')
        ->delete();

    return redirect()->back()->with('success', 'Sucessfully deleted!');
}

}
