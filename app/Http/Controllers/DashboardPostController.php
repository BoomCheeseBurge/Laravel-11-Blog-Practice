<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Rules\Title;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Http\RedirectResponse;
use Cviebrock\EloquentSluggable\Services\SlugService;

class DashboardPostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.posts.index', [
            'title' => 'Dashboard',
            'subTitle' => 'Dashboard Posts',
            'page' => 'posts',
            'posts' => Post::where('author_id', auth()->user()->id)->latest()->paginate(5),
            'headers' => ['Title', 'Slug', 'Category', 'DateCreated'],
            'columns' => ['title', 'slug', 'category', 'created_at'],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.posts.create', [
            'title' => 'Dashboard',
            'subTitle' => 'Create Post',
            'page' => 'createPost',
            'categories' => Category::select('name', 'id')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'title' => ['required', 'max:255', new Title],
            'slug' => 'required | unique:posts',
            'category_id' => 'required',
            'body' => 'required',
        ]);

        $validatedData['author_id'] = auth()->user()->id;

        Post::create($validatedData);

        return to_route('posts.index')->with('success', 'Post successfully created!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        if($post->author->id !== auth()->user()->id) {
            abort(403);
        }

        return view('dashboard.posts.show', [
            'title' => 'Single Post',
            'page' => 'singlePost',
            'post' => $post,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        if($post->author->id !== auth()->user()->id) {
            abort(403);
       }

        return view('dashboard.posts.edit', [
            'title' => 'Dashboard',
            'subTitle' => 'Edit Post',
            'page' => 'editPost',
            'post' => $post,
            'categories' => Category::select('name', 'id')->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        if($post->author->id !== auth()->user()->id) {
            abort(403);
        }

       $request->validate([
            'title' => ['required', 'max:255', new Title],
            'slug' => ['required', Rule::unique('posts')->ignore($post->id)],
            'category_id' => 'required',
            'body' => 'required',
        ]);

        $post->title = $request->input('title');
        $post->slug = $request->input('slug');
        $post->category_id = $request->input('category_id');
        $post->body = $request->input('body');

        $post->save();

        if(!$post->wasChanged())
        {
            return to_route('posts.index');
        }

        return to_route('posts.index')->with('success', 'Post successfully updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post): RedirectResponse
    {
        if($post->author->id !== auth()->user()->id) {
            abort(403);
        }

        $post->delete();

        return to_route('posts.index')->with('success', 'Post successfully deleted!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function checkSlug(String $val)
    {
        $slug = SlugService::createSlug(Post::class, 'slug', $val);

        return response()->json(['slug' => $slug]);
    }
}
