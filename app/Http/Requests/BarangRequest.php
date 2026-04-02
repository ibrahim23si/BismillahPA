<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BarangRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('barang');

        return [
            'nama' => 'required|string|max:255|unique:barangs,nama,' . $id,
            'satuan' => 'nullable|string|max:50',
            'keterangan' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'nama.required' => 'Nama barang wajib diisi.',
            'nama.unique' => 'Nama barang sudah ada.',
            'nama.max' => 'Nama barang maksimal 255 karakter.',
        ];
    }
}
