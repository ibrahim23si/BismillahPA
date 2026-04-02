<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProduksiRawRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Hanya admin dan super admin yang bisa input produksi raw
        return auth()->user() && in_array(auth()->user()->role, ['admin', 'super_admin']);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'tanggal_produksi' => 'required|date|before_or_equal:today',
            'total_output' => 'required|numeric|min:0|max:999999.99',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            'keterangan' => 'nullable|string|max:500',
        ];

        // Jika update, tidak perlu validasi unique untuk tanggal (kecuali jika diperlukan)
        if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            // Tidak ada validasi unique khusus untuk update
        }

        return $rules;
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'tanggal_produksi.required' => 'Tanggal produksi wajib diisi',
            'tanggal_produksi.before_or_equal' => 'Tanggal produksi tidak boleh lebih dari hari ini',
            'total_output.required' => 'Total output wajib diisi',
            'total_output.numeric' => 'Total output harus berupa angka',
            'total_output.min' => 'Total output tidak boleh kurang dari 0',
            'jam_mulai.required' => 'Jam mulai operasi wajib diisi',
            'jam_mulai.date_format' => 'Format jam mulai tidak valid (gunakan format H:i)',
            'jam_selesai.required' => 'Jam selesai operasi wajib diisi',
            'jam_selesai.date_format' => 'Format jam selesai tidak valid (gunakan format H:i)',
            'jam_selesai.after' => 'Jam selesai harus setelah jam mulai',
            'keterangan.max' => 'Keterangan maksimal 500 karakter',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Bersihkan input dari karakter yang tidak diperlukan
        if ($this->has('total_output')) {
            $this->merge([
                'total_output' => str_replace(',', '.', $this->total_output)
            ]);
        }
    }
}