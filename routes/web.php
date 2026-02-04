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
use App\Livewire\Host\InitialPage;
use App\Livewire\Properties\PropertyRegistration;
use App\Livewire\PropertyDetails;
use App\Livewire\Users\Settings\SettingPage;
use App\Livewire\Users\Dashboard\DashboardPage;
use App\Livewire\Users\Dashboard\HostPropertyDetails;
use App\Livewire\VerifiedHostList\VerifiedHost;
use App\Livewire\VerifiedHostList\VerifiedHostInfo;
use App\Livewire\PropertyInquiry;
use App\Livewire\Tenant\MyInquiries;


Route::middleware(['auth', 'role:tenant'])->group(function () {
    Route::get('/host-request', HostRequest::class)->name('host.request');
});

Route::middleware(['auth', 'role:host'])->group(function () {
    Route::get('/host/welcome', InitialPage::class)->name('host.welcome');
    Route::get('property/registration', PropertyRegistration::class)->name('property-registration');
    Route::get('/properties/{propertyId}', HostPropertyDetails::class)->name('host-property-details');
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
    Route::get('/property/{id}', PropertyDetails::class)->name('property.details');
    Route::get('/settings', SettingPage::class)->name('user.settings');
    Route::get('/user/dashboard', DashboardPage::class)->name('user.dashboard');
    Route::get('/verified-hosts', VerifiedHost::class)->name('verified-hosts');
    Route::get('/verified-hosts/{id}', VerifiedHostInfo::class)->name('verified-host-info');

    Route::get('/property/{propertyId}/inquiry', PropertyInquiry::class)
        ->name('property.inquiry');

    Route::get('/my-inquiries', MyInquiries::class)
        ->name('tenant.inquiries');
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
    Auth::user()->markAsOffline();
    Auth::logout();
    session()->invalidate();
    session()->regenerateToken();

    return redirect('/login');
})->name('logout');


Route::get('/test', function () {
    return view('test');
});

Route::get('/home', Home::class)->name('home');

Route::get('/notifications', function () {
    return view('notifications');
})->middleware('auth')->name('notifications');
