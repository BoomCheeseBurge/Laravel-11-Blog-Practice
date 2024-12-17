<?php

namespace App\Http\Requests\Category;

use App\Rules\Fullname;
use App\Models\Category;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Cviebrock\EloquentSluggable\Services\SlugService;

class StoreCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('create', Category::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // Store the available category colors (whether already used or not)
        $colors = [
            "slate", "gray", "zinc", "neutral", "stone",
            "red", "orange", "amber", "yellow", "lime",
            "green", "emerald", "teal", "cyan", "sky",
            "blue", "indigo", "violet", "purple", "fuchsia",
            "pink", "rose"
        ];

        return [
            'name' => ['required', 'unique:categories', 'max:50', new Fullname],
            'color' => [ 'required', Rule::unique('categories', 'color'), Rule::in($colors)],
            'image' => 'required | image | file | max:1024',
            'slug' => 'required | string',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'slug' => SlugService::createSlug(Category::class, 'slug', $this->name),
        ]);
    }
}
