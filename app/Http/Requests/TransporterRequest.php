<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransporterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('transporter');

        return [
            'nama' => 'required|string|max:255|unique:transporters,nama,' . $id,
            'keterangan' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'nama.required' => 'Nama transporter wajib diisi.',
            'nama.unique' => 'Nama transporter sudah ada.',
            'nama.max' => 'Nama transporter maksimal 255 karakter.',
        ];
    }
}
