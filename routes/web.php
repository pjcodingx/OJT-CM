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
use App\Http\Controllers\faculty\MyCompaniesController;
use App\Http\Controllers\admin\AdminDashboardController;
use App\Http\Controllers\company\StudentRatingController;
use App\Http\Controllers\faculty\FacultyReportController;
use App\Http\Controllers\faculty\FacultyProfileController;
use App\Http\Controllers\student\StudentJournalController;
use App\Http\Controllers\student\StudentSummaryController;
use App\Http\Controllers\admin\AdminNotificationController;
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

    Route::patch('/students/{id}/toggle-status', [StudentController::class, 'toggleStatus'])->name('admin.students.toggleStatus');


    Route::get('/company/{company}/students', [CompanyController::class, 'showstudents'])->name('admin.companies.students');
    // Route::post('/student/attendance-appeals', [StudentAttendanceAppealController::class, 'store'])->name('student.appeals.store');


    //? Route for OJT Advisers
    Route::get('/faculty', [FacultyController::class, 'index'])->name('admin.faculties.index');
    Route::get('/faculty/create', [FacultyController::class, 'create'])->name('admin.faculties.create');
    Route::post('/faculty', [FacultyController::class, 'store'])->name('admin.faculties.store');
    Route::get('/faculty/{id}/edit', [FacultyController::class, 'edit'])->name('admin.faculties.edit');
    Route::put('/faculty/{faculty}', [FacultyController::class, 'update'])->name('admin.faculties.update');
    Route::delete('/faculty/{id}', [FacultyController::class, 'destroy'])->name('admin.faculties.destroy');


    Route::patch('/faculties/{id}/toggle-status', [FacultyController::class, 'toggleStatus'])->name('faculties.toggleStatus');





    //* Route for Companies
    Route::get('/companies', [CompanyController::class, 'index'])->name('admin.companies.index');
    Route::get('/companies/create', [CompanyController::class, 'create'])->name('admin.companies.create');
    Route::post('/companies', [CompanyController::class, 'store'])->name('admin.companies.store');
    Route::get('/companies/{id}/edit', [CompanyController::class, 'edit'])->name('admin.companies.edit');
    Route::put('/companies/{company}', [CompanyController::class, 'update'])->name('admin.companies.update');

    Route::delete('/companies/{id}', [CompanyController::class, 'destroy'])->name('admin.companies.destroy');

    Route::patch('/companies/{id}/toggle-status', [CompanyController::class, 'toggleStatus'])->name('companies.toggleStatus');



    //? FOR NOTIFICATIONS
     Route::get('notifications', [AdminNotificationController::class, 'index'])->name('admin.notifications.index');
    Route::post('notifications/read-all', [AdminNotificationController::class, 'markAllAsRead'])->name('admin.notifications.markAllAsRead');
    Route::post('notifications/{id}/read', [AdminNotificationController::class, 'markAsRead'])->name('admin.notifications.read');

    Route::delete('notifications/delete-all', [AdminNotificationController::class, 'deleteAll'])->name('admin.notifications.deleteAll');
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

    Route::get('/reports/student/{id}/summary/preview', [StudentSummaryController::class, 'preview'])
    ->name('reports.student.summary.preview');


// direct download
    Route::get('/reports/student/{id}/summary/download', [StudentSummaryController::class, 'download'])
    ->name('reports.student.summary.download');



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



    //!Managing Students create edit
    Route::get('/students', [MyStudentController::class, 'allStudents'])->name('faculty.manage-students.index');
    Route::get('/students/create', [MyStudentController::class, 'create'])->name('faculty.manage-students.create');
    Route::post('/students', [MyStudentController::class, 'store'])->name('faculty.manage-students.store');
    Route::get('/students/{id}/edit', [MyStudentController::class, 'edit'])->name('faculty.manage-students.edit');
    Route::put('/students/{id}', [MyStudentController::class, 'update'])->name('faculty.manage-students.update');
     Route::post('/students/{id}/generateQR', [MyStudentController::class, 'generateQR'])->name('faculty.manage-students.generateQR');

     //! Managing Companies
     Route::get('/companies', [MyCompaniesController::class, 'index'])->name('faculty.manage-companies.index');
    Route::get('/companies/create', [MyCompaniesController::class, 'create'])->name('faculty.manage-companies.create');
    Route::post('/companies', [MyCompaniesController::class, 'store'])->name('faculty.manage-companies.store');
    Route::get('/companies/{id}/edit', [MyCompaniesController::class, 'edit'])->name('faculty.manage-companies.edit');
    Route::put('/companies/{company}', [MyCompaniesController::class, 'update'])->name('faculty.manage-companies.update');
    Route::get('companies/{id}/students', [MyCompaniesController::class, 'showStudents'])->name('faculty.manage-companies.students');

     //!exporting files that need to fixed later
     Route::get('/manage-students/export-excel', [MyStudentController::class, 'exportExcel'])->name('faculty.manage-students.export.excel');
    Route::get('/manage-students/export-pdf', [MyStudentController::class, 'exportPdf'])->name('faculty.manage-students.export.pdf');





    Route::get('/summary', [FacultyReportController::class, 'index'])->name('faculty.reports.index');
    Route::get('/students/summary-report', [FacultyReportController::class, 'summaryReport'])->name('faculty.students.summaryReport');

    //? Profile
    Route::post('/{id}/update-photo', [FacultyProfileController::class, 'updatePhoto'])->name('faculty.update.photo');

     Route::get('/profile', [FacultyProfileController::class, 'show'])->name('faculty.profile');


     Route::get('/change-password', [FacultyProfileController::class, 'changePassword'])
        ->name('faculty.change-password');

    Route::post('/change-password', [FacultyProfileController::class, 'updatePassword'])
        ->name('faculty.update.password');








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
