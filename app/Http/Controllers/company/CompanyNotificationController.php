<?php

namespace App\Http\Controllers\company;

use App\Models\Notification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CompanyNotificationController extends Controller
{
    //

      public function index()
    {
        $company = Auth::guard('company')->user();

        // Base query for this company
        $baseQuery = Notification::where('user_id', $company->id)
            ->where('user_type', 'company');

        // Stats
        $unreadCount = (clone $baseQuery)->where('is_read', false)->count();
        $totalCount  = (clone $baseQuery)->count();
        $todayCount  = (clone $baseQuery)->whereDate('created_at', today())->count();

        // Paginated list for displaying notifications
        $notifications = $baseQuery->orderBy('created_at', 'desc')->paginate(5);

        // Mark all unread as read
        (clone $baseQuery)->where('is_read', false)->update(['is_read' => true]);

        return view('company.notifications.index', compact(
            'notifications',
            'company',
            'unreadCount',
            'totalCount',
            'todayCount'
        ));
    }


    public function markAllAsRead()
{
        Notification::where('user_id', Auth::id())
            ->where('user_type', 'company')
            ->update(['is_read' => true]);

        return response()->json(['status' => 'success']);
}



public function deleteAll()
{
    Notification::where('user_id', auth('company')->id())
        ->where('user_type', 'company')
        ->delete();

    return redirect()->back()->with('success', 'Sucessfully deleted!');
}
}
