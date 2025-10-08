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


        $baseQuery = Notification::where('user_id', $company->id)
            ->where('user_type', 'company');

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

        $maxNotifications = 3;
        $isAlmostFull = $totalCount >= ($maxNotifications * 0.9);
        $isFull = $totalCount >= $maxNotifications;

        (clone $baseQuery)->where('is_read', false)->update(['is_read' => true]);

        return view('company.notifications.index', compact(
            'notifications',
            'company',
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
