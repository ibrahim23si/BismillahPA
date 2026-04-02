{{-- resources/views/readonly/keluar-material/show.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail Keluar Material') }}
            </h2>
            <a href="{{ route('readonly.keluar-material.index') }}"
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
                        <!-- Informasi Keluar Material -->
                        <div class="border rounded-lg p-4">
                            <h3 class="font-semibold text-lg mb-4 text-gray-700">Informasi Keluar Material</h3>
                            <table class="w-full">
                                <tr>
                                    <td class="py-2 text-gray-600 w-1/3">Nomor Urut</td>
                                    <td class="py-2 font-medium">: {{ $material->nomor_urut }}</td>
                                </tr>
                                <tr>
                                    <td class="py-2 text-gray-600">Hari</td>
                                    <td class="py-2 font-medium">: {{ $material->hari }}</td>
                                </tr>
                                <tr>
                                    <td class="py-2 text-gray-600">Tanggal</td>
                                    <td class="py-2 font-medium">: {{ $material->tanggal->format('d/m/Y') }}</td>
                                </tr>
                                <tr>
                                    <td class="py-2 text-gray-600">Nomor Tiket</td>
                                    <td class="py-2 font-medium">: {{ $material->nomor_tiket }}</td>
                                </tr>
                                <tr>
                                    <td class="py-2 text-gray-600">Nomor Polisi</td>
                                    <td class="py-2 font-medium">: {{ $material->nopol }}</td>
                                </tr>
                                <tr>
                                    <td class="py-2 text-gray-600">Transporter</td>
                                    <td class="py-2 font-medium">: {{ $material->transporter }}</td>
                                </tr>
                                <tr>
                                    <td class="py-2 text-gray-600">Customer</td>
                                    <td class="py-2 font-medium">: {{ $material->nama_customer }}</td>
                                </tr>
                                <tr>
                                    <td class="py-2 text-gray-600">Barang</td>
                                    <td class="py-2 font-medium">: {{ $material->nama_barang }}</td>
                                </tr>
                            </table>
                        </div>

                        <!-- Informasi Berat & Harga -->
                        <div class="border rounded-lg p-4">
                            <h3 class="font-semibold text-lg mb-4 text-gray-700">Informasi Berat & Harga</h3>
                            <table class="w-full">
                                <tr>
                                    <td class="py-2 text-gray-600 w-1/3">Gross</td>
                                    <td class="py-2 font-medium">: {{ number_format($material->gross, 2) }} ton</td>
                                </tr>
                                <tr>
                                    <td class="py-2 text-gray-600">Tara</td>
                                    <td class="py-2 font-medium">: {{ number_format($material->tara, 2) }} ton</td>
                                </tr>
                                <tr>
                                    <td class="py-2 text-gray-600">Netto</td>
                                    <td class="py-2 font-bold text-blue-600">: {{ number_format($material->netto, 2) }}
                                        ton</td>
                                </tr>
                                @if ($material->harga_satuan)
                                    <tr>
                                        <td class="py-2 text-gray-600">Harga Satuan</td>
                                        <td class="py-2">: Rp
                                            {{ number_format($material->harga_satuan, 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="py-2 text-gray-600">Total Harga</td>
                                        <td class="py-2 font-bold text-green-600">: Rp
                                            {{ number_format($material->total_harga, 0, ',', '.') }}</td>
                                    </tr>
                                @endif
                            </table>
                        </div>
                    </div>

                    <!-- Informasi Pembuat & Keterangan -->
                    <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="border rounded-lg p-4">
                            <h3 class="font-semibold text-lg mb-4 text-gray-700">Informasi Pembuat</h3>
                            <table class="w-full">
                                <tr>
                                    <td class="py-2 text-gray-600 w-1/3">Dibuat Oleh</td>
                                    <td class="py-2 font-medium">: {{ $material->user->name ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="py-2 text-gray-600">Tanggal Buat</td>
                                    <td class="py-2">: {{ $material->created_at->format('d/m/Y H:i') }}</td>
                                </tr>
                            </table>
                        </div>

                        @if ($material->keterangan)
                            <div class="border rounded-lg p-4">
                                <h3 class="font-semibold text-lg mb-4 text-gray-700">Keterangan</h3>
                                <p class="text-gray-700">{{ $material->keterangan }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
