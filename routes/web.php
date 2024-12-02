<?php

use App\Models\Category;
use App\Livewire\Admin\AllPostsIndex;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\User\DashboardPostController;
use App\Http\Controllers\Admin\AdminCategoryController;

// Route to homepage
Route::get('/', function () {

    return view('home', [
        'title' => 'Home',
        'categories' => Category::select(['name', 'slug', 'image'])->get(),
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
    Route::get('/login', [LoginController::class, 'index'])->name('login.index');
    // Route to authenticate user login
    Route::post('/login', [LoginController::class, 'authenticate'])->name('login.authenticate');

    // Route to register page
    Route::get('/register', [RegisterController::class, 'index']);
    // Route to register a new user
    Route::post('/register', [RegisterController::class, 'store'])->name('register.store');
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

    // Route to User Profile
    Route::get('dashboard/profile/{user}', [ProfileController::class, 'index'])->name('user.profile');

    // Route to User Profile
    Route::get('/account/{user}', [ProfileController::class, 'show'])->name('user.account');

    // Route to log out a user in session
    Route::post('/logout', [LoginController::class, 'logout'])->name('login.out'); // POST request is used to avoid the browser prefetching links on a webpage that would inadvertently logout the user's session
});

// Admin Middleware Group
Route::middleware('admin')->group(function () {

    // Route to admin dashboard categories
    Route::get('/dashboard/admin/posts', AllPostsIndex::class)->name('admin.posts.index');

    // Route to admin dashboard categories
    Route::resource('/dashboard/admin/categories', AdminCategoryController::class)->except(['create', 'edit']);

    // Route to restore user
    Route::post('/dashboard/admin/users/{user}/restore', [AdminUserController::class, 'restore'])->name('users.restore')->withTrashed();
    // Route to force delete user
    Route::post('/dashboard/admin/users/{user}/erase', [AdminUserController::class, 'erase'])->name('users.erase')->withTrashed();
    // Route to admin dashboard users
    Route::resource('/dashboard/admin/users', AdminUserController::class);
});