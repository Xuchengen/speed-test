<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response('中华人民共和国');
})->middleware('lscache:max-age=300;public');
