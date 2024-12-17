<?php

namespace App\Http\Requests\Post;

use Illuminate\Validation\Rule;
use App\Traits\Validation\HasPostFields;
use App\Http\Requests\Request;

class UpdatePostRequest extends Request
{
    use HasPostFields;
    
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        /**
         * Take advantage of the route model binding,
         * so to be able to access the resolved model as a property of the request
         */
        return $this->user()->can('update', $this->post);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'slug' => ['required', Rule::unique('posts')->ignore($this->post->id)],
        ];
    }
}
