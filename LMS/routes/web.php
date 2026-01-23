<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\Auth\AuthServices;
use App\Http\Controllers\Auth\GoogleController;
use Illuminate\Support\Facades\Auth;

// PAGES CONTROLLER
Route::get('/', fn () => view('landing-page'));
Route::get('/login', [PageController::class, 'login'])->name('login');
Route::get('/register', [PageController::class, 'register'])->name('register');
Route::get('/forgot-password', [PageController::class, 'forgot'])->name('forgot-password');


// AUTH CONTROLLER LOGIN & REGISTER
Route::post('/login', [AuthServices::class, 'login'])->name('login.submit');
Route::post('/register', [AuthServices::class, 'register'])->name('register');
Route::post('/logout', [AuthServices::class, 'logout'])->name('logout');
Route::post('/login-guest', [AuthServices::class, 'loginAsGuest'])->name('login.guest');
Route::get('/auth/google', [GoogleController::class, 'redirect'])->name('google.auth');
Route::get('/auth/google/callback', [GoogleController::class, 'callback']);



// DASHBOARD ROLE LOGIN
Route::get('/dashboard', function () {
    $user = Auth::user();
    if (!$user) {
        return redirect()->route('login');
    }
    switch ($user->role) {
        case 'admin':
            return view('dashboard.admin');
        case 'guru':
            return view('dashboard.guru');
        case 'siswa':
        default:
            return view('dashboard.siswa');
    }
})->name('dashboard')->middleware('auth');

// PROTECTED AREA QUEST
Route::middleware('auth')->group(function () {
    // 🚫 fitur ini TIDAK boleh diakses tamu
    Route::middleware(\App\Http\Middleware\BlockGuest::class)->group(function () {
        Route::get('/submit-tugas', function () {
            return 'Form submit tugas';
        });
        Route::get('/profile', function () {
            return 'Halaman profile';
        });
    });
});
