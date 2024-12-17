<?php

namespace App\Http\Requests\User;

use App\Models\User;
use App\Http\Requests\Request;
use App\Traits\Validation\HasUserFields;
use Illuminate\Validation\Rules\Password;

class StoreUserRequest extends Request
{
    use HasUserFields;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('create', User::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'username' => 'required | min:3 | max:255 | unique:users',
            'email' => 'required | email:dns | unique:users',
            'password' => ['required', 'max:255', Password::defaults()],
            'confirmPassword' => ['required', 'same:password'],
            'is_admin' => 'required',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'confirmPassword.same' => 'Password confirmation should match the original password',
        ];
    }
}
