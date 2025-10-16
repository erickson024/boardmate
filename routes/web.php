<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
use App\Livewire\Profile;
use App\Livewire\Properties\PropertyRegistration;
use Illuminate\Support\Facades\Session;
use App\Livewire\UserPropertyList;
use App\Livewire\ProfileUpdate\UpdateProfile;

Route::middleware('guest.custom')->group(function () {

    Route::get('/', function () {
        return view('welcome');
    })->name('landing');

    Route::get('/register', Register::class)->name('register');
    Route::get('/login', Login::class)->name('login');
});

Route::middleware('auth.custom')->group(function () {

    Route::get('/profile', Profile::class)->name('profile');
    Route::get('profile/update', UpdateProfile::class)->name('update-profile');
    Route::get('property-registration', PropertyRegistration::class)->name('property-registration');
    Route::get('user-property-list', UserPropertyList::class)->name('user-property-list');

    Route::post('/logout', function () {
        if (Auth::check()) {
            $userId = Auth::id();

            // 🧹 Clear the property registration data for that specific user
            Session::forget("property_reg_{$userId}");
        }

        Auth::logout();

        // 🔐 Fully invalidate the session
        Session::invalidate();
        Session::regenerateToken();

        return redirect('/login');
    })->name('logout');
});



Route::get('/test', function () {
    return view('pages.test');
});

Route::get('/properties/{id}', function ($id) {
    return view('pages.authenticated.property-show', ['id' => $id]);
})->name('properties.show');
