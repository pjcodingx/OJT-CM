<?php

namespace App\Http\Controllers\faculty;

use App\Models\Company;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class MyCompaniesController extends Controller
{
    //

    public function index(Request $request){
        $faculty = Auth::guard('faculty')->user();

        $query = Company::withCount('students')
        ->where('faculty_id', $faculty->id);

         if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('address', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%");
            });
        }

        $companies = $query->paginate(8)->withQueryString();



        return view('faculty.manage-companies.index', compact('faculty', 'companies'));
    }

    public function create(){
        $faculty = Auth::guard('faculty')->user();

        return view('faculty.manage-companies.create', compact('faculty'));
    }

    public function store(Request $request){
        $faculty = Auth::guard('faculty')->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:companies,email',
            'password' => 'required|string|min:8',
            'address' => 'nullable|string|max:255',
        ]);

        $validated['password'] = bcrypt($validated['password']);
        $validated['faculty_id'] = $faculty->id;

        $company = Company::create($validated);

        $admin = \App\Models\Admin::first();

    if ($admin) {
        Notification::createLimited([
            'user_id' => $admin->id,
            'user_type' => 'admin',
            'title' => 'New Company Registered',
            'message' => 'OJT Adviser '.$faculty->name.' has added a new company: '.$company->name,
            'type' => 'new_company',
            'is_read' => 0,
        ]);
    }


        return redirect()->route('faculty.manage-companies.create')->with('success', 'Company created successfully.');
    }

     public function edit($id){
        $faculty = Auth::guard('faculty')->user();
        $company = Company::findOrFail($id);


        return view('faculty.manage-companies.edit', compact('faculty', 'company'));
    }

    public function update(Request $request, Company $company){
        $faculty = Auth::guard('faculty')->user();
        $company = Company::findOrFail($company->id);


        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email'=> 'required|email|unique:companies,email,' . $company->id,
            'password' => 'nullable|string|min:6|confirmed',
            'address' => 'nullable|string|max:255'

        ]);

        $company->name = $validated['name'];
        $company->email = $validated['email'];
        $company->address = $validated['address'] ?? null;


        if (!empty($validated['password'])) {
            $company->password = Hash::make($validated['password']);
        }

        $validated['faculty_id'] = $faculty->id;
        $company->save();

       return redirect()->route('faculty.manage-companies.index')->with('success', 'Company updated successfully.');


    }

     public function showStudents($id){
        $faculty = Auth::guard('faculty')->user();

          $company = Company::where('id', $id)
        ->where('faculty_id', $faculty->id)
        ->firstOrFail();

        //so need nato ang company i show ang ->students(), with->([dire relations nga i show pod like course sa students faculty sa students etc])
        $students = $company->students()->where('faculty_id', $faculty->id)->with(['course', 'faculty'])->paginate(10);



        return view('faculty.manage-companies.students', compact('faculty', 'students', 'company'));
    }




}
