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

        // Base query (faculty-specific notifications)
        $baseQuery = Notification::where('user_id', $faculty->id)
            ->where('user_type', 'faculty');

        // Stats
        $unreadCount = (clone $baseQuery)->where('is_read', false)->count();
        $totalCount  = (clone $baseQuery)->count();
        $todayCount  = (clone $baseQuery)->whereDate('created_at', today())->count();

        // Paginated notifications (for list display)
        $notifications = $baseQuery->orderBy('created_at', 'desc')->paginate(5);

        // Mark as read after loading
        (clone $baseQuery)->where('is_read', false)->update(['is_read' => true]);

        return view('faculty.notifications.index', compact(
            'notifications',
            'faculty',
            'unreadCount',
            'totalCount',
            'todayCount'
        ));
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
