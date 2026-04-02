{{-- resources/views/kasir/aju-kas/show.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail Pengajuan Kas') }}
            </h2>
            <a href="{{ route('kasir.aju-kas.index') }}"
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
                        {!! App\Helpers\Helper::getStatusBadge($aju->status) !!}

                        @if ($aju->status == 'approved' && $aju->approved_at)
                            <span class="ml-2 text-sm text-gray-600">
                                Disetujui oleh: {{ $aju->approver->name ?? '-' }} pada
                                {{ $aju->approved_at->format('d/m/Y H:i') }}
                            </span>
                        @endif

                        @if ($aju->status == 'rejected' && $aju->catatan_reject)
                            <div class="mt-2 p-3 bg-red-50 text-red-700 rounded">
                                <strong>Alasan Ditolak:</strong> {{ $aju->catatan_reject }}
                            </div>
                        @endif
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Informasi Pengajuan -->
                        <div class="border rounded-lg p-4">
                            <h3 class="font-semibold text-lg mb-4 text-gray-700">Informasi Pengajuan</h3>
                            <table class="w-full">
                                <tr>
                                    <td class="py-2 text-gray-600 w-1/3">No. Pengajuan</td>
                                    <td class="py-2 font-medium">: {{ $aju->nomor_pengajuan }}</td>
                                </tr>
                                <tr>
                                    <td class="py-2 text-gray-600">Tanggal</td>
                                    <td class="py-2 font-medium">: {{ $aju->tanggal->format('d/m/Y') }}</td>
                                </tr>
                                <tr>
                                    <td class="py-2 text-gray-600">Nominal</td>
                                    <td class="py-2 font-bold text-green-600">: Rp
                                        {{ number_format($aju->nominal, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <td class="py-2 text-gray-600">Keterangan</td>
                                    <td class="py-2">: {{ $aju->keterangan }}</td>
                                </tr>
                            </table>
                        </div>

                        <!-- Informasi Refund -->
                        <div class="border rounded-lg p-4">
                            <h3 class="font-semibold text-lg mb-4 text-gray-700">Informasi Refund</h3>
                            @if ($aju->tanggal_refund || $aju->nominal_refund)
                                <table class="w-full">
                                    <tr>
                                        <td class="py-2 text-gray-600 w-1/3">Tanggal Refund</td>
                                        <td class="py-2 font-medium">:
                                            {{ $aju->tanggal_refund ? $aju->tanggal_refund->format('d/m/Y') : '-' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="py-2 text-gray-600">Nominal Refund</td>
                                        <td class="py-2 font-medium">: Rp
                                            {{ $aju->nominal_refund ? number_format($aju->nominal_refund, 0, ',', '.') : '-' }}
                                        </td>
                                    </tr>
                                </table>
                            @else
                                <p class="text-gray-500 text-center py-4">Belum ada data refund</p>
                            @endif
                        </div>
                    </div>

                    <!-- Timeline -->
                    <div class="mt-6 border rounded-lg p-4">
                        <h3 class="font-semibold text-lg mb-4 text-gray-700">Timeline</h3>
                        <div class="space-y-3">
                            <div class="flex items-start">
                                <div class="flex-shrink-0 w-24 text-sm text-gray-500">
                                    {{ $aju->created_at->format('d/m/Y H:i') }}</div>
                                <div class="flex-grow">
                                    <p class="text-sm">Pengajuan dibuat oleh
                                        <strong>{{ $aju->creator->name ?? '-' }}</strong></p>
                                </div>
                            </div>

                            @if ($aju->approved_at)
                                <div class="flex items-start">
                                    <div class="flex-shrink-0 w-24 text-sm text-gray-500">
                                        {{ $aju->approved_at->format('d/m/Y H:i') }}</div>
                                    <div class="flex-grow">
                                        <p class="text-sm">
                                            @if ($aju->status == 'approved')
                                                Pengajuan <span class="text-green-600">disetujui</span> oleh
                                                <strong>{{ $aju->approver->name ?? '-' }}</strong>
                                            @elseif($aju->status == 'rejected')
                                                Pengajuan <span class="text-red-600">ditolak</span> oleh
                                                <strong>{{ $aju->approver->name ?? '-' }}</strong>
                                                @if ($aju->catatan_reject)
                                                    <br><span class="text-xs text-red-600">Catatan:
                                                        {{ $aju->catatan_reject }}</span>
                                                @endif
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Informasi Pembuat -->
                    <div class="mt-6 text-sm text-gray-500 border-t pt-4">
                        <p>Dibuat pada: {{ $aju->created_at->format('d/m/Y H:i') }}</p>
                        @if ($aju->updated_at != $aju->created_at)
                            <p>Terakhir diupdate: {{ $aju->updated_at->format('d/m/Y H:i') }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
