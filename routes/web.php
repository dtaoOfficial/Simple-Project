<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProgrammeController;
use Illuminate\Support\Facades\Route;

Route::inertia('/', 'welcome')->name('home');
Route::resource('customers', CustomerController::class)->except('show');
Route::resource('programmes', ProgrammeController::class)->except('show');


