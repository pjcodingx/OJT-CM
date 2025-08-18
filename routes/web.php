<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\AdminProfileController;
use App\Http\Controllers\admin\CompanyController;
use App\Http\Controllers\admin\FacultyController;
use App\Http\Controllers\admin\StudentController;
use App\Http\Controllers\Auth\MultiLoginController;
use App\Http\Controllers\student\FeedbackController;
use App\Http\Controllers\faculty\MyStudentController;
use App\Http\Controllers\JournalManagementController;
use App\Http\Controllers\admin\AttendanceLogController;
use App\Http\Controllers\admin\AdminDashboardController;
use App\Http\Controllers\company\StudentRatingController;
use App\Http\Controllers\faculty\FacultyReportController;
use App\Http\Controllers\student\StudentJournalController;
use App\Http\Controllers\Company\CompanySettingsController;
use App\Http\Controllers\company\AssignedStudentsController;
use App\Http\Controllers\company\CompanyDashboardController;
use App\Http\Controllers\faculty\FacultyDashboardController;
use App\Http\Controllers\student\AttendanceAppealController;
use App\Http\Controllers\student\StudentDashboardController;
use App\Http\Controllers\company\CompanyAttendanceController;
use App\Http\Controllers\faculty\FacultyAttendanceController;
use App\Http\Controllers\student\StudentAttendanceController;
use App\Http\Controllers\company\CompanyNotificationController;
use App\Http\Controllers\faculty\FacultyNotificationController;
use App\Http\Controllers\student\StudentNotificationController;
use App\Http\Controllers\company\CompanyAttendanceAppealController;
use App\Http\Controllers\student\StudentAttendanceAppealController;

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
    Route::get('/attendance-logs' , [AttendanceLogController::class, 'adminIndex'])->name('admin.attendance');

    //for this para makita ang assigned students and companies sa Ojt Adviser!
    Route::get('/faculties/{faculty}/students', [FacultyController::class, 'showStudents'])->name('admin.faculties.students');
    Route::get('/faculties/{faculty}/companies', [FacultyController::class, 'showCompanies'])->name('admin.faculties.companies');

    Route::get('/journals', [AdminDashboardController::class, 'index'])->name('admin.index');


    //!exporting routes
    Route::get('/attendance/export-excel', [AttendanceLogController::class, 'exportExcel'])->name('admin.attendance.export.excel');
    Route::get('/admin/attendance/export-pdf', [AttendanceLogController::class, 'exportPDF'])
    ->name('admin.attendance.export.pdf');

    Route::get('/students/export', [StudentController::class, 'exportExcel'])->name('admin.students.export.excel');
    Route::get('/students/export-pdf', [StudentController::class, 'exportPdf'])->name('admin.students.export.pdf');


    //* Route for students management
    Route::get('/students', [StudentController::class, 'index'])->name('admin.students.index');
    Route::get('/students/create', [StudentController::class, 'create'])->name('admin.students.create');
    Route::post('/students', [StudentController::class, 'store'])->name('admin.students.store');
    Route::delete('/students/{id}', [StudentController::class, 'destroy'])->name('admin.students.destroy');
    Route::post('/students/{id}/generateQR', [StudentController::class, 'generateQR'])->name('admin.students.generateQR');
    Route::get('/students/{id}/edit', [StudentController::class, 'edit'])->name('admin.students.edit');
    Route::put('/students/{id}', [StudentController::class, 'update'])->name('admin.students.update');

    Route::get('/company/{company}/students', [CompanyController::class, 'showstudents'])->name('admin.companies.students');
    // Route::post('/student/attendance-appeals', [StudentAttendanceAppealController::class, 'store'])->name('student.appeals.store');


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
    Route::get('/profile', [StudentDashboardController::class, 'profile'])->name('student.profile');
    Route::post('/update-photo/{id}', [StudentDashboardController::class, 'updatePhoto'])->name('student.update.photo');

    Route::get('/journals', [StudentJournalController::class, 'index'])->name('student.journals.index');
    Route::get('/journals/create', [StudentJournalController::class, 'create'])->name('student.journals.create');
    Route::post('/journals', [StudentJournalController::class, 'store'])->name('student.journals.store');
    Route::get('/attendance', [StudentAttendanceController::class, 'index'])->name('student.attendance.index');

    Route::get('/attendance-appeals', [AttendanceAppealController::class, 'index'])->name('student.attendance-appeals.index');
    Route::get('/attendance-appeals/create/{attendance}', [AttendanceAppealController::class, 'create'])->name('student.attendance-appeals.create');
    Route::post('/attendance-appeals', [AttendanceAppealController::class, 'store'])->name('student.attendance-appeals.store');

    Route::get('/feedbacks', [FeedbackController::class, 'index'])->name('student.feedbacks.index');

     Route::post('/notifications/read-all', [StudentNotificationController::class, 'markAllAsRead'])->name('student.notifications.readAll');

     Route::get('/notifications', [StudentNotificationController::class, 'index'])
        ->name('student.notifications.index');



    Route::delete('/notifications/delete-all', [StudentNotificationController::class, 'deleteAll'])->name('student.notifications.deleteAll');

    Route::get('/change-password', [StudentDashboardController::class,'change'])->name('student.change-password');

    Route::post('/{student}/update-password', [StudentDashboardController::class, 'updatePassword'])->name('student.update.password');


});


