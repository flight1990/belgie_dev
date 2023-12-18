<?php

use Illuminate\Support\Facades\Route;
use Modules\Statistics\Http\Controllers\StatisticsController;

Route::controller(StatisticsController::class)
    ->middleware('auth')
    ->name('statistics.')
    ->prefix('statistics')
    ->group(function () {
        Route::get('/', 'index')
            ->middleware(['permission:statistics.index'])
            ->name('index');
    });
