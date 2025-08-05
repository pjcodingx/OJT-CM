<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\AdminProfileController;
use App\Http\Controllers\admin\CompanyController;
use App\Http\Controllers\admin\FacultyController;
use App\Http\Controllers\admin\StudentController;
use App\Http\Controllers\Auth\MultiLoginController;
use App\Http\Controllers\admin\AdminDashboardController;
use App\Http\Controllers\student\StudentDashboardController;

// Route::get('/welcome', function () {
//     return view('welcome');
// });

//? WELCOME PAGE FOR OJT SYSTEM
Route::get('/', [WelcomeController::class, 'index'] )->name('welcome');

//!for Authentication of Roles
Route::get('/login', [MultiLoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [MultiLoginController::class, 'login'])->name('multi.login');

// Route::middleware('auth:admin')
//     ->get('/admin/dashboard', fn() => view('admin.dashboard'))
//     ->name('admin.dashboard'); //

// Route::middleware('auth:faculty')
//     ->get('/faculty/dashboard', fn() => view('faculty.dashboard'))
//     ->name('faculty.dashboard');

// Route::middleware('auth:company')
//     ->get('/company/dashboard', fn() => view('company.dashboard'))
//     ->name('company.dashboard');

// Route::middleware('auth:student')
//     ->get('/student/dashboard', fn() => view('student.dashboard'))
//     ->name('student.dashboard');


//! FOR LOGOUT
Route::post('/logout', [MultiLoginController::class, 'logout'])->name('logout');




// !Admin profile edit & update to be edited or remove just trying out
Route::middleware('auth:admin')->group(function () {
    Route::get('/admin/profile/edit', [AdminProfileController::class, 'edit'])->name('admin.profile.edit'); // ✅ Add this
    Route::put('/admin/profile/update', [AdminProfileController::class, 'update'])->name('admin.profile.update');
});


//!  Added route for admin dashboard
Route::middleware(['admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'dashboard'])->name('admin.dashboard');



    //* Route for students management
    Route::get('/students', [StudentController::class, 'index'])->name('admin.students.index');
    Route::get('/students/create', [StudentController::class, 'create'])->name('admin.students.create');
    Route::post('/students', [StudentController::class, 'store'])->name('admin.students.store');
    Route::delete('/students/{id}', [StudentController::class, 'destroy'])->name('admin.students.destroy');
    Route::post('/students/{id}/generateQR', [StudentController::class, 'generateQR'])->name('admin.students.generateQR');
    Route::get('/students/{id}/edit', [StudentController::class, 'edit'])->name('admin.students.edit');
    Route::put('/students/{id}', [StudentController::class, 'update'])->name('admin.students.update');



    //? Route for OJT Advisers
    Route::get('/faculty', [FacultyController::class, 'index'])->name('admin.faculties.index');
    Route::get('/faculty/create', [FacultyController::class, 'create'])->name('admin.faculties.create');
    Route::post('/faculty', [FacultyController::class, 'store'])->name('admin.faculties.store');
    Route::get('/faculty/{id}/edit', [FacultyController::class, 'edit'])->name('admin.faculties.edit');
    Route::put('/faculty/{faculty}', [FacultyController::class, 'update'])->name('admin.faculties.update');
    Route::delete('/faculty/{id}', [FacultyController::class, 'destroy'])->name('admin.faculties.destroy');




    //* Route for Companies
    Route::get('/companies', [CompanyController::class, 'index'])->name('admin.companies.index');
    Route::get('/companies/create', [CompanyController::class, 'create'])->name('admin.companies.create');
    Route::post('/companies', [CompanyController::class, 'store'])->name('admin.companies.store');
    Route::get('/companies/{id}/edit', [CompanyController::class, 'edit'])->name('admin.companies.edit');
    Route::put('/companies/{company}', [CompanyController::class, 'update'])->name('admin.companies.update');

    Route::delete('/companies/{id}', [CompanyController::class, 'destroy'])->name('admin.companies.destroy');
});



//! Route for Students

Route::middleware(['student'])->prefix('student')->group(function () {
    Route::get('/dashboard', [StudentDashboardController::class, 'dashboard'])->name('student.dashboard');
});
