<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;

// Route to homepage
Route::get('/', function () {

    return view('home', [
        'title' => 'Home',
    ]);
});

// Route to about page
Route::get('/about', function () {

    return view('about', [
        'title' => 'About',
        'fullname' => 'John Doe',
    ]);
});

// Route to display a single post
Route::get('/posts', [PostController::class, 'index']);
// Route to display list of posts
Route::get('/posts/{post:slug}', [PostController::class, 'show']);

// Route to login page
Route::get('/login', [LoginController::class, 'index']);

// Route to register page
Route::get('/register', [RegisterController::class, 'index']);
// Route to create a new user
Route::post('/register', [RegisterController::class, 'store'])->name('register.create');

// Route to contact page
Route::get('/contact', function () {

    return view('contact', [
        'title' => 'Contact',
    ]);
});
