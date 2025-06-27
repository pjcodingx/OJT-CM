<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\Auth\MultiLoginController;


// Route::get('/welcome', function () {
//     return view('welcome');
// });


Route::get('/', [WelcomeController::class, 'index'] )->name('welcome');


Route::get('/login', [MultiLoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [MultiLoginController::class, 'login'])->name('multi.login');

Route::middleware('auth:admin')
    ->get('/admin/dashboard', fn() => view('admin.dashboard'))
    ->name('admin.dashboard'); // ✅ Add route name

Route::middleware('auth:faculty')
    ->get('/faculty/dashboard', fn() => view('faculty.dashboard'))
    ->name('faculty.dashboard'); // ✅ Add route name

Route::middleware('auth:company')
    ->get('/company/dashboard', fn() => view('company.dashboard'))
    ->name('company.dashboard'); // ✅ Add route name

Route::middleware('auth:student')
    ->get('/student/dashboard', fn() => view('student.dashboard'))
    ->name('student.dashboard'); // ✅ Add route name

//! FOR LOGOUT
Route::post('/logout', [MultiLoginController::class, 'logout'])->name('logout');
