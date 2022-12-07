<?php

use Illuminate\Support\Facades\Route;
use Litespeed\LSCache\LSCache;

Route::get('/', [\App\Http\Controllers\HomeController::class, 'index'])->middleware('lscache:max-age=300;public');

Route::get('/clear', function () {
    LSCache::purgeAll();
});