// ROUTE FOR FACULTY
Route::middleware(['faculty'])->prefix('faculty')->group(function (){
    Route::get('/dashboard', [FacultyDashboardController::class, 'dashboard'])->name('faculty.dashboard');

    Route::get('/journals', [JournalManagementController::class, 'index'])->name('faculty.journals.index');
    Route::get('/my-students', [MyStudentController::class, 'index'])->name('faculty.students.index');
    Route::get('/attendance/logs', [FacultyAttendanceController::class, 'logs'] )->name('faculty.attendance.logs');

    Route::get('/feedbacks', [FacultyController::class, 'feedbacks'])->name('faculty.feedbacks.index');

    Route::post('/notifications/read-all', [FacultyNotificationController::class, 'markAllAsRead'])->name('faculty.notifications.readAll');

     Route::get('/notifications', [FacultyNotificationController::class, 'index'])
        ->name('faculty.notifications.index');



    Route::delete('/notifications/delete-all', [FacultyNotificationController::class, 'deleteAll'])->name('faculty.notifications.deleteAll');


   //! exporting files
   Route::get('/students/export-excel', [FacultyReportController::class, 'exportExcel'])->name('faculty.students.exportExcel');
    Route::get('/students/export-pdf', [FacultyReportController::class, 'exportPdf'])->name('faculty.students.exportPdf');







    Route::get('/summary', [FacultyReportController::class, 'index'])->name('faculty.reports.index');
    Route::get('/students/summary-report', [FacultyReportController::class, 'summaryReport'])->name('faculty.students.summaryReport');



});

Route::middleware(['company'])->prefix('company')->group(function(){
    Route::get('/dashboard', [CompanyDashboardController::class, 'dashboard'])->name('company.dashboard');
    Route::get('/students', [AssignedStudentsController::class, 'index'])->name('company.students.index');
    Route::get('/profile', [CompanyDashboardcontroller::class, 'profile'])->name('company.profile');
    Route::post('/update-photo/{id}/photo', [CompanyDashboardController::class, 'updatePhoto'])->name('company.update.photo');

    //route for qr code time in of students
    Route::get('/attendance-scanner', [CompanyAttendanceController::class, 'scanner'])->name('company.attendance.scanner');
    Route::post('/attendance-scan', [CompanyAttendanceController::class, 'scan'])->name('company.attendance.scan');
    Route::get('/attendance/logs', [CompanyAttendanceController::class, 'logs'])->name('company.attendance.logs');

    Route::get('/settings/time-rules', [CompanySettingsController::class, 'timeRules'])->name('company.settings.time_rules');
    Route::post('/settings/time-rules', [CompanySettingsController::class, 'storeTimeRules'])->name('company.settings.time_rules.store');
    Route::get('/attendance/current-rules', [CompanyAttendanceController::class, 'getCurrentTimeRules'])->name('company.attendance.current-rules');


    Route::get('/attendance-appeals', [CompanyAttendanceAppealController::class, 'index'])->name('company.attendance-appeals.index');
    Route::post('/attendance-appeals/{id}/approve', [CompanyAttendanceAppealController::class, 'approve'])->name('company.attendance-appeals.approve');
    Route::post('/attendance-appeals/{id}/reject', [CompanyAttendanceAppealController::class, 'reject'])->name('company.attendance-appeals.reject');


    //! RATINGS AND FEEDBACKS FOR STUDENTS
     Route::get('/students/rate', [StudentRatingController::class, 'index'])->name('company.students.rating.index');
    Route::get('/students/rate/{student}', [StudentRatingController::class, 'edit'])->name('company.students.rating.edit');
    Route::post('/students/rate/{student}', [StudentRatingController::class, 'update'])->name('company.students.rating.update');


    Route::get('/notifications', [CompanyNotificationController::class, 'index'])->name('company.notifications.index');

     Route::delete('/notifications/delete-all', [CompanyNotificationController::class, 'deleteAll'])->name('company.notifications.deleteAll');

      Route::post('/notifications/read-all', [CompanyNotificationController::class, 'markAllAsRead'])->name('faculty.notifications.readAll');
});
