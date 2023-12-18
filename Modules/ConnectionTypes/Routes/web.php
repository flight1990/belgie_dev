<?php

use Illuminate\Support\Facades\Route;
use Modules\ConnectionTypes\Http\Controllers\ConnectionTypeController;

Route::controller(ConnectionTypeController::class)
    ->middleware('auth')
    ->name('connection-types.')
    ->prefix('administration/connection-types')
    ->group(function () {
        Route::get('/', 'index')->middleware(['permission:connection-types.index'])->name('index');

        Route::middleware(['permission:connection-types.create'])->group(function () {
            Route::post('/', 'store')->name('store');
        });

        Route::middleware(['permission:connection-types.edit'])->group(function () {
            Route::patch('/{id}', 'update')->name('update');
        });

        Route::delete('/{id}', 'destroy')->middleware(['permission:connection-types.destroy'])->name('destroy');
    });
