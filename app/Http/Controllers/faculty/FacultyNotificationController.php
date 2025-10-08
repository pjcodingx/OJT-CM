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

        // ✅ Base query — faculty-specific notifications
        $baseQuery = Notification::where('user_id', $faculty->id)
            ->where('user_type', 'faculty');

        // ✅ Apply filters from Blade form
        if (request()->filled('type')) {
            $baseQuery->where('type', request('type'));
        }

        if (request()->filled('date')) {
            $baseQuery->whereDate('created_at', request('date'));
        }


        $limit = 10;

        $unreadCount = (clone $baseQuery)->where('is_read', false)->count();
        $totalCount  = (clone $baseQuery)->count();
        $todayCount  = (clone $baseQuery)->whereDate('created_at', today())->count();


        $notifications = $baseQuery
            ->orderBy('created_at', 'desc')
            ->paginate($limit)
            ->withQueryString();


        Notification::whereIn('id', $notifications->pluck('id'))
            ->where('is_read', false)
            ->update(['is_read' => true]);

        $maxNotifications = 20;
        $isAlmostFull = $totalCount >= ($maxNotifications * 0.9);
        $isFull = $totalCount >= $maxNotifications;

        return view('faculty.notifications.index', compact(
            'notifications',
            'faculty',
            'unreadCount',
            'totalCount',
            'todayCount',
            'maxNotifications',
            'isAlmostFull',
            'isFull'
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
