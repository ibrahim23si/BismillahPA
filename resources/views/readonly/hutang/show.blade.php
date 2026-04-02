{{-- resources/views/readonly/hutang/show.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail Hutang') }}
            </h2>
            <a href="{{ route('readonly.hutang.index') }}"
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
                        {!! App\Helpers\Helper::getStatusBadge($hutang->status) !!}
                        @if ($hutang->over_due > 0 && !$hutang->isPaid())
                            <span class="ml-2 px-2 py-1 text-xs rounded-full bg-red-100 text-red-800">
                                Terlambat {{ $hutang->over_due }} hari
                            </span>
                        @endif
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Informasi Hutang -->
                        <div class="border rounded-lg p-4">
                            <h3 class="font-semibold text-lg mb-4 text-gray-700">Informasi Hutang</h3>
                            <table class="w-full">
                                <tr>
                                    <td class="py-2 text-gray-600 w-1/3">Tanggal</td>
                                    <td class="py-2 font-medium">: {{ $hutang->tanggal->format('d/m/Y') }}</td>
                                </tr>
                                <tr>
                                    <td class="py-2 text-gray-600">Kreditur</td>
                                    <td class="py-2 font-medium">: {{ $hutang->nama_kreditur }}</td>
                                </tr>
                                <tr>
                                    <td class="py-2 text-gray-600">Jenis Transaksi</td>
                                    <td class="py-2 font-medium">: {{ $hutang->jenis_transaksi }}</td>
                                </tr>
                                <tr>
                                    <td class="py-2 text-gray-600">Tanggal Invoice</td>
                                    <td class="py-2 font-medium">: {{ $hutang->tanggal_invoice->format('d/m/Y') }}</td>
                                </tr>
                                <tr>
                                    <td class="py-2 text-gray-600">Nomor Invoice</td>
                                    <td class="py-2 font-medium">: {{ $hutang->nomor_invoice ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="py-2 text-gray-600">Tanggal Jatuh Tempo</td>
                                    <td class="py-2 font-medium">:
                                        {{ $hutang->tanggal_jatuh_tempo ? $hutang->tanggal_jatuh_tempo->format('d/m/Y') : '-' }}
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <!-- Informasi Keuangan -->
                        <div class="border rounded-lg p-4">
                            <h3 class="font-semibold text-lg mb-4 text-gray-700">Informasi Keuangan</h3>
                            <table class="w-full">
                                <tr>
                                    <td class="py-2 text-gray-600 w-1/3">Nominal Hutang</td>
                                    <td class="py-2 font-bold">: Rp {{ number_format($hutang->nominal, 0, ',', '.') }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="py-2 text-gray-600">Sisa Hutang</td>
                                    <td class="py-2 font-bold text-red-600">: Rp
                                        {{ number_format($hutang->sisa, 0, ',', '.') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <!-- Informasi Pembayaran -->
                    @if ($hutang->tanggal_bayar || $hutang->cash_bayar || $hutang->transfer_bayar)
                        <div class="mt-6 border rounded-lg p-4">
                            <h3 class="font-semibold text-lg mb-4 text-gray-700">Informasi Pembayaran</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <table class="w-full">
                                        <tr>
                                            <td class="py-2 text-gray-600 w-1/3">Tanggal Bayar</td>
                                            <td class="py-2 font-medium">:
                                                {{ $hutang->tanggal_bayar ? $hutang->tanggal_bayar->format('d/m/Y') : '-' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="py-2 text-gray-600">Cash</td>
                                            <td class="py-2">: Rp
                                                {{ $hutang->cash_bayar ? number_format($hutang->cash_bayar, 0, ',', '.') : '-' }}
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div>
                                    <table class="w-full">
                                        <tr>
                                            <td class="py-2 text-gray-600 w-1/3">Transfer</td>
                                            <td class="py-2">: Rp
                                                {{ $hutang->transfer_bayar ? number_format($hutang->transfer_bayar, 0, ',', '.') : '-' }}
                                            </td>
                                        </tr>
                                        @if ($hutang->tanggal_giro)
                                            <tr>
                                                <td class="py-2 text-gray-600">Tanggal Giro</td>
                                                <td class="py-2">: {{ $hutang->tanggal_giro->format('d/m/Y') }}</td>
                                            </tr>
                                        @endif
                                        @if ($hutang->bank_giro)
                                            <tr>
                                                <td class="py-2 text-gray-600">Bank Giro</td>
                                                <td class="py-2">: {{ $hutang->bank_giro }}</td>
                                            </tr>
                                        @endif
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Informasi Pembuat -->
                    <div class="mt-6 border rounded-lg p-4">
                        <h3 class="font-semibold text-lg mb-4 text-gray-700">Informasi Pembuat</h3>
                        <table class="w-full">
                            <tr>
                                <td class="py-2 text-gray-600 w-1/6">Dibuat Oleh</td>
                                <td class="py-2 font-medium">: {{ $hutang->user->name ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="py-2 text-gray-600">Tanggal Buat</td>
                                <td class="py-2">: {{ $hutang->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
