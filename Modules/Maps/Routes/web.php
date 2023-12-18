<?php

use Illuminate\Support\Facades\Route;
use Modules\Maps\Http\Controllers\TestsMapController;
use Modules\Maps\Http\Controllers\TowersMapController;

Route::middleware('auth')
    ->name('maps.')
    ->prefix('maps')
    ->group(function () {

        Route::controller(TestsMapController::class)
            ->middleware(['permission:maps.tests.index'])
            ->name('tests.')
            ->prefix('tests')
            ->group(function () {
                Route::get('/', 'index')->name('index');
            });

        Route::controller(TowersMapController::class)
            ->middleware(['permission:maps.towers.index'])
            ->name('towers.')
            ->prefix('towers')
            ->group(function () {
                Route::get('/', 'index')->name('index');
            });
    });
