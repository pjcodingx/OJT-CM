<?php

namespace App\Http\Controllers\admin;

use App\Models\Company;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AdminNotificationController extends Controller
{
    public function index()
    {
        $admin = Auth::guard('admin')->user();

        // Base query (only this admin’s notifications)
        $baseQuery = Notification::where('user_id', $admin->id)
            ->where('user_type', 'admin');

        // Stats
        $unreadCount = (clone $baseQuery)->where('is_read', false)->count();
        $totalCount  = (clone $baseQuery)->count();
        $todayCount  = (clone $baseQuery)->whereDate('created_at', today())->count();

        // Paginated list
        $notifications = $baseQuery->orderBy('created_at', 'desc')->paginate(10);

        // Mark unread as read after fetching
        (clone $baseQuery)->where('is_read', false)->update(['is_read' => 1]);

        return view('admin.notifications.index', compact(
            'notifications',
            'admin',
            'unreadCount',
            'totalCount',
            'todayCount'
        ));
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

    //!para notif sa company time

    public function updateTime(Request $request, $companyId){

        $company = Company::findOrFail($companyId);

        if ($request->has(['allowed_time_in_start', 'allowed_time_in_end', 'allowed_time_out_start', 'allowed_time_out_end'])) {
        $company->update([
            'allowed_time_in_start'  => $request->allowed_time_in_start,
            'allowed_time_in_end'    => $request->allowed_time_in_end,
            'allowed_time_out_start' => $request->allowed_time_out_start,
            'allowed_time_out_end'   => $request->allowed_time_out_end,
        ]);
        }

         Notification::create([
            'user_id'   => 1,
            'user_type' => 'admin',
            'title'     => 'Default Attendance Time Updated',
            'message'   => $company->name . ' updated default time: '
                        . 'Time In (' . $request->allowed_time_in_start . '–' . $request->allowed_time_in_end . '), '
                        . 'Time Out (' . $request->allowed_time_out_start . '–' . $request->allowed_time_out_end . ')',
            'is_read'   => 0,
        ]);

          if ($request->has(['date', 'time_in_start', 'time_in_end', 'time_out_start', 'time_out_end'])) {
                $company->overrides()->updateOrCreate(
                    ['date' => $request->date],
                    [
                        'time_in_start'  => $request->time_in_start,
                        'time_in_end'    => $request->time_in_end,
                        'time_out_start' => $request->time_out_start,
                        'time_out_end'   => $request->time_out_end,
                    ]
                );
            }

            Notification::create([
            'user_id'   => 1,
            'user_type' => 'admin',
            'title'     => 'Override Attendance Time Set',
            'message'   => $company->name . ' set override on ' . $request->date . ': '
                        . 'Time In (' . $request->time_in_start . '–' . $request->time_in_end . '), '
                        . 'Time Out (' . $request->time_out_start . '–' . $request->time_out_end . ')',
            'is_read'   => false,
        ]);


    return back()->with('success', 'Time settings updated and admin notified.');


    }

}
