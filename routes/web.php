<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Auth\Register;
use App\Livewire\Auth\Login;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/register',Register::class)->name('register');
Route::get('/login',Login::class)->name('login');

