<?php

use Illuminate\Support\Facades\Route;
use Modules\Towers\Http\Controllers\TowersController;

Route::controller(TowersController::class)
    ->middleware('auth')
    ->name('towers.')
    ->prefix('administration/towers')
    ->group(function () {
        Route::get('/', 'index')->name('index');

        Route::middleware(['permission:towers.create'])->group(function () {
            Route::post('/', 'store')->name('store');
            Route::post('/import', 'import')->name('import');
        });

        Route::middleware(['permission:towers.edit'])->group(function () {
            Route::patch('/{id}', 'update')->name('update');
        });

        Route::delete('/{id}', 'destroy')->middleware(['permission:towers.destroy'])->name('destroy');
    });
