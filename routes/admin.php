<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return '<p>This is the ADMIN route!</p>';
});

Route::get('/login', function () {
    return '<h1>This is the LOGIN page!</h1>';
})->name('login');
