<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class MultiLoginController extends Controller
{

    public function showLoginForm()
    {
        // Return the login view
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $credentials = $request->only('email', 'password');

        // Try Admin guard
        if (Auth::guard('admin')->attempt($credentials)) {

            return $this->showDashboard('admin');
        }

        // Try Faculty guard
        if (Auth::guard('faculty')->attempt($credentials)) {

             $faculty = Auth::guard('faculty')->user();

            if($faculty->status == 0){
                Auth::guard('faculty')->logout();
                return back()->withErrors(['email' => 'Your account is disabled. Contact admin.']);
            }



            return $this->showDashboard('faculty');
        }

        //try Student guard

        if (Auth::guard('student')->attempt($credentials)) {
            $student = Auth::guard('student')->user();

            if($student->status == 0){
                Auth::guard('student')->logout();
                return back()->withErrors(['email' => 'Your account is disabled. Contact admin.']);
            }


            return $this->showDashboard('student');
        }

        // Try Company guard
        if (Auth::guard('company')->attempt($credentials)) {

              $company = Auth::guard('company')->user();

            if($company->status == 0){
                Auth::guard('company')->logout();
                return back()->withErrors(['email' => 'Your account is disabled. Contact admin.']);
            }

            return $this->showDashboard('company');
        }

        return back()->withErrors(['email' => 'Invalid credentials']);
    }

    public function showDashboard($role){
        return match($role){
        'admin' => redirect()->route('admin.dashboard'),
        'faculty' => redirect()->route('faculty.dashboard'),
        'student' => redirect()->route('student.dashboard'),
        'company' => redirect()->route('company.dashboard'),
        default => redirect('/login')->withErrors(['role' => 'Invalid role specified'])
        };

    }

    public function logout(Request $request)
    {
        if (Auth::guard('admin')->check()) {
        Auth::guard('admin')->logout();
    } elseif (Auth::guard('faculty')->check()) {
        Auth::guard('faculty')->logout();
    }elseif(Auth::guard('student')->check()) {
        Auth::guard('student')->logout();
    } elseif (Auth::guard('company')->check()) {
        Auth::guard('company')->logout();
    }

    // Optional: invalidate session and regenerate token
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/login');
    }
}
