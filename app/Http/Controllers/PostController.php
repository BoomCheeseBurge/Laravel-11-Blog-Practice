<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\View\View;
use Illuminate\Contracts\Database\Eloquent\Builder;

class PostController extends Controller
{
    public function index(): View
    {
        return view('posts', [
            'title' => 'Blog',
            'posts' => Post::with(['author', 'category'])->filter(request(['search', 'category', 'author']))->latest()->paginate(9)->withQueryString(),
        ]);
    }

    public function show(Post $post): View
    {
        $post->load(['author', 'category']);
        
        /**
         * Using Eloquent, the 'find' method will find a record based on ID by default.
         * The solution is to use route model binding.
         * In this case, the 'slug' column will be used.
         */
        return view('post', [
            'title' => 'Single Post',
            'post' => $post,
            'related' => Post::with('category')->whereHas('category', function ($query) use ($post) {
                            $query->where('id', $post->category_id);
                        })
                        ->where('id', '!=', $post->id)
                        ->latest()->limit(4)->get(),
        ]);
    }
}
