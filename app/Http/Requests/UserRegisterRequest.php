<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:50'],
            'tel' => ['required', 'string', 'regex:/^([0-9\s\-\+\(\)]*)$/', 'unique:App\Models\User,tel', 'min:10', 'max:30'],
            'password' => ['required', 'string', 'max:20', 'min:6'],
            'email' => ['required', 'string', 'email', 'unique:App\Models\User,email', 'max:50'],
        ];
    }
}
