{{-- resources/views/readonly/terima-raw/show.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail Terima Raw') }}
            </h2>
            <a href="{{ route('readonly.terima-raw.index') }}"
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
                        <!-- Informasi Terima Raw -->
                        <div class="border rounded-lg p-4">
                            <h3 class="font-semibold text-lg mb-4 text-gray-700">Informasi Terima Raw</h3>
                            <table class="w-full">
                                <tr>
                                    <td class="py-2 text-gray-600 w-1/3">Nomor Urut</td>
                                    <td class="py-2 font-medium">: {{ $terima->nomor_urut }}</td>
                                </tr>
                                <tr>
                                    <td class="py-2 text-gray-600">Hari</td>
                                    <td class="py-2 font-medium">: {{ $terima->hari }}</td>
                                </tr>
                                <tr>
                                    <td class="py-2 text-gray-600">Tanggal</td>
                                    <td class="py-2 font-medium">: {{ $terima->tanggal->format('d/m/Y') }}</td>
                                </tr>
                                <tr>
                                    <td class="py-2 text-gray-600">Nomor Tiket</td>
                                    <td class="py-2 font-medium">: {{ $terima->nomor_tiket }}</td>
                                </tr>
                                <tr>
                                    <td class="py-2 text-gray-600">Nomor Polisi</td>
                                    <td class="py-2 font-medium">: {{ $terima->nopol }}</td>
                                </tr>
                                <tr>
                                    <td class="py-2 text-gray-600">Transporter</td>
                                    <td class="py-2 font-medium">: {{ $terima->transporter }}</td>
                                </tr>
                                <tr>
                                    <td class="py-2 text-gray-600">Supplier</td>
                                    <td class="py-2 font-medium">: {{ $terima->nama_supplier }}</td>
                                </tr>
                                <tr>
                                    <td class="py-2 text-gray-600">Barang</td>
                                    <td class="py-2 font-medium">: {{ $terima->nama_barang }}</td>
                                </tr>
                            </table>
                        </div>

                        <!-- Informasi Berat -->
                        <div class="border rounded-lg p-4">
                            <h3 class="font-semibold text-lg mb-4 text-gray-700">Informasi Berat</h3>
                            <table class="w-full">
                                <tr>
                                    <td class="py-2 text-gray-600 w-1/3">Gross</td>
                                    <td class="py-2 font-medium">: {{ number_format($terima->gross, 2) }} ton</td>
                                </tr>
                                <tr>
                                    <td class="py-2 text-gray-600">Tara</td>
                                    <td class="py-2 font-medium">: {{ number_format($terima->tara, 2) }} ton</td>
                                </tr>
                                <tr>
                                    <td class="py-2 text-gray-600">Netto</td>
                                    <td class="py-2 font-bold text-blue-600">: {{ number_format($terima->netto, 2) }}
                                        ton</td>
                                </tr>
                                @if ($terima->total_per_hari)
                                    <tr>
                                        <td class="py-2 text-gray-600">Total Per Hari</td>
                                        <td class="py-2 font-medium">: {{ number_format($terima->total_per_hari, 2) }}
                                            ton</td>
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
                                <td class="py-2 font-medium">: {{ $terima->user->name ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="py-2 text-gray-600">Tanggal Buat</td>
                                <td class="py-2">: {{ $terima->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
