<?php

use Illuminate\Support\Facades\Route;
use Modules\Tests\Http\Controllers\TestsController;

Route::controller(TestsController::class)
    ->middleware('auth')
    ->name('tests.')
    ->prefix('tests')
    ->group(function () {
        Route::get('/', 'index')->name('index');
    });
