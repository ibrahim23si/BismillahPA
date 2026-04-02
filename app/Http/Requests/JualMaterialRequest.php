<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class JualMaterialRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Kasir dan super admin yang bisa input jual material
        return auth()->user() && in_array(auth()->user()->role, ['kasir', 'super_admin']);
    }

    public function rules(): array
    {
        $rules = [
            'nomor_urut' => 'required|string|max:20',
            'hari' => 'required|integer|between:1,31',
            'tanggal' => 'required|date',
            'nomor_tiket' => [
                'required',
                'string',
                'max:50',
                Rule::unique('jual_material')->ignore($this->route('jual_material')),
            ],
            'nopol' => 'required|string|max:15',
            'transporter' => 'required|string|max:50',
            'nama_customer' => 'required|string|max:100',
            'nama_barang' => 'required|string|max:100',
            'gross' => 'required|numeric|min:0|max:999999.99',
            'tara' => 'required|numeric|min:0|max:999999.99|lte:gross',
            'harga_satuan' => 'required|numeric|min:0|max:999999999.99',
            
            // Validasi untuk jenis pembayaran
            'jenis_bayar' => 'required|in:cash,invoice',
            
            // Jika invoice, field berikut wajib diisi
            'nomor_bmk' => 'required_if:jenis_bayar,invoice|nullable|string|max:50',
            'tanggal_bmk' => 'required_if:jenis_bayar,invoice|nullable|date',
            'nominal_bmk' => 'required_if:jenis_bayar,invoice|nullable|numeric|min:0',
            'tanggal_jatuh_tempo' => 'required_if:jenis_bayar,invoice|nullable|date|after_or_equal:tanggal',
            'nominal_tempo' => 'required_if:jenis_bayar,invoice|nullable|numeric|min:0|max:' . ($this->total_harga ?? 0),
        ];

        return $rules;
    }

    public function messages(): array
    {
        return [
            'nomor_urut.required' => 'Nomor urut wajib diisi',
            'hari.required' => 'Hari wajib diisi',
            'tanggal.required' => 'Tanggal wajib diisi',
            'nomor_tiket.required' => 'Nomor tiket wajib diisi',
            'nomor_tiket.unique' => 'Nomor tiket sudah digunakan',
            'nopol.required' => 'Nomor polisi wajib diisi',
            'transporter.required' => 'Nama transporter wajib diisi',
            'nama_customer.required' => 'Nama customer wajib diisi',
            'nama_barang.required' => 'Nama barang wajib diisi',
            'gross.required' => 'Berat gross wajib diisi',
            'tara.required' => 'Berat tara wajib diisi',
            'tara.lte' => 'Berat tara tidak boleh lebih dari gross',
            'harga_satuan.required' => 'Harga satuan wajib diisi',
            'harga_satuan.numeric' => 'Harga satuan harus berupa angka',
            'jenis_bayar.required' => 'Jenis pembayaran wajib dipilih',
            'jenis_bayar.in' => 'Jenis pembayaran tidak valid',
            'nomor_bmk.required_if' => 'Nomor BMK wajib diisi untuk pembayaran invoice',
            'tanggal_bmk.required_if' => 'Tanggal BMK wajib diisi untuk pembayaran invoice',
            'nominal_bmk.required_if' => 'Nominal BMK wajib diisi untuk pembayaran invoice',
            'tanggal_jatuh_tempo.required_if' => 'Tanggal jatuh tempo wajib diisi untuk pembayaran invoice',
            'tanggal_jatuh_tempo.after_or_equal' => 'Tanggal jatuh tempo harus setelah atau sama dengan tanggal transaksi',
            'nominal_tempo.required_if' => 'Nominal tempo wajib diisi untuk pembayaran invoice',
            'nominal_tempo.max' => 'Nominal tempo tidak boleh melebihi total harga',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'gross' => str_replace(',', '.', $this->gross ?? 0),
            'tara' => str_replace(',', '.', $this->tara ?? 0),
            'harga_satuan' => str_replace(',', '.', $this->harga_satuan ?? 0),
            'nominal_bmk' => $this->nominal_bmk ? str_replace(',', '.', $this->nominal_bmk) : null,
            'nominal_tempo' => $this->nominal_tempo ? str_replace(',', '.', $this->nominal_tempo) : null,
        ]);

        // Hitung netto dan total harga
        if ($this->has('gross') && $this->has('tara')) {
            $netto = $this->gross - $this->tara;
            $this->merge(['netto' => $netto]);
            
            if ($this->has('harga_satuan')) {
                $this->merge(['total_harga' => $netto * $this->harga_satuan]);
            }
        }
    }
}