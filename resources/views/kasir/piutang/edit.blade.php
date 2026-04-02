{{-- resources/views/kasir/piutang/edit.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Data Piutang') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-6">
                    @if ($piutang->isPaid())
                        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                            <p class="font-bold">Status: Lunas</p>
                            <p>Piutang ini sudah lunas pada
                                {{ $piutang->tanggal_bayar ? $piutang->tanggal_bayar->format('d/m/Y') : '-' }}</p>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('kasir.piutang.update', $piutang->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Tanggal -->
                            <div>
                                <label for="tanggal" class="block text-sm font-medium text-gray-700">Tanggal Piutang
                                    <span class="text-red-500">*</span></label>
                                <input type="date" name="tanggal" id="tanggal"
                                    value="{{ old('tanggal', $piutang->tanggal->format('Y-m-d')) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                    {{ $piutang->isPaid() ? 'readonly' : '' }} required>
                                @error('tanggal')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Nama Debitur -->
                            <div>
                                <label for="nama_debitur" class="block text-sm font-medium text-gray-700">Nama Debitur
                                    <span class="text-red-500">*</span></label>
                                <input type="text" name="nama_debitur" id="nama_debitur"
                                    value="{{ old('nama_debitur', $piutang->nama_debitur) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                    {{ $piutang->isPaid() ? 'readonly' : '' }} required>
                                @error('nama_debitur')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Jenis Transaksi -->
                            <div>
                                <label for="jenis_transaksi" class="block text-sm font-medium text-gray-700">Jenis
                                    Transaksi <span class="text-red-500">*</span></label>
                                <input type="text" name="jenis_transaksi" id="jenis_transaksi"
                                    value="{{ old('jenis_transaksi', $piutang->jenis_transaksi) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                    {{ $piutang->isPaid() ? 'readonly' : '' }} required>
                                @error('jenis_transaksi')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Tanggal Invoice -->
                            <div>
                                <label for="tanggal_invoice" class="block text-sm font-medium text-gray-700">Tanggal
                                    Invoice <span class="text-red-500">*</span></label>
                                <input type="date" name="tanggal_invoice" id="tanggal_invoice"
                                    value="{{ old('tanggal_invoice', $piutang->tanggal_invoice->format('Y-m-d')) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                    {{ $piutang->isPaid() ? 'readonly' : '' }} required>
                                @error('tanggal_invoice')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Nomor Invoice -->
                            <div>
                                <label for="nomor_invoice" class="block text-sm font-medium text-gray-700">Nomor
                                    Invoice</label>
                                <input type="text" name="nomor_invoice" id="nomor_invoice"
                                    value="{{ old('nomor_invoice', $piutang->nomor_invoice) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                    {{ $piutang->isPaid() ? 'readonly' : '' }}>
                                @error('nomor_invoice')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Nominal -->
                            <div>
                                <label for="nominal" class="block text-sm font-medium text-gray-700">Nominal Piutang
                                    <span class="text-red-500">*</span></label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">Rp</span>
                                    </div>
                                    <input type="number" step="0.01" name="nominal" id="nominal"
                                        value="{{ old('nominal', $piutang->nominal) }}"
                                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                        {{ $piutang->isPaid() ? 'readonly' : '' }} required>
                                </div>
                                @error('nominal')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Tanggal Jatuh Tempo -->
                            <div>
                                <label for="tanggal_jatuh_tempo" class="block text-sm font-medium text-gray-700">Tanggal
                                    Jatuh Tempo</label>
                                <input type="date" name="tanggal_jatuh_tempo" id="tanggal_jatuh_tempo"
                                    value="{{ old('tanggal_jatuh_tempo', $piutang->tanggal_jatuh_tempo ? $piutang->tanggal_jatuh_tempo->format('Y-m-d') : '') }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                    {{ $piutang->isPaid() ? 'readonly' : '' }}>
                                @error('tanggal_jatuh_tempo')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Form Pembayaran (Jika Belum Lunas) -->
                        @if (!$piutang->isPaid())
                            <div class="mt-6 p-4 border rounded-lg bg-gray-50">
                                <h3 class="font-semibold text-lg mb-4 text-gray-700">Penerimaan Pembayaran</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="tanggal_bayar"
                                            class="block text-sm font-medium text-gray-700">Tanggal Bayar</label>
                                        <input type="date" name="tanggal_bayar" id="tanggal_bayar"
                                            value="{{ old('tanggal_bayar', date('Y-m-d')) }}"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                    </div>

                                    <div>
                                        <label for="cash_bayar"
                                            class="block text-sm font-medium text-gray-700">Cash</label>
                                        <div class="mt-1 relative rounded-md shadow-sm">
                                            <div
                                                class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <span class="text-gray-500 sm:text-sm">Rp</span>
                                            </div>
                                            <input type="number" step="0.01" name="cash_bayar" id="cash_bayar"
                                                value="{{ old('cash_bayar') }}"
                                                class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                        </div>
                                    </div>

                                    <div>
                                        <label for="transfer_bayar"
                                            class="block text-sm font-medium text-gray-700">Transfer</label>
                                        <div class="mt-1 relative rounded-md shadow-sm">
                                            <div
                                                class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <span class="text-gray-500 sm:text-sm">Rp</span>
                                            </div>
                                            <input type="number" step="0.01" name="transfer_bayar"
                                                id="transfer_bayar" value="{{ old('transfer_bayar') }}"
                                                class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="flex justify-end space-x-2 mt-6">
                            <a href="{{ route('kasir.piutang.index') }}"
                                class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                Batal
                            </a>
                            <button type="submit"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                {{ $piutang->isPaid() ? 'Kembali' : 'Update & Proses Bayar' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
