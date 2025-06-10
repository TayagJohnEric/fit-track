<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('user.dashboard.dashboard');
});

Route::get('/admin-dashboard', function () {
    return view('admin.dashboard.dashboard');
});

