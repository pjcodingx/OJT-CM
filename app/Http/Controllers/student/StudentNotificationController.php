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


        $baseQuery = Notification::where('user_id', $student->id)
            ->where('user_type', 'student');

        if(request()->filled('type')){
            $baseQuery->where('type', request('type'));
        }

        if(request()->filled('date')){
            $baseQuery->whereDate('created_at', request('date'));
        }

        $limit = 10;


        $unreadCount = (clone $baseQuery)->where('is_read', false)->count();
        $totalCount  = (clone $baseQuery)->count();
        $todayCount  = (clone $baseQuery)->whereDate('created_at', today())->count();


        $notifications = $baseQuery->orderBy('created_at', 'desc')->paginate($limit)->withQueryString();

         Notification::whereIn('id', $notifications->pluck('id'))
        ->where('is_read', false)
        ->update(['is_read' => true]);

        $maxNotifications = 20;
        $isAlmostFull = $totalCount >= ($maxNotifications * 0.9);
        $isFull = $totalCount >= $maxNotifications;


        (clone $baseQuery)->where('is_read', false)->update(['is_read' => true]);

        return view('student.notifications.index', compact(
            'notifications',
            'student',
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
