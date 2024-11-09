<?php

use App\Models\Category;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\AdminCategoryController;
use App\Http\Controllers\DashboardPostController;

// Route to homepage
Route::get('/', function () {

    return view('home', [
        'title' => 'Home',
        'categories' => Category::select('slug')->get(),
    ]);
})->name('home');

// Route to about page
Route::get('/about', function () {

    return view('about', [
        'title' => 'About',
    ]);
});

// Route to contact page
Route::get('/contact', function () {

    return view('contact', [
        'title' => 'Contact',
    ]);
});

// Route to display a single post
Route::get('/posts', [PostController::class, 'index'])->name('blog.posts');
// Route to display list of posts
Route::get('/posts/{post}', [PostController::class, 'show']);

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

    // Route to dashboard kanban
    Route::get('/dashboard', function () {

        return view('dashboard.kanban.index', [
            'title' => 'Dashboard',
            'subTitle' => 'Dashboard Kanban',
            'page' => 'kanban',
        ]);
    })->name('dashboard.kanban');

    // Route to check post slug
    Route::get('/dashboard/posts/checkSlug/{slug}', [DashboardPostController::class, 'checkSlug'])->name('posts.slug');
    // Route to dashboard posts
    Route::resource('/dashboard/posts', DashboardPostController::class);

    // Route to log out a user in session
    Route::post('/logout', [LoginController::class, 'logout'])->name('login.out'); // POST request is used to avoid the browser prefetching links on a webpage that would inadvertently logout the user's session

    Route::middleware('admin')->group(function () {

        // Route to admin dashboard categories
        Route::resource('/dashboard/admin/categories', AdminCategoryController::class)->except(['create', 'edit']);
    });
});
