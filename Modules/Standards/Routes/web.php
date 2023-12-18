<?php

use Illuminate\Support\Facades\Route;

use Modules\Standards\Http\Controllers\StandardController;

Route::controller(StandardController::class)
    ->middleware('auth')
    ->name('standards.')
    ->prefix('administration/standards')
    ->group(function () {
        Route::get('/', 'index')->middleware(['permission:standards.index'])->name('index');

        Route::middleware(['permission:standards.create'])->group(function () {
            Route::post('/', 'store')->name('store');
        });

        Route::middleware(['permission:standards.edit'])->group(function () {
            Route::patch('/{id}', 'update')->name('update');
        });

        Route::delete('/{id}', 'destroy')->middleware(['permission:standards.destroy'])->name('destroy');
    });
