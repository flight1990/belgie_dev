<?php

use Illuminate\Support\Facades\Route;

use Modules\Servers\Http\Controllers\ServerController;

Route::controller(ServerController::class)
    ->middleware('auth')
    ->name('servers.')
    ->prefix('administration/servers')
    ->group(function () {
        Route::get('/', 'index')->middleware(['permission:servers.index'])->name('index');

        Route::middleware(['permission:servers.create'])->group(function () {
            Route::post('/', 'store')->name('store');
        });

        Route::middleware(['permission:servers.edit'])->group(function () {
            Route::patch('/{id}', 'update')->name('update');
        });

        Route::delete('/{id}', 'destroy')->middleware(['permission:servers.destroy'])->name('destroy');
    });
