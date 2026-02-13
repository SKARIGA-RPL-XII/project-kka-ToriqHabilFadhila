<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PageController;
use App\Http\Controllers\Auth\AuthServices;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\AIController;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| PUBLIC PAGES
|--------------------------------------------------------------------------
*/

Route::get('/', fn() => view('landing-page'));
Route::get('/login', [PageController::class, 'login'])->name('login');
Route::get('/register', [PageController::class, 'register'])->name('register');
Route::get('/forgot-password', [PageController::class, 'forgot'])->name('password.request');


/*
|--------------------------------------------------------------------------
| AUTH ACTIONS
|--------------------------------------------------------------------------
*/
Route::post('/login', [AuthServices::class, 'login'])->name('login.submit');
Route::post('/register', [AuthServices::class, 'register'])->name('register.submit');
Route::post('/logout', [AuthServices::class, 'logout'])->name('logout');
// Google OAuth
Route::get('/auth/google', [GoogleController::class, 'redirect'])->name('google.auth');
Route::get('/auth/google/callback', [GoogleController::class, 'callback']);
Route::get('/auth/google/complete', [GoogleController::class, 'showComplete'])->name('google.complete');
Route::post('/auth/google/complete', [GoogleController::class, 'storeComplete'])->name('google.complete.store');


/*
|--------------------------------------------------------------------------
| PASSWORD RESET
|--------------------------------------------------------------------------
*/
Route::post('/forgot-password', [AuthServices::class, 'sendResetLink'])
    ->name('password.email');
Route::get('/reset-password/{token}', [AuthServices::class, 'showResetForm'])
    ->name('password.reset');
Route::post('/reset-password', [AuthServices::class, 'resetPassword'])
    ->name('password.update');


/*
|--------------------------------------------------------------------------
| DASHBOARD (ROLE BASED)
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware('auth')
    ->name('dashboard');

/*
|--------------------------------------------------------------------------
| PROFILE & SETTINGS
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'profile'])->name('profile');
    Route::put('/profile', [App\Http\Controllers\ProfileController::class, 'updateProfile'])->name('profile.update');
    Route::get('/settings', [App\Http\Controllers\ProfileController::class, 'settings'])->name('settings');
    Route::put('/profile/password', [App\Http\Controllers\ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::get('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/browser', [NotificationController::class, 'sendBrowserNotification'])->name('notifications.browser');
});

/*
|--------------------------------------------------------------------------
| PROTECTED AREA (AUTH)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    /*
    |--------------------------------------------------------------------------
    | ADMIN
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin/users', [AdminController::class, 'getUsers'])
            ->name('admin.users');
        Route::post('/admin/users', [AdminController::class, 'storeUser'])
            ->name('admin.users.store');
        Route::put('/admin/users/{id}', [AdminController::class, 'updateUser'])
            ->name('admin.users.update');
        Route::delete('/admin/users/{id}', [AdminController::class, 'deleteUser'])
            ->name('admin.users.delete');
        Route::get('/admin/classes', [AdminController::class, 'getClasses'])
            ->name('admin.classes');
        Route::delete('/admin/classes/{id}', [AdminController::class, 'deleteClass'])
            ->name('admin.classes.delete');
        Route::get('/admin/monitoring', [AdminController::class, 'getMonitoring'])
            ->name('admin.monitoring');
    });

    /*
    |--------------------------------------------------------------------------
    | GURU
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:guru')->group(function () {
        Route::post('/guru/classes', [GuruController::class, 'storeClass'])
            ->name('guru.classes.store');
        Route::post('/guru/materials', [GuruController::class, 'storeMaterial'])
            ->name('guru.materials.store');
        Route::post('/guru/assignments', [GuruController::class, 'storeAssignment'])
            ->name('guru.assignments.store');
        Route::get('/guru/assignments/{id}/questions', [GuruController::class, 'showQuestions'])
            ->name('guru.assignments.questions');
        Route::post('/guru/assignments/{id}/questions', [GuruController::class, 'storeQuestion'])
            ->name('guru.questions.store');
        Route::post('/guru/assignments/{id}/questions/generate', [GuruController::class, 'generateQuestions'])
            ->name('guru.questions.generate');
        Route::put('/guru/assignments/{id}/deadline', [GuruController::class, 'updateAssignmentDeadline'])
            ->name('guru.assignments.deadline');
        Route::delete('/guru/assignments/{id}', [GuruController::class, 'deleteAssignment'])
            ->name('guru.assignments.delete');
        Route::get('/guru/assignments/{id}/submissions', [GuruController::class, 'showSubmissions'])
            ->name('guru.assignments.submissions');
        Route::put('/guru/submissions/{id}/grade', [GuruController::class, 'gradeSubmission'])
            ->name('guru.submissions.grade');
        Route::get('/guru/classes/{id}', [GuruController::class, 'showClass'])
            ->name('guru.classes.show');
        Route::get('/guru/classes/{id}/students', [GuruController::class, 'getStudents'])
            ->name('guru.classes.students');
        Route::prefix('guru')->middleware('auth')->group(function () {
            Route::put('/guru/questions/{id}', [GuruController::class, 'updateQuestion'])
                ->name('guru.questions.update');
            Route::delete('/guru/questions/{id}', [GuruController::class, 'deleteQuestion'])
                ->name('guru.questions.delete');
            Route::delete('/guru/assignments/{id}/questions/bulk-delete', [GuruController::class, 'bulkDeleteQuestions'])
                ->name('guru.questions.bulkDelete');
        });
        Route::post('/guru/assignments/{id}/publish', [GuruController::class, 'publishAssignment'])
            ->name('guru.assignments.publish');
        // AI: Analisis progres siswa
        Route::get('/guru/ai/analyze/{userId}/{classId}', [AIController::class, 'analyzeProgress'])
            ->name('guru.ai.analyze');
        // AI: Koreksi otomatis jawaban
        Route::post('/guru/ai/grade', [AIController::class, 'autoGrade'])
            ->name('guru.ai.grade');
    });

    /*
    |--------------------------------------------------------------------------
    | SISWA
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:siswa')->group(function () {
        Route::get('/siswa/kelas', [SiswaController::class, 'index'])
            ->name('siswa.kelas');
        Route::post('/siswa/join-kelas', [SiswaController::class, 'join'])
            ->name('siswa.join');
        Route::get('/siswa/classes/{id}', [SiswaController::class, 'showClass'])
            ->name('siswa.classes.show');
        Route::get('/siswa/assignments/{id}', [SiswaController::class, 'showAssignment'])
            ->name('siswa.assignments.show');
        Route::post('/siswa/assignments/{id}/submit', [SiswaController::class, 'submitAssignment'])
            ->name('siswa.assignments.submit');
        Route::get('/siswa/submissions/{id}', [SiswaController::class, 'showSubmission'])
            ->name('siswa.submissions.show');
        Route::get('/siswa/materials', [SiswaController::class, 'materials'])
            ->name('siswa.materials');
        Route::get('/siswa/recommendations', fn() => view('siswa.recommendations'))
            ->name('siswa.recommendations');
        // AI: Feedback & Rekomendasi
        Route::post('/siswa/ai/feedback', [AIController::class, 'getFeedback'])
            ->name('siswa.ai.feedback');
        Route::get('/siswa/ai/recommendations', [AIController::class, 'getRecommendations'])
            ->name('ai.recommendations');
    });
});
