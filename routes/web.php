<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Auth\Register;
use App\Livewire\Auth\Login;
use App\Livewire\PropertyList;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Livewire\Home;

// ----------------------
// GUEST ROUTES
// ----------------------
Route::middleware('guest')->group(function () {
    Route::get('/', function () {
        return view('welcome');
    })->name('welcome');

    Route::get('/register', Register::class)->name('register');
    Route::get('/login', Login::class)->name('login');
    Route::get('/property/list', PropertyList::class)->name('propertyList');
});

// ----------------------
// AUTH ROUTES (NO verified required)
// ----------------------
Route::middleware('auth')->group(function () {});

//email verification notice
Route::get('/email/verify', function () {
    return view('livewire.auth.verify-email');
})->middleware('auth')->name('verification.notice');

// email verification handler
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('/home');
})->middleware(['auth', 'signed'])->name('verification.verify');

// resend email verification link
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

// ----------------------
// VERIFIED ROUTES
// ----------------------
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/home',Home::class)->name('home');
});




//logout
Route::post('/logout', function () {
    Auth::logout();
    session()->invalidate();
    session()->regenerateToken();

    return redirect('/login');
})->name('logout');
