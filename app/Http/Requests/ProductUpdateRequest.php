<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductUpdateRequest extends FormRequest
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
            'name'        => 'required|string|max:50',
            'description' => 'required|string|max:700',
            'image'       => 'nullable|mimes:png,jpg,jpeg,svg',
            'type_id'     => 'required|numeric',
            'price'       => 'required|numeric',
            'tags'        => 'array',
            'available'   => 'required|numeric|min:1',
        ];
    }

    public function messages(): array {
        return [
            'image.mimes' => 'Неверный формат изображения. Допустимые форматы: .png, .jpg, .jpeg, .svg'
        ];
    }
}
