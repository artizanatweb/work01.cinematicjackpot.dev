<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('admin.test');
})->name('app');

//Route::get('/login', function () {
//    return '<h1>This is the LOGIN page!</h1>';
//})->name('login');
