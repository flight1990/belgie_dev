<?php

use Illuminate\Support\Facades\Route;

use Modules\WebResources\Http\Controllers\WebResourceController;

Route::controller(WebResourceController::class)
    ->middleware('auth')
    ->name('web-resources.')
    ->prefix('administration/web-resources')
    ->group(function () {
        Route::get('/', 'index')->middleware(['permission:web-resources.index'])->name('index');

        Route::middleware(['permission:web-resources.create'])->group(function () {
            Route::post('/', 'store')->name('store');
        });

        Route::middleware(['permission:web-resources.edit'])->group(function () {
            Route::patch('/{id}', 'update')->name('update');
        });

        Route::delete('/{id}', 'destroy')->middleware(['permission:web-resources.destroy'])->name('destroy');
    });
