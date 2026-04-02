{{-- resources/views/readonly/timbangan/show.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail Timbangan') }}
            </h2>
            <a href="{{ route('readonly.timbangan.index') }}"
                class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Informasi Timbangan -->
                        <div class="border rounded-lg p-4">
                            <h3 class="font-semibold text-lg mb-4 text-gray-700">Informasi Timbangan</h3>
                            <table class="w-full">
                                <tr>
                                    <td class="py-2 text-gray-600 w-1/3">Nomor Urut</td>
                                    <td class="py-2 font-medium">: {{ $timbangan->nomor_urut }}</td>
                                </tr>
                                <tr>
                                    <td class="py-2 text-gray-600">Hari</td>
                                    <td class="py-2 font-medium">: {{ $timbangan->hari }}</td>
                                </tr>
                                <tr>
                                    <td class="py-2 text-gray-600">Tanggal</td>
                                    <td class="py-2 font-medium">: {{ $timbangan->tanggal->format('d/m/Y') }}</td>
                                </tr>
                                <tr>
                                    <td class="py-2 text-gray-600">Nomor Tiket</td>
                                    <td class="py-2 font-medium">: {{ $timbangan->nomor_tiket }}</td>
                                </tr>
                                <tr>
                                    <td class="py-2 text-gray-600">Nomor Polisi</td>
                                    <td class="py-2 font-medium">: {{ $timbangan->nopol }}</td>
                                </tr>
                                <tr>
                                    <td class="py-2 text-gray-600">Transporter</td>
                                    <td class="py-2 font-medium">: {{ $timbangan->transporter }}</td>
                                </tr>
                                <tr>
                                    <td class="py-2 text-gray-600">Customer</td>
                                    <td class="py-2 font-medium">: {{ $timbangan->nama_customer }}</td>
                                </tr>
                                <tr>
                                    <td class="py-2 text-gray-600">Barang</td>
                                    <td class="py-2 font-medium">: {{ $timbangan->nama_barang }}</td>
                                </tr>
                            </table>
                        </div>

                        <!-- Informasi Berat & Harga -->
                        <div class="border rounded-lg p-4">
                            <h3 class="font-semibold text-lg mb-4 text-gray-700">Informasi Berat & Harga</h3>
                            <table class="w-full">
                                <tr>
                                    <td class="py-2 text-gray-600 w-1/3">Gross</td>
                                    <td class="py-2 font-medium">: {{ number_format($timbangan->gross, 2) }} ton</td>
                                </tr>
                                <tr>
                                    <td class="py-2 text-gray-600">Tara</td>
                                    <td class="py-2 font-medium">: {{ number_format($timbangan->tara, 2) }} ton</td>
                                </tr>
                                <tr>
                                    <td class="py-2 text-gray-600">Netto</td>
                                    <td class="py-2 font-bold text-blue-600">:
                                        {{ number_format($timbangan->netto, 2) }} ton</td>
                                </tr>
                                <tr>
                                    <td class="py-2 text-gray-600">Status Jual</td>
                                    <td class="py-2">: {{ $timbangan->status_jual ? 'Jual' : 'Lainnya' }}</td>
                                </tr>
                                <tr>
                                    <td class="py-2 text-gray-600">Keterangan Lain</td>
                                    <td class="py-2">: {{ $timbangan->keterangan_lain ?? '-' }}</td>
                                </tr>
                                @if ($timbangan->harga_satuan)
                                    <tr>
                                        <td class="py-2 text-gray-600">Harga Satuan</td>
                                        <td class="py-2">: Rp
                                            {{ number_format($timbangan->harga_satuan, 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="py-2 text-gray-600">Total Harga</td>
                                        <td class="py-2 font-bold text-green-600">: Rp
                                            {{ number_format($timbangan->total_harga, 0, ',', '.') }}</td>
                                    </tr>
                                @endif
                            </table>
                        </div>
                    </div>

                    <!-- Informasi Pembuat -->
                    <div class="mt-6 border rounded-lg p-4">
                        <h3 class="font-semibold text-lg mb-4 text-gray-700">Informasi Pembuat</h3>
                        <table class="w-full">
                            <tr>
                                <td class="py-2 text-gray-600 w-1/6">Dibuat Oleh</td>
                                <td class="py-2 font-medium">: {{ $timbangan->user->name ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="py-2 text-gray-600">Tanggal Buat</td>
                                <td class="py-2">: {{ $timbangan->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                            @if ($timbangan->keterangan)
                                <tr>
                                    <td class="py-2 text-gray-600">Keterangan</td>
                                    <td class="py-2">: {{ $timbangan->keterangan }}</td>
                                </tr>
                            @endif
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
