<?php

namespace App\Http\Requests\Admin;

use App\Models\Cashier;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CashierUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $user_uuid = $this->route()->parameters();
        $cashier = Cashier::where('uuid', $user_uuid)->first();

        return [
            'name' => 'required',
            'username' => ['required', Rule::unique('cashiers')->ignore($cashier->id)],
        ];
    }
}
