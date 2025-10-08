<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
use App\Livewire\Properties\PropertyList;
use App\Livewire\Profile;

Route::middleware('guest.custom')->group(function () {

    Route::get('/', function () {
        return view('welcome');
    })->name('landing');

    Route::get('/register', Register::class)->name('register');
    Route::get('/login', Login::class )->name('login');
});

Route::middleware('auth.custom')->group(function () {

    Route::get('/profile', Profile::class)->name('profile');

    Route::get('/profile/update', function () {
        return view('pages.authenticated.update-profile');
    })->name('update-profile');

    Route::post('/logout', function () {
        Auth::logout();
        return redirect('/login'); // or your home page
    })->name('logout');

    Route::get('/register-properties', function () {
        return view('pages.authenticated.property-registration');
    })->name('register-properties');
});

Route::get('/property-list', PropertyList::class)->name('index');

Route::get('/test', function () {
    return view('pages.test');
});

Route::get('/properties/{id}', function ($id) {
    return view('pages.authenticated.property-show', ['id' => $id]);
})->name('properties.show');
