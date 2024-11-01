<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\DashboardController;

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

// Guest Middleware Group
Route::middleware('guest')->group(function () {
    // Route to login page
    Route::get('/login', [LoginController::class, 'index']);
    // Route to authenticate user login
    Route::post('/login', [LoginController::class, 'authenticate'])->name('login.authenticate');

    // Route to register page
    Route::get('/register', [RegisterController::class, 'index']);
    // Route to register a new user
    Route::post('/register', [RegisterController::class, 'store'])->name('register.create');
});

// Auth Middleware Group
Route::middleware('auth')->group(function () {
    // Route to user dashboard
    Route::get('/dashboard', [DashboardController::class, 'index']);

    // Route to log out a user in session
    Route::post('/logout', [LoginController::class, 'logout'])->name('login.out'); // POST request is used to avoid the browser prefetching links on a webpage that would inadvertently logout the user's session
});

// Route to contact page
Route::get('/contact', function () {

    return view('contact', [
        'title' => 'Contact',
    ]);
});
