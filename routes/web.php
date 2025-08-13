<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\StudentApplicationWizardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Api\ApplicationController as ApiApplicationController;
use App\Http\Controllers\PaymentController;

// Home/Welcome Route
Route::get('/', function () {
    if (auth()->check()) {
        return auth()->user()->isAdmin()
            ? redirect()->route('admin.dashboard')
            : redirect()->route('student.dashboard');
    }
    return view('welcome');
})->name('home');

// Authentication Routes
Route::controller(AuthController::class)->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('/login', 'showLoginForm')->name('login');
        Route::post('/login', 'login');

        // Registration Steps
        Route::get('/register/begin', 'showStep1')->name('register.begin');
        Route::post('/register/begin', 'postStep1')->name('register.begin.post');
        Route::get('/register', 'showStep2')->name('register');
        Route::post('/register', 'postStep2')->name('register.post');
    });

    Route::post('/logout', 'logout')->name('logout')->middleware('auth');
});

// =======================
// STUDENT ROUTES
// =======================
Route::middleware(['auth'])->prefix('student')->name('student.')->group(function () {
    Route::get('/dashboard', [StudentController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [StudentController::class, 'profile'])->name('profile');
    Route::post('/profile', [StudentController::class, 'updateProfile'])->name('profile.update');

    // Payment routes
    Route::get('/applications/{application}/payments', [PaymentController::class, 'index'])->name('payments.index');
    Route::get('/applications/{application}/payments/{payment}/download', [PaymentController::class, 'download'])->name('payments.download');

    Route::post('/application/submit', [StudentApplicationWizardController::class, 'submitApplication'])
    ->name('application.submit');

    // Start/resume application
    Route::get('/applications/start', [StudentApplicationWizardController::class, 'startApplication'])
        ->name('application.start');

    // Application wizard steps (1 to 11)
    Route::get('/application/step/{step}', [StudentApplicationWizardController::class, 'showStep'])
        ->name('application.step')
        ->where('step', '[1-9]|10|11');

    Route::post('/application/step/{step}', [StudentApplicationWizardController::class, 'postStep'])
        ->name('application.step.post')
        ->where('step', '[1-9]|10|11');

    // PDF export for application summary
    Route::get('/application/export/pdf', [StudentApplicationWizardController::class, 'exportPdf'])
        ->name('application.export.pdf');

    // Student applications list + view
    Route::resource('applications', StudentController::class)->only(['index', 'show'])
        ->parameters(['applications' => 'application']);

    // Profile + document download
    Route::controller(StudentController::class)->group(function () {
        Route::get('/application/download', 'downloadDocument')->name('application.download');
    });
});

// =======================
// ADMIN ROUTES
// =======================
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // Payment approvals
    Route::get('/payments', [AdminController::class, 'listPayments'])->name('payments.index');
    Route::get('/payments/{payment}/download', [AdminController::class, 'downloadPayment'])->name('payments.download');
    Route::patch('/payments/{payment}/approve', [AdminController::class, 'approvePayment'])->name('payments.approve');
    Route::patch('/payments/{payment}/reject', [AdminController::class, 'rejectPayment'])->name('payments.reject');
    Route::delete('/payments/{payment}', [AdminController::class, 'deletePayment'])->name('payments.delete');

    // Applications
    Route::resource('applications', AdminController::class)->except(['create', 'store'])
        ->parameters(['applications' => 'application']);

    Route::controller(AdminController::class)->group(function () {
        Route::patch('/applications/{application}/status', 'updateApplicationStatus')->name('applications.update-status');
        Route::post('/applications/bulk-update', 'bulkUpdateStatus')->name('applications.bulk-update');
        Route::get('/applications/{application}/download', 'downloadDocument')->name('applications.download');
        Route::get('/export', 'exportApplications')->name('export');
        Route::get('/reports', 'reports')->name('reports');
        Route::get('/settings', 'settings')->name('settings');
    });

    Route::resource('users', UserController::class)->except(['show']);
});

// =======================
// NOTIFICATIONS
// =======================
Route::middleware(['auth'])->group(function () {
    Route::post('/notifications/mark-all-read', function () {
        auth()->user()->unreadNotifications->markAsRead();
        return back()->with('success', 'All notifications marked as read.');
    })->name('notifications.mark-all-read');
});

// =======================
// API ROUTES
// =======================
Route::middleware(['auth:sanctum'])->prefix('api')->name('api.')->group(function () {
    Route::apiResource('applications', ApiApplicationController::class);
    Route::get('/dashboard/stats', [AdminController::class, 'getDashboardStats'])->name('dashboard.stats');
});

// =======================
// FALLBACK
// =======================
Route::fallback(function () {
    return view('errors.404');
});
