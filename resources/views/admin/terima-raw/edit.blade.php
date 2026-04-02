{{-- resources/views/admin/terima-raw/edit.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Data Terima Raw') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('admin.terima-raw.update', $terima->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- Nomor Urut -->
                            <div>
                                <label for="nomor_urut" class="block text-sm font-medium text-gray-700">Nomor Urut <span
                                        class="text-red-500">*</span></label>
                                <input type="text" name="nomor_urut" id="nomor_urut"
                                    value="{{ old('nomor_urut', $terima->nomor_urut) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                    required>
                                @error('nomor_urut')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Hari -->
                            <div>
                                <label for="hari" class="block text-sm font-medium text-gray-700">Hari <span
                                        class="text-red-500">*</span></label>
                                <input type="number" name="hari" id="hari"
                                    value="{{ old('hari', $terima->hari) }}" min="1" max="31"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                    required>
                                @error('hari')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Tanggal -->
                            <div>
                                <label for="tanggal" class="block text-sm font-medium text-gray-700">Tanggal <span
                                        class="text-red-500">*</span></label>
                                <input type="date" name="tanggal" id="tanggal"
                                    value="{{ old('tanggal', $terima->tanggal->format('Y-m-d')) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                    required>
                                @error('tanggal')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Nomor Tiket -->
                            <div>
                                <label for="nomor_tiket" class="block text-sm font-medium text-gray-700">Nomor Tiket
                                    <span class="text-red-500">*</span></label>
                                <input type="text" name="nomor_tiket" id="nomor_tiket"
                                    value="{{ old('nomor_tiket', $terima->nomor_tiket) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                    required>
                                @error('nomor_tiket')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Nopol -->
                            <div>
                                <label for="nopol" class="block text-sm font-medium text-gray-700">Nomor Polisi <span
                                        class="text-red-500">*</span></label>
                                <input type="text" name="nopol" id="nopol"
                                    value="{{ old('nopol', $terima->nopol) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                    required>
                                @error('nopol')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Transporter -->
                            <div>
                                <label for="transporter" class="block text-sm font-medium text-gray-700">Transporter
                                    <span class="text-red-500">*</span></label>
                                <select name="transporter" id="transporter"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                    required>
                                    <option value="{{ old('transporter', $terima->transporter) }}" selected>{{ old('transporter', $terima->transporter) }}</option>
                                </select>
                                @error('transporter')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Nama Supplier -->
                            <div>
                                <label for="nama_supplier" class="block text-sm font-medium text-gray-700">Nama Supplier
                                    <span class="text-red-500">*</span></label>
                                <select name="nama_supplier" id="nama_supplier"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                    required>
                                    <option value="{{ old('nama_supplier', $terima->nama_supplier) }}" selected>{{ old('nama_supplier', $terima->nama_supplier) }}</option>
                                </select>
                                @error('nama_supplier')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Nama Barang -->
                            <div>
                                <label for="nama_barang" class="block text-sm font-medium text-gray-700">Nama Barang
                                    <span class="text-red-500">*</span></label>
                                <select name="nama_barang" id="nama_barang"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                    required>
                                    <option value="{{ old('nama_barang', $terima->nama_barang) }}" selected>{{ old('nama_barang', $terima->nama_barang) }}</option>
                                </select>
                                @error('nama_barang')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Gross -->
                            <div>
                                <label for="gross" class="block text-sm font-medium text-gray-700">Gross (Ton) <span
                                        class="text-red-500">*</span></label>
                                <input type="number" step="0.01" name="gross" id="gross"
                                    value="{{ old('gross', $terima->gross) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                    required>
                                @error('gross')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Tara -->
                            <div>
                                <label for="tara" class="block text-sm font-medium text-gray-700">Tara (Ton) <span
                                        class="text-red-500">*</span></label>
                                <input type="number" step="0.01" name="tara" id="tara"
                                    value="{{ old('tara', $terima->tara) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                    required>
                                @error('tara')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Netto (Readonly) -->
                            <div>
                                <label for="netto" class="block text-sm font-medium text-gray-700">Netto
                                    (Ton)</label>
                                <input type="text" id="netto" value="{{ number_format($terima->netto, 2) }}"
                                    readonly
                                    class="mt-1 block w-full rounded-md bg-gray-100 border-gray-300 shadow-sm">
                            </div>

                            <!-- Total Per Hari -->
                            <div>
                                <label for="total_per_hari" class="block text-sm font-medium text-gray-700">Total Per
                                    Hari</label>
                                <input type="number" step="0.01" name="total_per_hari" id="total_per_hari"
                                    value="{{ old('total_per_hari', $terima->total_per_hari) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                @error('total_per_hari')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="flex justify-end space-x-2 mt-6">
                            <a href="{{ route('admin.terima-raw.index') }}"
                                class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                Batal
                            </a>
                            <button type="submit"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Update
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function hitungNetto() {
                const gross = parseFloat(document.getElementById('gross').value) || 0;
                const tara = parseFloat(document.getElementById('tara').value) || 0;
                const netto = gross - tara;
                document.getElementById('netto').value = netto.toFixed(2);
            }

            document.getElementById('gross').addEventListener('input', hitungNetto);
            document.getElementById('tara').addEventListener('input', hitungNetto);

            // Select2 initialization
            function initSelect2(selector, url, placeholder) {
                $(selector).select2({
                    placeholder: placeholder,
                    allowClear: true,
                    width: '100%',
                    ajax: {
                        url: url,
                        dataType: 'json',
                        delay: 250,
                        data: function(params) {
                            return { q: params.term };
                        },
                        processResults: function(data) {
                            return { results: data };
                        },
                        cache: true
                    }
                });
            }

            initSelect2('#transporter', '{{ route("admin.master.transporters.list") }}', 'Cari transporter...');
            initSelect2('#nama_supplier', '{{ route("admin.master.suppliers.list") }}', 'Cari supplier...');
            initSelect2('#nama_barang', '{{ route("admin.master.barangs.list") }}', 'Cari nama barang...');
        </script>
    @endpush
</x-app-layout>
