{{-- resources/views/readonly/jual-material/show.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail Jual Material') }}
            </h2>
            <a href="{{ route('readonly.jual-material.index') }}"
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
                    <div class="mb-6">
                        <span class="text-sm text-gray-600">Status:</span>
                        {!! App\Helpers\Helper::getStatusBadge($jual->status) !!}

                        @if ($jual->status == 'approved' && $jual->approved_at)
                            <span class="ml-2 text-sm text-gray-600">
                                Disetujui oleh: {{ $jual->approver->name ?? '-' }} pada
                                {{ $jual->approved_at->format('d/m/Y H:i') }}
                            </span>
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
                                    <td class="py-2 font-bold text-blue-600">: {{ number_format($jual->netto, 2) }} ton
                                    </td>
                                </tr>
                                <tr>
                                    <td class="py-2 text-gray-600">Harga Satuan</td>
                                    <td class="py-2">: Rp {{ number_format($jual->harga_satuan, 0, ',', '.') }}</td>
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
                    <div class="mt-6 border rounded-lg p-4">
                        <h3 class="font-semibold text-lg mb-4 text-gray-700">Informasi Pembuat</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <table class="w-full">
                                    <tr>
                                        <td class="py-2 text-gray-600 w-1/3">Dibuat Oleh</td>
                                        <td class="py-2 font-medium">: {{ $jual->creator->name ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="py-2 text-gray-600">Tanggal Buat</td>
                                        <td class="py-2">: {{ $jual->created_at->format('d/m/Y H:i') }}</td>
                                    </tr>
                                </table>
                            </div>
                            @if ($jual->approver)
                                <div>
                                    <table class="w-full">
                                        <tr>
                                            <td class="py-2 text-gray-600 w-1/3">Disetujui Oleh</td>
                                            <td class="py-2 font-medium">: {{ $jual->approver->name ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="py-2 text-gray-600">Tanggal Approve</td>
                                            <td class="py-2">:
                                                {{ $jual->approved_at ? $jual->approved_at->format('d/m/Y H:i') : '-' }}
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            @endif
                        </div>
                        @if ($jual->catatan_reject)
                            <div class="mt-4 p-3 bg-red-50 text-red-700 rounded">
                                <strong>Catatan Reject:</strong> {{ $jual->catatan_reject }}
                            </div>
                        @endif
                    </div>

                    <!-- Informasi Piutang Terkait -->
                    @if ($jual->piutang)
                        <div class="mt-6 border rounded-lg p-4">
                            <h3 class="font-semibold text-lg mb-4 text-gray-700">Informasi Piutang Terkait</h3>
                            <table class="w-full">
                                <tr>
                                    <td class="py-2 text-gray-600 w-1/6">Status Piutang</td>
                                    <td class="py-2">: {!! App\Helpers\Helper::getStatusBadge($jual->piutang->status) !!}</td>
                                </tr>
                                <tr>
                                    <td class="py-2 text-gray-600">Sisa Piutang</td>
                                    <td class="py-2 font-medium">: Rp
                                        {{ number_format($jual->piutang->sisa, 0, ',', '.') }}</td>
                                </tr>
                                @if ($jual->piutang->tanggal_bayar)
                                    <tr>
                                        <td class="py-2 text-gray-600">Tanggal Bayar</td>
                                        <td class="py-2">: {{ $jual->piutang->tanggal_bayar->format('d/m/Y') }}</td>
                                    </tr>
                                @endif
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
