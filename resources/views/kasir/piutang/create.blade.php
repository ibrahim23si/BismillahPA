{{-- resources/views/kasir/piutang/create.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Data Piutang') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-6">
                    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6">
                        <p class="text-sm text-yellow-700">
                            <strong>Catatan:</strong> Piutang biasanya dibuat otomatis dari transaksi Jual Material
                            dengan jenis Invoice.
                            Gunakan form ini untuk menambah piutang manual jika diperlukan.
                        </p>
                    </div>

                    <form method="POST" action="{{ route('kasir.piutang.store') }}">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Tanggal -->
                            <div>
                                <label for="tanggal" class="block text-sm font-medium text-gray-700">Tanggal Piutang
                                    <span class="text-red-500">*</span></label>
                                <input type="date" name="tanggal" id="tanggal"
                                    value="{{ old('tanggal', date('Y-m-d')) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                    required>
                                @error('tanggal')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Nama Debitur -->
                            <div>
                                <label for="nama_debitur" class="block text-sm font-medium text-gray-700">Nama Debitur
                                    <span class="text-red-500">*</span></label>
                                <input type="text" name="nama_debitur" id="nama_debitur"
                                    value="{{ old('nama_debitur') }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                    required>
                                @error('nama_debitur')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Jenis Transaksi -->
                            <div>
                                <label for="jenis_transaksi" class="block text-sm font-medium text-gray-700">Jenis
                                    Transaksi <span class="text-red-500">*</span></label>
                                <select name="jenis_transaksi" id="jenis_transaksi"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                    required>
                                    <option value="">Pilih Jenis</option>
                                    <option value="Batu Splite">Batu Splite</option>
                                    <option value="Batu Abu">Batu Abu</option>
                                    <option value="Base Ayakan">Base Ayakan</option>
                                    <option value="Batu Kotor">Batu Kotor</option>
                                    <option value="Lainnya">Lainnya</option>
                                </select>
                                @error('jenis_transaksi')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Tanggal Invoice -->
                            <div>
                                <label for="tanggal_invoice" class="block text-sm font-medium text-gray-700">Tanggal
                                    Invoice <span class="text-red-500">*</span></label>
                                <input type="date" name="tanggal_invoice" id="tanggal_invoice"
                                    value="{{ old('tanggal_invoice', date('Y-m-d')) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                    required>
                                @error('tanggal_invoice')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Nomor Invoice -->
                            <div>
                                <label for="nomor_invoice" class="block text-sm font-medium text-gray-700">Nomor
                                    Invoice</label>
                                <input type="text" name="nomor_invoice" id="nomor_invoice"
                                    value="{{ old('nomor_invoice') }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
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
                                        value="{{ old('nominal') }}"
                                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                        required>
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
                                    value="{{ old('tanggal_jatuh_tempo', date('Y-m-d', strtotime('+30 days'))) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                @error('tanggal_jatuh_tempo')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="flex justify-end space-x-2 mt-6">
                            <a href="{{ route('kasir.piutang.index') }}"
                                class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                Batal
                            </a>
                            <button type="submit"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
