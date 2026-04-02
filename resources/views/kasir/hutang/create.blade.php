{{-- resources/views/kasir/hutang/create.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Data Hutang') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('kasir.hutang.store') }}">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Tanggal -->
                            <div>
                                <label for="tanggal" class="block text-sm font-medium text-gray-700">Tanggal Hutang
                                    <span class="text-red-500">*</span></label>
                                <input type="date" name="tanggal" id="tanggal"
                                    value="{{ old('tanggal', date('Y-m-d')) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                    required>
                                @error('tanggal')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Nama Kreditur -->
                            <div>
                                <label for="nama_kreditur" class="block text-sm font-medium text-gray-700">Nama Kreditur
                                    <span class="text-red-500">*</span></label>
                                <input type="text" name="nama_kreditur" id="nama_kreditur"
                                    value="{{ old('nama_kreditur') }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                    required>
                                @error('nama_kreditur')
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
                                    <option value="Timbangan">Timbangan</option>
                                    <option value="Solar">Solar</option>
                                    <option value="Gaji">Gaji</option>
                                    <option value="Service">Service</option>
                                    <option value="Sparepart">Sparepart</option>
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
                                <label for="nominal" class="block text-sm font-medium text-gray-700">Nominal Hutang
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
                                    value="{{ old('tanggal_jatuh_tempo') }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                @error('tanggal_jatuh_tempo')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="flex justify-end space-x-2 mt-6">
                            <a href="{{ route('kasir.hutang.index') }}"
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
