<?php

namespace App\Http\Requests\Admin;

use App\Models\Store;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $user_uuid = $this->route()->parameters();
        $store = Store::where('uuid', $user_uuid)->first();

        return [
            'store_name' => 'required',
            'branch' => 'required',
            'username' => ['required', Rule::unique('stores')->ignore($store->id)],
        ];
    }
}
