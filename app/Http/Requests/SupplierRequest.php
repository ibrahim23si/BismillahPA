<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SupplierRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('supplier');

        return [
            'nama' => 'required|string|max:255|unique:suppliers,nama,' . $id,
            'alamat' => 'nullable|string',
            'telepon' => 'nullable|string|max:20',
            'keterangan' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'nama.required' => 'Nama supplier wajib diisi.',
            'nama.unique' => 'Nama supplier sudah ada.',
            'nama.max' => 'Nama supplier maksimal 255 karakter.',
        ];
    }
}
