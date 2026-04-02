{{-- resources/views/kasir/jual-material/edit.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Data Jual Material') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-6">
                    @if ($jual->status != 'pending')
                        <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-4" role="alert">
                            <p class="font-bold">Perhatian!</p>
                            <p>Data ini sudah diproses ({{ $jual->status }}). Beberapa field tidak dapat diubah.</p>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('kasir.jual-material.update', $jual->id) }}"
                        id="jualMaterialForm">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- Nomor Urut -->
                            <div>
                                <label for="nomor_urut" class="block text-sm font-medium text-gray-700">Nomor Urut <span
                                        class="text-red-500">*</span></label>
                                <input type="text" name="nomor_urut" id="nomor_urut"
                                    value="{{ old('nomor_urut', $jual->nomor_urut) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                    {{ $jual->status != 'pending' ? 'readonly' : '' }} required>
                                @error('nomor_urut')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Hari -->
                            <div>
                                <label for="hari" class="block text-sm font-medium text-gray-700">Hari <span
                                        class="text-red-500">*</span></label>
                                <input type="number" name="hari" id="hari"
                                    value="{{ old('hari', $jual->hari) }}" min="1" max="31"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                    {{ $jual->status != 'pending' ? 'readonly' : '' }} required>
                                @error('hari')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Tanggal -->
                            <div>
                                <label for="tanggal" class="block text-sm font-medium text-gray-700">Tanggal <span
                                        class="text-red-500">*</span></label>
                                <input type="date" name="tanggal" id="tanggal"
                                    value="{{ old('tanggal', $jual->tanggal->format('Y-m-d')) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                    {{ $jual->status != 'pending' ? 'readonly' : '' }} required>
                                @error('tanggal')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Nomor Tiket -->
                            <div>
                                <label for="nomor_tiket" class="block text-sm font-medium text-gray-700">Nomor Tiket
                                    <span class="text-red-500">*</span></label>
                                <input type="text" name="nomor_tiket" id="nomor_tiket"
                                    value="{{ old('nomor_tiket', $jual->nomor_tiket) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                    {{ $jual->status != 'pending' ? 'readonly' : '' }} required>
                                @error('nomor_tiket')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Nopol -->
                            <div>
                                <label for="nopol" class="block text-sm font-medium text-gray-700">Nomor Polisi <span
                                        class="text-red-500">*</span></label>
                                <input type="text" name="nopol" id="nopol"
                                    value="{{ old('nopol', $jual->nopol) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                    {{ $jual->status != 'pending' ? 'readonly' : '' }} required>
                                @error('nopol')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Transporter -->
                            <div>
                                <label for="transporter" class="block text-sm font-medium text-gray-700">Transporter
                                    <span class="text-red-500">*</span></label>
                                <input type="text" name="transporter" id="transporter"
                                    value="{{ old('transporter', $jual->transporter) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                    {{ $jual->status != 'pending' ? 'readonly' : '' }} required>
                                @error('transporter')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Nama Customer -->
                            <div>
                                <label for="nama_customer" class="block text-sm font-medium text-gray-700">Nama Customer
                                    <span class="text-red-500">*</span></label>
                                <input type="text" name="nama_customer" id="nama_customer"
                                    value="{{ old('nama_customer', $jual->nama_customer) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                    {{ $jual->status != 'pending' ? 'readonly' : '' }} required>
                                @error('nama_customer')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Nama Barang -->
                            <div>
                                <label for="nama_barang" class="block text-sm font-medium text-gray-700">Nama Barang
                                    <span class="text-red-500">*</span></label>
                                <input type="text" name="nama_barang" id="nama_barang"
                                    value="{{ old('nama_barang', $jual->nama_barang) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                    {{ $jual->status != 'pending' ? 'readonly' : '' }} required>
                                @error('nama_barang')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Gross -->
                            <div>
                                <label for="gross" class="block text-sm font-medium text-gray-700">Gross (Ton) <span
                                        class="text-red-500">*</span></label>
                                <input type="number" step="0.01" name="gross" id="gross"
                                    value="{{ old('gross', $jual->gross) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                    {{ $jual->status != 'pending' ? 'readonly' : '' }} required>
                                @error('gross')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Tara -->
                            <div>
                                <label for="tara" class="block text-sm font-medium text-gray-700">Tara (Ton) <span
                                        class="text-red-500">*</span></label>
                                <input type="number" step="0.01" name="tara" id="tara"
                                    value="{{ old('tara', $jual->tara) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                    {{ $jual->status != 'pending' ? 'readonly' : '' }} required>
                                @error('tara')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Netto (Readonly) -->
                            <div>
                                <label for="netto" class="block text-sm font-medium text-gray-700">Netto
                                    (Ton)</label>
                                <input type="text" id="netto" value="{{ number_format($jual->netto, 2) }}"
                                    readonly
                                    class="mt-1 block w-full rounded-md bg-gray-100 border-gray-300 shadow-sm">
                            </div>

                            <!-- Harga Satuan -->
                            <div>
                                <label for="harga_satuan" class="block text-sm font-medium text-gray-700">Harga Satuan
                                    <span class="text-red-500">*</span></label>
                                <input type="number" step="0.01" name="harga_satuan" id="harga_satuan"
                                    value="{{ old('harga_satuan', $jual->harga_satuan) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                    {{ $jual->status != 'pending' ? 'readonly' : '' }} required>
                                @error('harga_satuan')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Total Harga (Readonly) -->
                            <div>
                                <label for="total_harga" class="block text-sm font-medium text-gray-700">Total
                                    Harga</label>
                                <input type="text" id="total_harga"
                                    value="Rp {{ number_format($jual->total_harga, 0, ',', '.') }}" readonly
                                    class="mt-1 block w-full rounded-md bg-gray-100 border-gray-300 shadow-sm">
                            </div>

                            <!-- Jenis Bayar -->
                            <div>
                                <label for="jenis_bayar" class="block text-sm font-medium text-gray-700">Jenis
                                    Pembayaran</label>
                                <select name="jenis_bayar" id="jenis_bayar"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                    {{ $jual->status != 'pending' ? 'disabled' : '' }}>
                                    <option value="cash" {{ $jual->jenis_bayar == 'cash' ? 'selected' : '' }}>Cash
                                        (Tunai)</option>
                                    <option value="invoice" {{ $jual->jenis_bayar == 'invoice' ? 'selected' : '' }}>
                                        Invoice (Piutang)</option>
                                </select>
                                @error('jenis_bayar')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Invoice Fields -->
                            <div id="invoice-fields"
                                class="md:col-span-2 {{ $jual->jenis_bayar != 'invoice' ? 'hidden' : '' }}">
                                <div
                                    class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4 p-4 border rounded-lg bg-gray-50">
                                    <h3 class="md:col-span-2 font-medium text-gray-700">Informasi Invoice</h3>

                                    <div>
                                        <label for="nomor_bmk" class="block text-sm font-medium text-gray-700">Nomor
                                            BMK</label>
                                        <input type="text" name="nomor_bmk" id="nomor_bmk"
                                            value="{{ old('nomor_bmk', $jual->nomor_bmk) }}"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                            {{ $jual->status != 'pending' ? 'readonly' : '' }}>
                                    </div>

                                    <div>
                                        <label for="tanggal_bmk"
                                            class="block text-sm font-medium text-gray-700">Tanggal BMK</label>
                                        <input type="date" name="tanggal_bmk" id="tanggal_bmk"
                                            value="{{ old('tanggal_bmk', $jual->tanggal_bmk ? $jual->tanggal_bmk->format('Y-m-d') : '') }}"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                            {{ $jual->status != 'pending' ? 'readonly' : '' }}>
                                    </div>

                                    <div>
                                        <label for="nominal_bmk"
                                            class="block text-sm font-medium text-gray-700">Nominal BMK</label>
                                        <input type="number" step="0.01" name="nominal_bmk" id="nominal_bmk"
                                            value="{{ old('nominal_bmk', $jual->nominal_bmk) }}"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                            {{ $jual->status != 'pending' ? 'readonly' : '' }}>
                                    </div>

                                    <div>
                                        <label for="tanggal_jatuh_tempo"
                                            class="block text-sm font-medium text-gray-700">Tanggal Jatuh Tempo</label>
                                        <input type="date" name="tanggal_jatuh_tempo" id="tanggal_jatuh_tempo"
                                            value="{{ old('tanggal_jatuh_tempo', $jual->tanggal_jatuh_tempo ? $jual->tanggal_jatuh_tempo->format('Y-m-d') : '') }}"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                            {{ $jual->status != 'pending' ? 'readonly' : '' }}>
                                    </div>

                                    <div>
                                        <label for="nominal_tempo"
                                            class="block text-sm font-medium text-gray-700">Nominal Tempo</label>
                                        <input type="number" step="0.01" name="nominal_tempo" id="nominal_tempo"
                                            value="{{ old('nominal_tempo', $jual->nominal_tempo) }}"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                            {{ $jual->status != 'pending' ? 'readonly' : '' }}>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end space-x-2 mt-6">
                            <a href="{{ route('kasir.jual-material.index') }}"
                                class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                Batal
                            </a>
                            @if ($jual->status == 'pending')
                                <button type="submit"
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    Update
                                </button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // Toggle invoice fields based on payment type
            document.getElementById('jenis_bayar').addEventListener('change', function() {
                const invoiceFields = document.getElementById('invoice-fields');
                if (this.value === 'invoice') {
                    invoiceFields.classList.remove('hidden');
                } else {
                    invoiceFields.classList.add('hidden');
                }
            });
        </script>
    @endpush
</x-app-layout>
