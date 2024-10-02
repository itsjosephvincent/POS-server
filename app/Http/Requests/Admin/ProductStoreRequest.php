<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ProductStoreRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'category_uuid' => ['required', 'uuid'],
            'name' => 'required',
            'image_url' => ['sometimes', 'max:10240'],
            'cost' => ['required', 'decimal:1,999999.99'],
            'price' => ['required', 'decimal:1,999999.99'],
            'inventory' => ['required', 'integer'],
        ];
    }
}
