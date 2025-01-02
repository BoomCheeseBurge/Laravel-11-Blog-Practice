<?php

use App\Models\Category;
use App\Livewire\Admin\AllPostsIndex;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\User\DashboardPostController;
use App\Http\Controllers\Admin\AdminCategoryController;

// Route to homepage
Route::view('/', 'home', [
    'title' => 'Home',
    'categories' => Category::select(['name', 'slug', 'image'])->get(),
])->name('home');

// Route to about page
Route::view('/about', 'about', [
    'title' => 'About',
]);

// Route to contact page
Route::view('/contact', 'contact', [
    'title' => 'Contact',
]);

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

    // Password Reset Link Request Form
    Route::get('/forgot-password', [AuthController::class, 'resetPasswordLinkForm'])->name('password.request');
    // Handling the Link Form Submission
    Route::post('/forgot-password', [AuthController::class, 'sendResetPassword'])->name('password.email');
    // Password Reset Form
    Route::get('/reset-password/{token}', [AuthController::class, 'resetPasswordForm'])->name('password.reset');
    // Handling the Reset Form Submission
    Route::post('/reset-password', [AuthController::class, 'performResetPassword'])->name('password.update');
});

// Auth Middleware Group
Route::middleware('auth')->group(function () {

    // Route to show User Profile
    Route::get('/account/{user}', [ProfileController::class, 'show'])->name('user.account');

    // Route to user settings
    Route::get('user/setting/{user}', [SettingsController::class, 'index'])->name('user.setting');

    // Route to log out a user in session
    Route::post('/logout', [LoginController::class, 'logout'])->name('login.out'); // POST request is used to avoid the browser prefetching links on a webpage that would inadvertently logout the user's session

    // Email Verification Notice
    Route::get('/email/verify', [AuthController::class, 'verifyNotice'])->name('verification.notice');
    // Email Verification Handler
    Route::get('/email/verify/{id}/{hash}', [AuthController::class, 'verifyEmail'])->middleware('signed')->name('verification.verify');
    // Resending the Verification Email
    Route::post('/email/verification-notification', [AuthController::class, 'verifyHandler'])->middleware('throttle:6,1')->name('verification.send');

    Route::middleware('verified')->group(function () {

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

        // Route to edit User Profile
        Route::get('dashboard/profile/{user}', [ProfileController::class, 'index'])->name('user.profile');

        // Admin Middleware Group
        Route::middleware('admin')->group(function () {

            // Route to admin dashboard posts
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
    });
});
