<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $customerId = $this->route('customer');

        return [
            'name' => 'required|string|max:255|unique:customers,name,' . $customerId,
            'keterangan' => 'nullable|string|max:500',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama customer wajib diisi.',
            'name.unique' => 'Nama customer sudah ada.',
            'name.max' => 'Nama customer maksimal 255 karakter.',
        ];
    }
}
