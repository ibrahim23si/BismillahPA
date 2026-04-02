<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TargetRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Hanya super admin yang bisa mengelola target
        return auth()->user() && auth()->user()->role === 'super_admin';
    }

    public function rules(): array
    {
        return [
            'tipe' => 'required|in:produksi,penjualan',
            'periode' => 'required|in:harian,mingguan,bulanan',
            'tonase_target' => 'required|numeric|min:0|max:999999.99',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'keterangan' => 'nullable|string|max:500',
        ];
    }

    public function messages(): array
    {
        return [
            'tipe.required' => 'Tipe target wajib dipilih',
            'tipe.in' => 'Tipe target tidak valid',
            'periode.required' => 'Periode target wajib dipilih',
            'periode.in' => 'Periode target tidak valid',
            'tonase_target.required' => 'Tonase target wajib diisi',
            'tonase_target.numeric' => 'Tonase target harus berupa angka',
            'tonase_target.min' => 'Tonase target tidak boleh kurang dari 0',
            'tanggal_mulai.required' => 'Tanggal mulai wajib diisi',
            'tanggal_selesai.required' => 'Tanggal selesai wajib diisi',
            'tanggal_selesai.after_or_equal' => 'Tanggal selesai harus setelah atau sama dengan tanggal mulai',
        ];
    }

    protected function prepareForValidation(): void
    {
        if ($this->has('tonase_target')) {
            $this->merge([
                'tonase_target' => str_replace(',', '.', $this->tonase_target)
            ]);
        }
    }
}