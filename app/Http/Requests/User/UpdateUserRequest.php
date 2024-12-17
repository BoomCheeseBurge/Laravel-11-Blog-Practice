<?php

namespace App\Http\Requests\User;

use App\Http\Requests\Request;
use Illuminate\Validation\Rule;
use App\Traits\Validation\HasUserFields;
use Illuminate\Validation\Rules\Password;

class UpdateUserRequest extends Request
{
    use HasUserFields;
    
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        /**
         * Take advantage of the route model binding,
         * so to be able to access the resolved model as a property of the request
         */
        return $this->user()->can('update', $this->user);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'username' => ['required', 'min:3', 'max:255', Rule::unique('users')->ignore($this->user->id)],
            'email' => ['required', 'email:dns', Rule::unique('users')->ignore($this->user->id)],
            'password' => ['nullable', 'confirmed:confirmPassword', 'max:255', Password::defaults()],
            'is_admin' => 'nullable',
        ];
    }
}
