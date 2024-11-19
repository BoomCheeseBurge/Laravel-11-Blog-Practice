<?php

namespace App\Http\Controllers;

use Closure;
use App\Models\Post;
use App\Rules\Search;
use App\Rules\Fullname;
use App\Models\Category;
use App\Actions\CheckSlug;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Http\RedirectResponse;
use Cviebrock\EloquentSluggable\Services\SlugService;

class AdminCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Store the available category colors (whether already used or not)
        $colors = [
            "Slate", "Gray", "Zinc", "Neutral", "Stone",
            "Red", "Orange", "Amber", "Yellow", "Lime",
            "Green", "Emerald", "Teal", "Cyan", "Sky",
            "Blue", "Indigo", "Violet", "Purple", "Fuchsia",
            "Pink", "Rose"
        ];

        // Convert the collection to an associative array
        $catColors = Category::all()->pluck('color')->toArray();

        $adminCats = Category::latest(); // Base Eloquent query

        // Check for a search keyword input
        if(request()->has('search'))
        {
            // Validate the search input
            $keyword = request()->validate([
                'search' => ['max:50', new Search],
            ])['search'];

            // Search by keyword input or empty string by default
            $adminCats = $adminCats->whereAny(['name', 'color'], 'like', '%'. $keyword .'%');
        }

        $perPage = request()->perPage ?? 10; // Get the pagination number or a default

        return view('admin.categories.index', [
            'title' => 'Admin',
            'subTitle' => 'Admin Categories',
            'page' => 'categories',
            'categories' => $adminCats->paginate(5),
            'headers' => ['No', 'Name', 'Slug', 'Color', 'Date Created', 'Action'],
            'columns' => ['name', 'slug', 'color', 'created_at'],
            'colors' => $colors,
            'catColors' => $catColors,
            'perPage' => $perPage,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Store the available category colors (whether already used or not)
        $colors = [
            "slate", "gray", "zinc", "neutral", "stone",
            "red", "orange", "amber", "yellow", "lime",
            "green", "emerald", "teal", "cyan", "sky",
            "blue", "indigo", "violet", "purple", "fuchsia",
            "pink", "rose"
        ];

        $validatedData = $request->validate([
            'name' => ['required', 'unique:categories', 'max:50', new Fullname],
            'color' => [ 'required', Rule::unique('categories', 'color'), Rule::in($colors)],
        ]);

        $validatedData['slug'] = SlugService::createSlug(Category::class, 'slug', $validatedData['name']);

        Category::create($validatedData);

        return to_route('categories.index')->with('success', 'Category successfully created!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category): RedirectResponse
    {
        return to_route('blog.posts', ['category' => $category->slug]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category, CheckSlug $checkSlug)
    {
        $validatedData = $request->validate([
            'catName' => [ Rule::unique('categories', 'name')->ignore($category->id), 'max:50', new Fullname],
            'catColor' => [ Rule::unique('categories', 'color')->ignore($category->id), function (string $attribute, mixed $value, Closure $fail) {

                                // Store the available category colors (whether already used or not)
                                $colors = [
                                    "slate", "gray", "zinc", "neutral", "stone",
                                    "red", "orange", "amber", "yellow", "lime",
                                    "green", "emerald", "teal", "cyan", "sky",
                                    "blue", "indigo", "violet", "purple", "fuchsia",
                                    "pink", "rose"
                                ];

                                if (!in_array($value, $colors)) {

                                    $fail("The value of {$attribute} is invalid.");
                                }
                            },
                        ],
        ]);

        $category->name = $validatedData['catName'];
        $category->color = $validatedData['catColor'];

        if($category->isDirty('name') && ($checkSlug->handle($validatedData['catName'], '-', $category->slug)))
        {
            $validatedData['slug'] = SlugService::createSlug(Category::class, 'slug', $validatedData['catName']);
            $category->slug = $validatedData['slug'];
        }

        $category->save();

        if(!$category->wasChanged())
        {
            return to_route('categories.index');
        }

        return to_route('categories.index')->with('success', 'Category successfully updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        // Find if there is existing post(s) associated with the category
        $match = Post::where('category_id', $category->id)->first();

        // Check if there was a match found from the query above
        if(isset($match))
        {
            // Return with the corresponding message
            return back()->with('fail', 'Category cannot be deleted due to existing post associations');
        }

        // Else, destroy the category model instance
        $category->delete();

        // Return to the previous page with a message
        return back()->with('success', 'Category successfully deleted!');
    }
}
