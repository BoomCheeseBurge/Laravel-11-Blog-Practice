<?php

use App\Models\Post;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home', [
        'title' => 'Home',
    ]);
});

Route::get('/about', function () {
    return view('about', [
        'title' => 'About',
        'name' => 'John Doe',
    ]);
});

Route::get('/posts', function () {
    return view('posts', [
        'title' => 'Blog',
        'posts' => Post::all(),
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

Route::get('/contact', function () {
    return view('contact', [
        'title' => 'Contact',
    ]);
});
