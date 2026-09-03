<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title'         => ['required', 'string', 'max:255'],
            'author'        => ['required', 'string', 'max:255'],
            'description'   => ['required', 'string'],
            'stock'         => ['required', 'integer', 'min:0'],
            'price'         => ['required', 'numeric', 'min:0'],
            'category_id'   => ['required', 'exists:categories,id'],
            'image_path'         => ['nullable', 'image', 'max:2048'],
        ];
    }
}
