<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class KeluarMaterialRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
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
            'nomor_urut' => 'required|string|max:20',
            'hari' => 'required|integer|between:1,31',
            'tanggal' => 'required|date',
            'nomor_tiket' => [
                'required',
                'string',
                'max:50',
                Rule::unique('keluar_material')->ignore($this->route('keluar_material')),
            ],
            'nopol' => 'required|string|max:15',
            'transporter' => 'required|string|max:50',
            'nama_customer' => 'required|string|max:100',
            'nama_barang' => 'required|string|max:100',
            'gross' => 'required|numeric|min:0|max:999999.99',
            'tara' => 'required|numeric|min:0|max:999999.99|lte:gross',
            'harga_satuan' => 'nullable|numeric|min:0|max:999999999.99',
            'keterangan' => 'nullable|string|max:500',
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
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'gross' => str_replace(',', '.', $this->gross ?? 0),
            'tara' => str_replace(',', '.', $this->tara ?? 0),
            'harga_satuan' => $this->harga_satuan ? str_replace(',', '.', $this->harga_satuan) : null,
        ]);
    }
}