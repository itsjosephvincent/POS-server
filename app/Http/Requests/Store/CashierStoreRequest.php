<?php

namespace App\Http\Requests\Store;

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
            'name' => 'required',
            'username' => ['required', Rule::unique('cashiers')],
            'password' => 'required',
        ];
    }
}
