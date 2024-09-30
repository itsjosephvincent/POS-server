<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CashierStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'store_uuid' => 'required',
            'name' => 'required',
            'username' => ['required', Rule::unique('cashiers')],
            'password' => 'requssired',
        ];
    }
}
