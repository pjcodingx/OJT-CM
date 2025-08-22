<?php

namespace App\Http\Controllers\admin;

use App\Models\Course;
use App\Models\Company;
use App\Models\Faculty;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CompanyController extends Controller
{
    //

    public function index(Request $request){
        $admin = Auth::guard('admin')->user();

        $query = Company::withCount('students');

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



        return view('admin.companies.index', compact('admin', 'companies'));
    }

    public function create(){
        $admin = Auth::guard('admin')->user();

        $faculties = Faculty::all();
        $courses = Course::all();

        return view('admin.companies.create', compact('admin', 'faculties', 'courses'));
    }

    public function store(Request $request){

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:companies,email',
            'password' => 'required|string|min:8',
            'address' => 'nullable|string|max:255',

        ]);

        $validated['password'] = Hash::make($validated['password']);

        Company::create($validated);


        return redirect()->route('admin.companies.index')->with('success', 'Company created successfully.');
    }

    public function edit($id){
        $admin = Auth::guard('admin')->user();
        $company = Company::findOrFail($id);


        return view('admin.companies.edit', compact('admin', 'company'));
    }

    public function update(Request $request, Company $company){

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

        $company->save();

      return redirect()->route('admin.companies.index')
    ->with('success', 'Company updated successfully.');


    }

    public function destroy($id){
        //delete company
        $company = Company::findOrFail($id);
        $company->delete();

        return redirect()->route('admin.companies.index')->with('success', 'Company deleted successfully.');
    }

    public function showStudents(Company $company){
        $admin = Auth::guard('admin')->user();

        //so need nato ang company i show ang ->students(), with->([dire relations nga i show pod like course sa students faculty sa students etc])
        $students = $company->students()->with(['course', 'faculty'])->paginate(10);

        return view('admin.companies.students', compact('admin', 'students', 'company'));
    }


}


