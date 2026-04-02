<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HutangRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user() && in_array(auth()->user()->role, ['kasir', 'super_admin']);
    }

    public function rules(): array
    {
        $rules = [
            'tanggal' => 'required|date',
            'nama_kreditur' => 'required|string|max:100',
            'jenis_transaksi' => 'required|string|max:50',
            'tanggal_invoice' => 'required|date',
            'nomor_invoice' => 'nullable|string|max:50',
            'nominal' => 'required|numeric|min:0|max:999999999.99',
            'tanggal_jatuh_tempo' => 'nullable|date|after_or_equal:tanggal',
            'status' => 'sometimes|in:pending,approved,paid',
        ];

        // Untuk pembayaran
        if ($this->has('tanggal_bayar')) {
            $rules['tanggal_bayar'] = 'nullable|date';
            $rules['cash_bayar'] = 'nullable|numeric|min:0';
            $rules['transfer_bayar'] = 'nullable|numeric|min:0';
            $rules['tanggal_giro'] = 'nullable|date';
            $rules['bank_giro'] = 'nullable|string|max:50';
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'tanggal.required' => 'Tanggal hutang wajib diisi',
            'nama_kreditur.required' => 'Nama kreditur wajib diisi',
            'jenis_transaksi.required' => 'Jenis transaksi wajib diisi',
            'tanggal_invoice.required' => 'Tanggal invoice wajib diisi',
            'nominal.required' => 'Nominal hutang wajib diisi',
            'nominal.numeric' => 'Nominal harus berupa angka',
            'tanggal_jatuh_tempo.after_or_equal' => 'Tanggal jatuh tempo harus setelah atau sama dengan tanggal hutang',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'nominal' => str_replace(',', '.', $this->nominal ?? 0),
            'cash_bayar' => $this->cash_bayar ? str_replace(',', '.', $this->cash_bayar) : null,
            'transfer_bayar' => $this->transfer_bayar ? str_replace(',', '.', $this->transfer_bayar) : null,
        ]);

        // Hitung sisa pembayaran
        if ($this->has('cash_bayar') || $this->has('transfer_bayar')) {
            $totalBayar = ($this->cash_bayar ?? 0) + ($this->transfer_bayar ?? 0);
            $this->merge(['sisa' => ($this->nominal ?? 0) - $totalBayar]);
        }
    }
}