<?php

use Illuminate\Support\Facades\Route;
use Modules\Profile\Http\Controllers\ProfileController;

Route::controller(ProfileController::class)
    ->middleware('auth')
    ->name('profile.')
    ->prefix('profile')
    ->group(function () {
        Route::get('/', 'edit')->name('edit');
        Route::patch('/', 'update')->name('update');
    });
