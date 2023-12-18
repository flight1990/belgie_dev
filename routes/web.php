<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('tests.index');
});

Route::auth([
    'register' => false,
    'reset' => false,
    'verify' => false,
    'confirm' => false
]);
