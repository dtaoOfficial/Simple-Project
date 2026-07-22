<?php

use App\Http\Controllers\CustomerController;
use Illuminate\Support\Facades\Route;

Route::inertia('/', 'welcome')->name('home');
Route::resource('customers', CustomerController::class)->except('show');

