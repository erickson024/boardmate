<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Livewire\Auth\Signup\Signup;
use App\Livewire\Auth\Login;
use App\Livewire\Profile;
use App\Livewire\Properties\PropertyRegistration;
use Illuminate\Support\Facades\Session;
use App\Livewire\UserPropertyList;
use App\Livewire\ProfileUpdate\UpdateProfile;
use App\Http\Controllers\GoogleController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

// Routes for guest users
Route::middleware('guest.custom')->group(function () {

    Route::get('/', function () {
        return view('welcome');
    })->name('landing');

    // Authentication Routes
    Route::get('/login', Login::class)->name('login');
    Route::get('/signup', Signup::class)->name('signup');

    // Google OAuth Routes
    Route::get('/auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google.redirect');
    Route::get('/auth/google/callback', [GoogleController::class, 'handleGoogleCallback'])->name('google.callback');
});

// Routes for authenticated and verified users
Route::middleware(['auth.custom'])->group(function () {

    Route::get('/profile', Profile::class)->name('profile');
    Route::get('profile/update', UpdateProfile::class)->name('update-profile');
    Route::get('property-registration', PropertyRegistration::class)->name('property-registration');
    Route::get('user-property-list', UserPropertyList::class)->name('user-property-list');
});

Route::post('/logout', function (Request $request) {
    if (Auth::check()) {
        $user = Auth::user();

        //  Clear the property registration data for that specific user
        Session::forget("property_reg_{$user->id}");

        // Force clear the remember_token
        $user->remember_token = null;
        $user->save();
    }

    Auth::logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    // explicitly forget the remember-me cookie
    $cookie = cookie()->forget(Auth::getRecallerName());

    return redirect('/login')->withCookie($cookie);
})->name('logout');

//mispled fallback route
Route::fallback(function () {
    if (Auth::check()) {
        return redirect()->route('profile');
    }

    return redirect()->route('landing');
});


Route::get('/test', function () {
    return view('pages.test');
});

Route::get('/properties/{id}', function ($id) {
    return view('pages.authenticated.property-show', ['id' => $id]);
})->name('properties.show');


// Email Verification Routes
Route::middleware('auth')->group(function () {
    Route::get('/email/verify', function () {
        return view('livewire.auth.verify-email');
    })->middleware('auth')->name('verification.notice');

    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();

        return redirect('/profile');
    })->middleware(['auth', 'signed'])->name('verification.verify');

    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();

        return back()->with('message', 'Verification link sent!');
    })->middleware(['auth', 'throttle:6,1'])->name('verification.send');
});
