{{-- resources/views/kasir/jual-material/show.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail Jual Material') }}
            </h2>
            <a href="{{ route('kasir.jual-material.index') }}"
                class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-6">
                    <!-- Status Badge -->
                    <div class="mb-6 flex justify-between items-center">
                        <div>
                            <span class="text-sm text-gray-600">Status:</span>
                            {!! App\Helpers\Helper::getStatusBadge($jual->status) !!}

                            @if ($jual->status == 'approved' && $jual->approved_at)
                                <span class="ml-2 text-sm text-gray-600">
                                    Disetujui oleh: {{ $jual->approver->name ?? '-' }} pada
                                    {{ $jual->approved_at->format('d/m/Y H:i') }}
                                </span>
                            @endif

                            @if ($jual->status == 'rejected' && $jual->catatan_reject)
                                <div class="mt-2 p-3 bg-red-50 text-red-700 rounded">
                                    <strong>Alasan Ditolak:</strong> {{ $jual->catatan_reject }}
                                </div>
                            @endif
                        </div>

                        @if ($jual->status == 'pending')
                            <span class="text-sm text-yellow-600">Menunggu persetujuan Super Admin</span>
                        @endif
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Informasi Transaksi -->
                        <div class="border rounded-lg p-4">
                            <h3 class="font-semibold text-lg mb-4 text-gray-700">Informasi Transaksi</h3>
                            <table class="w-full">
                                <tr>
                                    <td class="py-2 text-gray-600 w-1/3">No. Transaksi</td>
                                    <td class="py-2 font-medium">: {{ $jual->nomor_transaksi }}</td>
                                </tr>
                                <tr>
                                    <td class="py-2 text-gray-600">No. Urut</td>
                                    <td class="py-2 font-medium">: {{ $jual->nomor_urut }}</td>
                                </tr>
                                <tr>
                                    <td class="py-2 text-gray-600">Hari</td>
                                    <td class="py-2 font-medium">: {{ $jual->hari }}</td>
                                </tr>
                                <tr>
                                    <td class="py-2 text-gray-600">Tanggal</td>
                                    <td class="py-2 font-medium">: {{ $jual->tanggal->format('d/m/Y') }}</td>
                                </tr>
                                <tr>
                                    <td class="py-2 text-gray-600">No. Tiket</td>
                                    <td class="py-2 font-medium">: {{ $jual->nomor_tiket }}</td>
                                </tr>
                                <tr>
                                    <td class="py-2 text-gray-600">No. Polisi</td>
                                    <td class="py-2 font-medium">: {{ $jual->nopol }}</td>
                                </tr>
                                <tr>
                                    <td class="py-2 text-gray-600">Transporter</td>
                                    <td class="py-2 font-medium">: {{ $jual->transporter }}</td>
                                </tr>
                                <tr>
                                    <td class="py-2 text-gray-600">Customer</td>
                                    <td class="py-2 font-medium">: {{ $jual->nama_customer }}</td>
                                </tr>
                                <tr>
                                    <td class="py-2 text-gray-600">Barang</td>
                                    <td class="py-2 font-medium">: {{ $jual->nama_barang }}</td>
                                </tr>
                            </table>
                        </div>

                        <!-- Informasi Berat & Harga -->
                        <div class="border rounded-lg p-4">
                            <h3 class="font-semibold text-lg mb-4 text-gray-700">Informasi Berat & Harga</h3>
                            <table class="w-full">
                                <tr>
                                    <td class="py-2 text-gray-600 w-1/3">Gross</td>
                                    <td class="py-2 font-medium">: {{ number_format($jual->gross, 2) }} ton</td>
                                </tr>
                                <tr>
                                    <td class="py-2 text-gray-600">Tara</td>
                                    <td class="py-2 font-medium">: {{ number_format($jual->tara, 2) }} ton</td>
                                </tr>
                                <tr>
                                    <td class="py-2 text-gray-600">Netto</td>
                                    <td class="py-2 font-medium text-blue-600">: {{ number_format($jual->netto, 2) }}
                                        ton</td>
                                </tr>
                                <tr>
                                    <td class="py-2 text-gray-600">Harga Satuan</td>
                                    <td class="py-2 font-medium">: Rp
                                        {{ number_format($jual->harga_satuan, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <td class="py-2 text-gray-600">Total Harga</td>
                                    <td class="py-2 font-bold text-green-600">: Rp
                                        {{ number_format($jual->total_harga, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <td class="py-2 text-gray-600">Jenis Bayar</td>
                                    <td class="py-2">
                                        : @if ($jual->jenis_bayar == 'cash')
                                            <span
                                                class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Cash</span>
                                        @else
                                            <span
                                                class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800">Invoice</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <!-- Informasi Invoice (Jika ada) -->
                    @if ($jual->jenis_bayar == 'invoice')
                        <div class="mt-6 border rounded-lg p-4">
                            <h3 class="font-semibold text-lg mb-4 text-gray-700">Informasi Invoice</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <table class="w-full">
                                        <tr>
                                            <td class="py-2 text-gray-600 w-1/3">Nomor BMK</td>
                                            <td class="py-2 font-medium">: {{ $jual->nomor_bmk ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="py-2 text-gray-600">Tanggal BMK</td>
                                            <td class="py-2 font-medium">:
                                                {{ $jual->tanggal_bmk ? $jual->tanggal_bmk->format('d/m/Y') : '-' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="py-2 text-gray-600">Nominal BMK</td>
                                            <td class="py-2 font-medium">: Rp
                                                {{ $jual->nominal_bmk ? number_format($jual->nominal_bmk, 0, ',', '.') : '-' }}
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div>
                                    <table class="w-full">
                                        <tr>
                                            <td class="py-2 text-gray-600 w-1/3">Jatuh Tempo</td>
                                            <td class="py-2 font-medium">:
                                                {{ $jual->tanggal_jatuh_tempo ? $jual->tanggal_jatuh_tempo->format('d/m/Y') : '-' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="py-2 text-gray-600">Nominal Tempo</td>
                                            <td class="py-2 font-medium">: Rp
                                                {{ $jual->nominal_tempo ? number_format($jual->nominal_tempo, 0, ',', '.') : '-' }}
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Informasi Pembuat -->
                    <div class="mt-6 text-sm text-gray-500 border-t pt-4">
                        <p>Dibuat oleh: {{ $jual->creator->name ?? '-' }} pada
                            {{ $jual->created_at->format('d/m/Y H:i') }}</p>
                        @if ($jual->updated_at != $jual->created_at)
                            <p>Terakhir diupdate: {{ $jual->updated_at->format('d/m/Y H:i') }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
