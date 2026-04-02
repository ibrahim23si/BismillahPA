<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TerimaRawRequest extends FormRequest
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
                Rule::unique('terima_raw')->ignore($this->route('terima_raw')),
            ],
            'nopol' => 'required|string|max:15',
            'transporter' => 'required|string|max:50',
            'nama_supplier' => 'required|string|max:100',
            'nama_barang' => 'required|string|max:100',
            'gross' => 'required|numeric|min:0|max:999999.99',
            'tara' => 'required|numeric|min:0|max:999999.99|lte:gross',
            'total_per_hari' => 'nullable|numeric|min:0|max:999999.99',
        ];

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
            'nomor_urut.required' => 'Nomor urut wajib diisi',
            'hari.required' => 'Hari wajib diisi',
            'tanggal.required' => 'Tanggal wajib diisi',
            'nomor_tiket.required' => 'Nomor tiket wajib diisi',
            'nomor_tiket.unique' => 'Nomor tiket sudah digunakan',
            'nopol.required' => 'Nomor polisi wajib diisi',
            'transporter.required' => 'Nama transporter wajib diisi',
            'nama_supplier.required' => 'Nama supplier wajib diisi',
            'nama_barang.required' => 'Nama barang wajib diisi',
            'gross.required' => 'Berat gross wajib diisi',
            'gross.numeric' => 'Berat gross harus berupa angka',
            'tara.required' => 'Berat tara wajib diisi',
            'tara.numeric' => 'Berat tara harus berupa angka',
            'tara.lte' => 'Berat tara tidak boleh lebih dari gross',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'gross' => str_replace(',', '.', $this->gross ?? 0),
            'tara' => str_replace(',', '.', $this->tara ?? 0),
            'total_per_hari' => $this->total_per_hari ? str_replace(',', '.', $this->total_per_hari) : null,
        ]);
    }
}