<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Auth\Register;
use App\Livewire\Auth\Login;
use App\Livewire\PropertyList;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Livewire\Home;
use App\Livewire\Auth\ForgotPassword;
use App\Livewire\Auth\ResetPassword;
use App\Livewire\Admin\Dashboard;
use App\Livewire\Tenant\HostRequest;
use App\Livewire\Admin\HostRequests;

Route::middleware(['auth', 'role:tenant'])->group(function () {
    Route::get('/host-request', HostRequest::class)->name('host.request');
});


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

    //password reset routes
    Route::get('/forgot-password', ForgotPassword::class)->name('password.request');
    Route::get('/reset-password/{token}', ResetPassword::class)->name('password.reset');
});

// ----------------------
// AUTH ROUTES (NO verified required)
// ----------------------
Route::middleware('auth')->group(function () {

    //email verification notice
    Route::get('/email/verify', function () {
        return view('livewire.auth.verify-email');
    })->name('verification.notice');

    // email verification handler
    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();

        return redirect('/home');
    })->middleware(['signed'])->name('verification.verify');

    // resend email verification link
    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();

        return back()->with('message', 'Verification link sent!');
    })->middleware(['throttle:6,1'])->name('verification.send');
});



// ----------------------
// VERIFIED ROUTES
// ----------------------
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/home', Home::class)->name('home');
});

//---------------------
//FOR ADMINS ONLY
//---------------------
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('admin/dashboard', Dashboard::class)->name('admin.dashboard');
    Route::get('/admin/host-requests', HostRequests::class)->name('admin.host.requests');
});

//logout
Route::post('/logout', function () {
    Auth::logout();
    session()->invalidate();
    session()->regenerateToken();

    return redirect('/login');
})->name('logout');
