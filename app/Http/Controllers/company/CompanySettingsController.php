<?php

namespace App\Http\Controllers\Company;

use Log;
use App\Models\Company;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\CompanyTimeOverride;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CompanySettingsController extends Controller
{
    public function timeRules()
    {
        $company = Auth::guard('company')->user();
        $overrides = CompanyTimeOverride::where('company_id', $company->id)->orderBy('date', 'desc')->get();

        return view('company.settings.time_rules', compact('company', 'overrides'));
    }

    public function storeTimeRules(Request $request)
    {
      $authCompany = Auth::guard('company')->user();
      $company = Company::find($authCompany->id);

    $faculty = $company->faculty;





    if ($request->has('default')) {
        $company->allowed_time_in_start  = $request->default['time_in_start'];
        $company->allowed_time_in_end    = $request->default['time_in_end'];
        $company->allowed_time_out_start = $request->default['time_out_start'];
        $company->allowed_time_out_end   = $request->default['time_out_end'];
        $company->working_days = json_encode($request->default['working_days'] ?? []);
        $company->default_start_date = $request->default['start_date'] ?? now()->toDateString();

        $company->save();


       Notification::create([
            'user_id'   => 1,
            'user_type' => 'admin',
            'title'     => 'Default Attendance Time Set',
            'message'   => $company->name . ' updated default time: '
                        . 'Time In (' . $company->allowed_time_in_start . '–' . $company->allowed_time_in_end . '), '
                        . 'Time Out (' . $company->allowed_time_out_start . '–' . $company->allowed_time_out_end . ')',
            'is_read'   => false,
        ]);

       if ($faculty) { // check if a faculty is assigned
            Notification::create([
                'user_id'   => $faculty->id,
                'user_type' => 'faculty',
                'type'      => 'attendance_time',
                'title'     => 'Default Attendance Time Set',
                'message'   => $company->name . ' updated default time: '
                            . 'Time In (' . $company->allowed_time_in_start . '–' . $company->allowed_time_in_end . '), '
                            . 'Time Out (' . $company->allowed_time_out_start . '–' . $company->allowed_time_out_end . ')',
                'is_read'   => false,
            ]);
        }



    }






    if ($request->has('override')) {

    $isNoWork = $request->input('override.is_no_work', 0);
    $isNoWork = (int) $isNoWork;

    $overrideData = [
        'time_in_start'  => $request->override['time_in_start'] ?? null,
        'time_in_end'    => $request->override['time_in_end'] ?? null,
        'time_out_start' => $request->override['time_out_start'] ?? null,
        'time_out_end'   => $request->override['time_out_end'] ?? null,
         'is_no_work'     => $isNoWork,
    ];

    $override = CompanyTimeOverride::updateOrCreate(
        [
            'company_id' => $company->id,
            'date'       => $request->override['date'],
        ],
        $overrideData
    );


    Notification::create([
        'user_id'   => 1,
        'user_type' => 'admin',
        'title'     => 'New Attendance Time Set',
        'message'   => $company->name . ' set new attendance time on ' . $override->date
                     . ($override->is_no_work ? ' (No Work Today)' : '')
                     . ': Time In (' . ($override->time_in_start ?? '-') . '–' . ($override->time_in_end ?? '-') . '), '
                     . 'Time Out (' . ($override->time_out_start ?? '-') . '–' . ($override->time_out_end ?? '-') . ')',
        'is_read'   => false,
    ]);

    if ($faculty) {
        Notification::create([
            'user_id'   => $faculty->id,
            'user_type' => 'faculty',
            'type'      => 'attendance_time',
            'title'     => 'New Attendance Time Set',
            'message'   => $company->name . ' set new attendance time on ' . $override->date
                         . ($override->is_no_work ? ' (No Work Today)' : '')
                         . ': Time In (' . ($override->time_in_start ?? '-') . '–' . ($override->time_in_end ?? '-') . '), '
                         . 'Time Out (' . ($override->time_out_start ?? '-') . '–' . ($override->time_out_end ?? '-') . ')',
            'is_read'   => false,
        ]);
    }
}




    return redirect()->back()->with('success', 'Time settings updated successfully.');

}
}
