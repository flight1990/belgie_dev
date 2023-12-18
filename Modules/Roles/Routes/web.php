<?php

use Illuminate\Support\Facades\Route;
use Modules\Roles\Http\Controllers\RolesController;

Route::controller(RolesController::class)
    ->middleware('auth')
    ->name('roles.')
    ->prefix('roles')
    ->group(function () {
        Route::get('/', 'index')->middleware(['permission:roles.index'])->name('index');

        Route::middleware(['permission:roles.create'])->group(function () {
            Route::post('/', 'store')->name('store');
            Route::get('/create', 'create')->name('create');
        });

        Route::middleware(['permission:roles.edit'])->group(function () {
            Route::get('/{id}/edit', 'edit')->name('edit');
            Route::patch('/{id}', 'update')->name('update');
        });

        Route::delete('/{id}', 'destroy')->middleware(['permission:roles.destroy'])->name('destroy');
    });
