<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


Route::middleware('guest.custom')->group(function () {

    Route::get('/', function () {
        return view('welcome');
    })->name('landing');

    Route::get('/register', function () {
        return view('pages.guest.auth.register');
    })->name('register');

    Route::get('/login', function () {
        return view('pages.guest.auth.login');
    })->name('login');
});

Route::middleware('auth.custom')->group(function () {
    Route::get('/profile', function () {
        return view('pages.authenticated.profile');
    })->name('profile');

    Route::get('/profile/update', function () {
        return view('pages.authenticated.update-profile');
    })->name('update-profile');

    Route::post('/logout', function () {
        Auth::logout();
        return redirect('/'); // or your home page
    })->name('logout');

    Route::get('/register-properties', function () {
        return view('pages.authenticated.property-registration');
    })->name('register-properties');
});

Route::get('/index', function () {
        return view('index');
    })->name('index');

Route::get('/test', function () {
    return view('pages.test');
});

Route::get('/properties/{id}', function ($id) {
    return view('pages.authenticated.property-show', ['id' => $id]);
})->name('properties.show');
