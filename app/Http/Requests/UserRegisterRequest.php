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
            'name' => ['required', 'string', 'max:100'],
            'tel' => ['required', 'string', 'regex:/^([0-9\s\-\+\(\)]*)$/', 'unique:App\Models\User,tel'],
            'password' => ['required', 'string', 'max:20', 'min:6'],
            'email' => ['required', 'string', 'email', 'unique:App\Models\User,email', 'max:100'],
        ];
    }

    public function messages(): array
    {
        return [
            'tel.unique'=> 'Этот номер уже занят',
            'email.unique'=> 'Эта почта уже занята',
        ];
    }
}
