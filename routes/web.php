<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/about', function () {
    return view('about', [
        'name' => 'John Doe',
    ]);
});

Route::get('/blog', function () {
    return view('blog', [
        'name' => 'John Doe',
    ]);
});

Route::get('/contact', function () {
    return view('contact', [
        'name' => 'John Doe',
    ]);
});
