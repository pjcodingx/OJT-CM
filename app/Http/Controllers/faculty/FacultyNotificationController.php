<?php

namespace App\Http\Controllers\faculty;

use App\Models\Notification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class FacultyNotificationController extends Controller
{
    //

    public function index()
    {
         $faculty = Auth::guard('faculty')->user();


    $notifications = Notification::where('user_id', $faculty->id)
        ->where('user_type', 'faculty')
        ->orderBy('created_at', 'desc')
        ->paginate(5);


    Notification::where('user_id', $faculty->id)
        ->where('user_type', 'faculty')
        ->where('is_read', false)
        ->update(['is_read' => true]);

    return view('faculty.notifications.index', compact('notifications', 'faculty'));
    }

    public function markAllAsRead()
{
        Notification::where('user_id', Auth::guard('faculty')->id())
            ->where('user_type', 'faculty')
            ->update(['is_read' => true]);

        return response()->json(['status' => 'success']);
}



public function deleteAll()
{
    Notification::where('user_id', auth('faculty')->id())
        ->where('user_type', 'faculty')
        ->delete();

    return redirect()->back()->with('success', 'Sucessfully deleted!');
}


}
