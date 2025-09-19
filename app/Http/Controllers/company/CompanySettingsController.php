<?php

namespace App\Http\Controllers\Company;

use App\Models\Company;
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
        $company = Auth::guard('company')->user();

       $authCompany = Auth::guard('company')->user();
        $company = Company::find($authCompany->id);


        if ($request->has('default')) {
            $company->allowed_time_in_start = $request->default['time_in_start'];
            $company->allowed_time_in_end = $request->default['time_in_end'];
            $company->allowed_time_out_start = $request->default['time_out_start'];
            $company->allowed_time_out_end = $request->default['time_out_end'];
            $company->save();
        }


        if ($request->has('override')) {
            CompanyTimeOverride::updateOrCreate(
                [
                    'company_id' => $company->id,
                    'date' => $request->override['date']
                ],
                [
                    'time_in_start' => $request->override['time_in_start'],
                    'time_in_end' => $request->override['time_in_end'],
                    'time_out_start' => $request->override['time_out_start'],
                    'time_out_end' => $request->override['time_out_end'],
                ]
            );
        }

    return redirect()->back()->with('success', 'Time settings updated successfully.');
    }
}
