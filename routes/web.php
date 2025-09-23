<?php

use App\Livewire\Auth\Register;
use Illuminate\Support\Facades\Route;
use App\Livewire\Properties\Show;
use Illuminate\Support\Facades\Auth;


Route::middleware('guest')->group(function () {

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

Route::get('/index', function () {
    return view('index');
})->name('index');

Route::get('/register-properties', function () {
    return view('pages.authenticated.property-registration');
})->name('register-properties');

Route::get('/profile', function () {
    return view('pages.authenticated.profile');
})->name('profile');

Route::get('/profile/update', function () {
    return view('pages.authenticated.update-profile');
})->name('update-profile');

Route::get('/test', function () {
    return view('pages.test');
});


Route::get('/properties/{id}', function ($id) {
    return view('pages.authenticated.property-show', ['id' => $id]);
})->name('properties.show');


Route::post('/logout', function () {
    Auth::logout();
    return redirect('/'); // or your home page
})->name('logout');
