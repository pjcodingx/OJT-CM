<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

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

        // If all guards failed, notify admin and show error
        return $this->sendFailedLoginResponse($request);

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



    protected function sendFailedLoginResponse(Request $request)
{

   // Track failed login attempts in session
    $key = 'failed_login_attempts_' . $request->email;
    $attempts = session()->get($key, 0) + 1;
    session()->put($key, $attempts);

    // Notify admin only after 3 failed attempts
    if ($attempts >= 3) {
        Notification::create([
            'user_id' => 1,
            'user_type' => 'admin',
            'title' => 'Multiple Failed Login Attempts',
            'message' => 'There have been 3 failed login attempts for email: ' . $request->email,
            'type' => 'security_alert',
            'is_read' => 0,
        ]);


        session()->forget($key);
    }


    throw ValidationException::withMessages([
        'email' => ['Authetication login failed!'],
    ]);
}

}
