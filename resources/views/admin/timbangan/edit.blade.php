{{-- resources/views/admin/timbangan/edit.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Data Timbangan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('admin.timbangan.update', $timbangan->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- Nomor Urut -->
                            <div>
                                <label for="nomor_urut" class="block text-sm font-medium text-gray-700">Nomor Urut <span
                                        class="text-red-500">*</span></label>
                                <input type="text" name="nomor_urut" id="nomor_urut"
                                    value="{{ old('nomor_urut', $timbangan->nomor_urut) }}"
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
                                    value="{{ old('hari', $timbangan->hari) }}" min="1" max="31"
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
                                    value="{{ old('tanggal', $timbangan->tanggal->format('Y-m-d')) }}"
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
                                    value="{{ old('nomor_tiket', $timbangan->nomor_tiket) }}"
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
                                    value="{{ old('nopol', $timbangan->nopol) }}"
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
                                    <option value="{{ old('transporter', $timbangan->transporter) }}" selected>{{ old('transporter', $timbangan->transporter) }}</option>
                                </select>
                                @error('transporter')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Nama Customer -->
                            <div>
                                <label for="nama_customer" class="block text-sm font-medium text-gray-700">Nama Customer
                                    <span class="text-red-500">*</span></label>
                                <input type="text" name="nama_customer" id="nama_customer"
                                    value="{{ old('nama_customer', $timbangan->nama_customer) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                    required>
                                @error('nama_customer')
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
                                    <option value="{{ old('nama_barang', $timbangan->nama_barang) }}" selected>{{ old('nama_barang', $timbangan->nama_barang) }}</option>
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
                                    value="{{ old('gross', $timbangan->gross) }}"
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
                                    value="{{ old('tara', $timbangan->tara) }}"
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
                                <input type="text" id="netto"
                                    value="{{ number_format($timbangan->netto, 2) }}" readonly
                                    class="mt-1 block w-full rounded-md bg-gray-100 border-gray-300 shadow-sm">
                            </div>

                            <!-- Status Jual -->
                            <div>
                                <label for="status_jual" class="block text-sm font-medium text-gray-700">Status
                                    Jual</label>
                                <select name="status_jual" id="status_jual"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                    <option value="1"
                                        {{ old('status_jual', $timbangan->status_jual) == 1 ? 'selected' : '' }}>Jual
                                    </option>
                                    <option value="0"
                                        {{ old('status_jual', $timbangan->status_jual) == 0 ? 'selected' : '' }}>
                                        Lainnya</option>
                                </select>
                                @error('status_jual')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Keterangan Lain -->
                            <div>
                                <label for="keterangan_lain"
                                    class="block text-sm font-medium text-gray-700">Keterangan Lain</label>
                                <input type="text" name="keterangan_lain" id="keterangan_lain"
                                    value="{{ old('keterangan_lain', $timbangan->keterangan_lain) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                @error('keterangan_lain')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Harga Satuan -->
                            <div>
                                <label for="harga_satuan" class="block text-sm font-medium text-gray-700">Harga
                                    Satuan</label>
                                <input type="number" step="0.01" name="harga_satuan" id="harga_satuan"
                                    value="{{ old('harga_satuan', $timbangan->harga_satuan) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                @error('harga_satuan')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Total Harga (Readonly) -->
                            <div>
                                <label for="total_harga" class="block text-sm font-medium text-gray-700">Total
                                    Harga</label>
                                <input type="text" id="total_harga"
                                    value="{{ $timbangan->total_harga ? 'Rp ' . number_format($timbangan->total_harga, 0, ',', '.') : '-' }}"
                                    readonly
                                    class="mt-1 block w-full rounded-md bg-gray-100 border-gray-300 shadow-sm">
                            </div>

                            <!-- Keterangan -->
                            <div class="md:col-span-3">
                                <label for="keterangan"
                                    class="block text-sm font-medium text-gray-700">Keterangan</label>
                                <textarea name="keterangan" id="keterangan" rows="2"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">{{ old('keterangan', $timbangan->keterangan) }}</textarea>
                                @error('keterangan')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="flex justify-end space-x-2 mt-6">
                            <a href="{{ route('admin.timbangan.index') }}"
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
                hitungTotalHarga();
            }

            function hitungTotalHarga() {
                const netto = parseFloat(document.getElementById('netto').value) || 0;
                const harga = parseFloat(document.getElementById('harga_satuan').value) || 0;
                const total = netto * harga;
                document.getElementById('total_harga').value = total > 0 ? 'Rp ' + total.toLocaleString('id-ID') : '-';
            }

            document.getElementById('gross').addEventListener('input', hitungNetto);
            document.getElementById('tara').addEventListener('input', hitungNetto);
            document.getElementById('harga_satuan').addEventListener('input', hitungTotalHarga);

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
            initSelect2('#nama_barang', '{{ route("admin.master.barangs.list") }}', 'Cari nama barang...');
        </script>
    @endpush
</x-app-layout>
