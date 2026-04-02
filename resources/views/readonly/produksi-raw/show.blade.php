{{-- resources/views/readonly/produksi-raw/show.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail Produksi Raw') }}
            </h2>
            <a href="{{ route('readonly.produksi-raw.index') }}"
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
                        <!-- Informasi Produksi -->
                        <div class="border rounded-lg p-4">
                            <h3 class="font-semibold text-lg mb-4 text-gray-700">Informasi Produksi</h3>
                            <table class="w-full">
                                <tr>
                                    <td class="py-2 text-gray-600 w-1/3">Tanggal Produksi</td>
                                    <td class="py-2 font-medium">: {{ $produksi->tanggal_produksi->format('d/m/Y') }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="py-2 text-gray-600">Total Output</td>
                                    <td class="py-2 font-medium">: {{ number_format($produksi->total_output, 2) }} ton
                                    </td>
                                </tr>
                                <tr>
                                    <td class="py-2 text-gray-600">Jam Mulai</td>
                                    <td class="py-2 font-medium">: {{ $produksi->jam_mulai_formatted }}</td>
                                </tr>
                                <tr>
                                    <td class="py-2 text-gray-600">Jam Selesai</td>
                                    <td class="py-2 font-medium">: {{ $produksi->jam_selesai_formatted }}</td>
                                </tr>
                                <tr>
                                    <td class="py-2 text-gray-600">Total Jam Operasional</td>
                                    <td class="py-2 font-medium">:
                                        {{ number_format($produksi->total_jam_operasional, 2) }} jam</td>
                                </tr>
                                <tr>
                                    <td class="py-2 text-gray-600">Produktivitas</td>
                                    <td class="py-2 font-bold text-blue-600">:
                                        {{ number_format($produksi->produktivitas_per_jam, 2) }} ton/jam</td>
                                </tr>
                                <tr>
                                    <td class="py-2 text-gray-600">Keterangan</td>
                                    <td class="py-2">: {{ $produksi->keterangan ?? '-' }}</td>
                                </tr>
                            </table>
                        </div>

                        <!-- Informasi Pembuat -->
                        <div class="border rounded-lg p-4">
                            <h3 class="font-semibold text-lg mb-4 text-gray-700">Informasi Pembuat</h3>
                            <table class="w-full">
                                <tr>
                                    <td class="py-2 text-gray-600 w-1/3">Dibuat Oleh</td>
                                    <td class="py-2 font-medium">: {{ $produksi->user->name ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="py-2 text-gray-600">Tanggal Buat</td>
                                    <td class="py-2">: {{ $produksi->created_at->format('d/m/Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <td class="py-2 text-gray-600">Terakhir Update</td>
                                    <td class="py-2">: {{ $produksi->updated_at->format('d/m/Y H:i') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
