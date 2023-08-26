<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderStoreRequest extends FormRequest
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
            'type' => 'required|string|max:50',
            'city' => 'required|string|max:50',
            'street' => 'required|string|max:150',
            'house_number' => 'required|string|max:50',
            'flat_number' => 'string|max:50',
            'postal_code' => 'integer|max:6',
            'name' => 'required|string|max:50',
            'lastname' => 'required|string|max:50',
            'partonymic' => 'required|string|max:50',
        ];
    }
}
