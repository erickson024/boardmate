<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Auth\Register;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/register',Register::class)->name('register');
