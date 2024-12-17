<?php

namespace App\Http\Requests\Post;

use App\Models\Post;
use App\Traits\Validation\HasPostFields;
use App\Http\Requests\Request;

class StorePostRequest extends Request
{
    use HasPostFields;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('create', Post::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'slug' => 'required | unique:posts',
        ];
    }
}
