<?php

use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {

    return view('home', [
        'title' => 'Home',
    ]);
});

Route::get('/about', function () {

    return view('about', [
        'title' => 'About',
        'fullname' => 'John Doe',
    ]);
});

Route::get('/posts', function () {

    return view('posts', [
        'title' => 'Blog',
        'posts' => Post::with(['author', 'category'])->filter(request(['search', 'category', 'author']))->latest()->paginate(9)->withQueryString(),
    ]);
});

Route::get('/posts/{post:slug}', function (Post $post) {

    /**
     * Using Eloquent, the 'find' method will find a record based on ID by default.
     * The solution is to use route model binding.
     * In this case, the 'slug' column will be used.
     */
    return view('post', [
        'title' => 'Single Post',
        'post' => $post,
    ]);
});

Route::get('/authors/{user:username}', function (User $user) {

    $posts = $user->posts->load('author', 'category');

    return view('posts', [
        'title' => count($posts) . ' Posts written by ' . $user->fullname,
        'posts' => $posts,
    ]);
});

Route::get('/categories/{category:slug}', function (Category $category) {

    $posts = $category->posts->load('author', 'category');

    return view('posts', [
        'title' => 'Posts in ' . $category->name,
        'posts' => $posts,
    ]);
});

Route::get('/contact', function () {

    return view('contact', [
        'title' => 'Contact',
    ]);
});
