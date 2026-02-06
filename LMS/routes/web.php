<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PageController;
use App\Http\Controllers\Auth\AuthServices;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\DashboardController;

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
});

/*
|--------------------------------------------------------------------------
| PROTECTED AREA (AUTH)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
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
        Route::get('/guru/classes/{id}', [GuruController::class, 'showClass'])
            ->name('guru.classes.show');
        Route::prefix('guru')->middleware('auth')->group(function () {
            Route::put('/guru/questions/{id}', [GuruController::class, 'updateQuestion'])
                ->name('guru.questions.update');
        });
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
    });
});
