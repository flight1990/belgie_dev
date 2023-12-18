<?php

use Illuminate\Support\Facades\Route;
use Modules\AdminUsers\Http\Controllers\AdminUserController;


Route::controller(AdminUserController::class)
    ->middleware('auth')
    ->name('admin-users.')
    ->prefix('admin-users')
    ->group(function () {
        Route::get('/', 'index')->middleware(['permission:admin-users.index'])->name('index');

        Route::middleware(['permission:admin-users.create'])->group(function () {
            Route::post('/', 'store')->name('store');
            Route::get('/create', 'create')->name('create');
        });

        Route::middleware(['permission:admin-users.edit'])->group(function () {
            Route::get('/{id}/edit', 'edit')->name('edit');
            Route::patch('/{id}', 'update')->name('update');
        });

        Route::delete('/{id}', 'destroy')->middleware(['permission:admin-users.destroy'])->name('destroy');
    });
