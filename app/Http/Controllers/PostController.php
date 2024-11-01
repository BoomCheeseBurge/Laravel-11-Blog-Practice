<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        return view('posts', [
            'title' => 'Blog',
            'posts' => Post::with(['author', 'category'])->filter(request(['search', 'category', 'author']))->latest()->paginate(9)->withQueryString(),
        ]);
    }

    public function show(Post $post)
    {
        /**
         * Using Eloquent, the 'find' method will find a record based on ID by default.
         * The solution is to use route model binding.
         * In this case, the 'slug' column will be used.
         */
        return view('post', [
            'title' => 'Single Post',
            'post' => $post,
        ]);
    }
}
