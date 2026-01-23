<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Auth;

// PAGES CONTROLLER
Route::get('/', fn () => view('landing-page'));
Route::get('/login', [PageController::class, 'login'])->name('login');
Route::get('/register', [PageController::class, 'register'])->name('register');
Route::get('/forgot-password', [PageController::class, 'forgot'])->name('forgot-password');


// AUTH CONTROLLER LOGIN
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
Route::post('/register', [RegisterController::class, 'register'])->name('register');
// Register via Google
Route::get('/auth/google/register', [RegisterController::class, 'redirectGoogle'])->name('register.google');
Route::get('/auth/google/register/callback', [RegisterController::class, 'callbackGoogle'])->name('register.google.callback');
// Login via Google
Route::get('/auth/google/login', [LoginController::class, 'redirectGoogle'])->name('login.google');
Route::get('/auth/google/login/callback', [LoginController::class, 'callbackGoogle'])->name('login.google.callback');
Route::post('/login-guest', [LoginController::class, 'loginAsGuest'])->name('login.guest');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

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
