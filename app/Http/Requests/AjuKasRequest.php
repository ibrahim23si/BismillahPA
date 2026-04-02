<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AjuKasRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user() && in_array(auth()->user()->role, ['kasir', 'super_admin']);
    }

    public function rules(): array
    {
        $rules = [
            'tanggal' => 'required|date',
            'keterangan' => 'required|string|min:5|max:500',
            'nominal' => 'required|numeric|min:1000|max:999999999.99',
        ];

        // Untuk update (hanya super admin yang bisa update status)
        if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            $rules['status'] = 'sometimes|in:pending,approved,rejected';
            $rules['catatan_reject'] = 'required_if:status,rejected|nullable|string|max:500';
            $rules['tanggal_refund'] = 'nullable|date';
            $rules['nominal_refund'] = 'nullable|numeric|min:0|max:' . ($this->nominal ?? 0);
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'tanggal.required' => 'Tanggal pengajuan wajib diisi',
            'keterangan.required' => 'Keterangan wajib diisi',
            'keterangan.min' => 'Keterangan minimal 5 karakter',
            'keterangan.max' => 'Keterangan maksimal 500 karakter',
            'nominal.required' => 'Nominal wajib diisi',
            'nominal.numeric' => 'Nominal harus berupa angka',
            'nominal.min' => 'Nominal minimal Rp 1.000',
            'catatan_reject.required_if' => 'Catatan penolakan wajib diisi jika status ditolak',
            'nominal_refund.max' => 'Nominal refund tidak boleh melebihi nominal pengajuan',
        ];
    }

    protected function prepareForValidation(): void
    {
        if ($this->has('nominal')) {
            $this->merge([
                'nominal' => str_replace(',', '.', $this->nominal)
            ]);
        }

        if ($this->has('nominal_refund')) {
            $this->merge([
                'nominal_refund' => str_replace(',', '.', $this->nominal_refund)
            ]);
        }
    }
}