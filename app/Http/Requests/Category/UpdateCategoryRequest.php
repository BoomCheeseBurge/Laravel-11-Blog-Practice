<?php

namespace App\Http\Requests\Category;

use Closure;
use App\Rules\Fullname;
use App\Models\Category;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Cviebrock\EloquentSluggable\Services\SlugService;

class UpdateCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        /**
         * Take advantage of the route model binding,
         * so to be able to access the resolved model as a property of the request
         */
        return $this->user()->can('update', $this->category);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'catName' => [ Rule::unique('categories', 'name')->ignore($this->category->id), 'max:50', new Fullname],
            'catColor' => [ Rule::unique('categories', 'color')->ignore($this->category->id), function (string $attribute, mixed $value, Closure $fail) {

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
            'image' => 'image | file | max:1024',
            'slug' => 'string',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'slug' => SlugService::createSlug(Category::class, 'slug', $this->catName),
        ]);
    }
}
