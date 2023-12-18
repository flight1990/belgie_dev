<?php

use Illuminate\Support\Facades\Route;
use Modules\Operators\Http\Controllers\OperatorController;

Route::controller(OperatorController::class)
    ->middleware('auth')
    ->name('operators.')
    ->prefix('administration/operators')
    ->group(function () {
        Route::get('/', 'index')->middleware(['permission:operators.index'])->name('index');

        Route::middleware(['permission:operators.create'])->group(function () {
            Route::post('/', 'store')->name('store');
        });

        Route::middleware(['permission:operators.edit'])->group(function () {
            Route::patch('/{id}', 'update')->name('update');
        });

        Route::delete('/{id}', 'destroy')->middleware(['permission:operators.destroy'])->name('destroy');
    });
