{{-- resources/views/kasir/jual-material/create.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Data Jual Material') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('kasir.jual-material.store') }}" id="jualMaterialForm">
                        @csrf

                        <!-- Nav Tabs -->
                        <div class="mb-6 border-b border-gray-200">
                            <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="jualTabs">
                                <li class="mr-2">
                                    <button type="button"
                                        class="inline-block p-4 border-b-2 border-blue-600 text-blue-600 rounded-t-lg active"
                                        id="tab-data-umum" data-tab="data-umum">
                                        Data Umum
                                    </button>
                                </li>
                                <li class="mr-2">
                                    <button type="button"
                                        class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300"
                                        id="tab-pembayaran" data-tab="pembayaran">
                                        Informasi Pembayaran
                                    </button>
                                </li>
                            </ul>
                        </div>

                        <!-- Tab Data Umum -->
                        <div id="data-umum" class="tab-content">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <!-- Nomor Urut -->
                                <div>
                                    <label for="nomor_urut" class="block text-sm font-medium text-gray-700">Nomor Urut
                                        <span class="text-red-500">*</span></label>
                                    <input type="text" name="nomor_urut" id="nomor_urut"
                                        value="{{ old('nomor_urut') }}"
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
                                        value="{{ old('hari', date('d')) }}" min="1" max="31"
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
                                        value="{{ old('tanggal', date('Y-m-d')) }}"
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
                                        value="{{ old('nomor_tiket') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                        required>
                                    @error('nomor_tiket')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Nopol -->
                                <div>
                                    <label for="nopol" class="block text-sm font-medium text-gray-700">Nomor Polisi
                                        <span class="text-red-500">*</span></label>
                                    <input type="text" name="nopol" id="nopol" value="{{ old('nopol') }}"
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
                                    <input type="text" name="transporter" id="transporter"
                                        value="{{ old('transporter') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                        required>
                                    @error('transporter')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Nama Customer -->
                                <div>
                                    <label for="nama_customer" class="block text-sm font-medium text-gray-700">Nama
                                        Customer <span class="text-red-500">*</span></label>
                                    <input type="text" name="nama_customer" id="nama_customer"
                                        value="{{ old('nama_customer') }}"
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
                                    <input type="text" name="nama_barang" id="nama_barang"
                                        value="{{ old('nama_barang') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                        required>
                                    @error('nama_barang')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Gross -->
                                <div>
                                    <label for="gross" class="block text-sm font-medium text-gray-700">Gross (Ton)
                                        <span class="text-red-500">*</span></label>
                                    <input type="number" step="0.01" name="gross" id="gross"
                                        value="{{ old('gross') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                        required>
                                    @error('gross')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Tara -->
                                <div>
                                    <label for="tara" class="block text-sm font-medium text-gray-700">Tara (Ton)
                                        <span class="text-red-500">*</span></label>
                                    <input type="number" step="0.01" name="tara" id="tara"
                                        value="{{ old('tara') }}"
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
                                    <input type="text" id="netto" readonly
                                        class="mt-1 block w-full rounded-md bg-gray-100 border-gray-300 shadow-sm">
                                </div>

                                <!-- Harga Satuan -->
                                <div>
                                    <label for="harga_satuan" class="block text-sm font-medium text-gray-700">Harga
                                        Satuan <span class="text-red-500">*</span></label>
                                    <input type="number" step="0.01" name="harga_satuan" id="harga_satuan"
                                        value="{{ old('harga_satuan') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                        required>
                                    @error('harga_satuan')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Total Harga (Readonly) -->
                                <div>
                                    <label for="total_harga" class="block text-sm font-medium text-gray-700">Total
                                        Harga</label>
                                    <input type="text" id="total_harga" readonly
                                        class="mt-1 block w-full rounded-md bg-gray-100 border-gray-300 shadow-sm">
                                </div>
                            </div>
                        </div>

                        <!-- Tab Pembayaran -->
                        <div id="pembayaran" class="tab-content hidden">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Jenis Bayar -->
                                <div>
                                    <label for="jenis_bayar" class="block text-sm font-medium text-gray-700">Jenis
                                        Pembayaran <span class="text-red-500">*</span></label>
                                    <select name="jenis_bayar" id="jenis_bayar"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                        required>
                                        <option value="cash">Cash (Tunai)</option>
                                        <option value="invoice">Invoice (Piutang)</option>
                                    </select>
                                    @error('jenis_bayar')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Invoice Fields (hidden by default) -->
                                <div id="invoice-fields" class="hidden md:col-span-2">
                                    <div
                                        class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4 p-4 border rounded-lg bg-gray-50">
                                        <h3 class="md:col-span-2 font-medium text-gray-700">Informasi Invoice</h3>

                                        <div>
                                            <label for="nomor_bmk"
                                                class="block text-sm font-medium text-gray-700">Nomor BMK</label>
                                            <input type="text" name="nomor_bmk" id="nomor_bmk"
                                                value="{{ old('nomor_bmk') }}"
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                            @error('nomor_bmk')
                                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div>
                                            <label for="tanggal_bmk"
                                                class="block text-sm font-medium text-gray-700">Tanggal BMK</label>
                                            <input type="date" name="tanggal_bmk" id="tanggal_bmk"
                                                value="{{ old('tanggal_bmk', date('Y-m-d')) }}"
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                            @error('tanggal_bmk')
                                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div>
                                            <label for="nominal_bmk"
                                                class="block text-sm font-medium text-gray-700">Nominal BMK</label>
                                            <input type="number" step="0.01" name="nominal_bmk" id="nominal_bmk"
                                                value="{{ old('nominal_bmk') }}"
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                            @error('nominal_bmk')
                                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div>
                                            <label for="tanggal_jatuh_tempo"
                                                class="block text-sm font-medium text-gray-700">Tanggal Jatuh
                                                Tempo</label>
                                            <input type="date" name="tanggal_jatuh_tempo" id="tanggal_jatuh_tempo"
                                                value="{{ old('tanggal_jatuh_tempo', date('Y-m-d', strtotime('+30 days'))) }}"
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                            @error('tanggal_jatuh_tempo')
                                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div>
                                            <label for="nominal_tempo"
                                                class="block text-sm font-medium text-gray-700">Nominal Tempo</label>
                                            <input type="number" step="0.01" name="nominal_tempo"
                                                id="nominal_tempo" value="{{ old('nominal_tempo') }}"
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                            @error('nominal_tempo')
                                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end space-x-2 mt-6">
                            <a href="{{ route('kasir.jual-material.index') }}"
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

    @push('scripts')
        <script>
            // Tab switching
            document.querySelectorAll('[data-tab]').forEach(button => {
                button.addEventListener('click', () => {
                    const tabId = button.dataset.tab;

                    // Update tab buttons
                    document.querySelectorAll('[data-tab]').forEach(btn => {
                        btn.classList.remove('border-blue-600', 'text-blue-600');
                        btn.classList.add('border-transparent', 'text-gray-500');
                    });
                    button.classList.remove('border-transparent', 'text-gray-500');
                    button.classList.add('border-blue-600', 'text-blue-600');

                    // Show/hide tab content
                    document.querySelectorAll('.tab-content').forEach(content => {
                        content.classList.add('hidden');
                    });
                    document.getElementById(tabId).classList.remove('hidden');
                });
            });

            // Toggle invoice fields based on payment type
            document.getElementById('jenis_bayar').addEventListener('change', function() {
                const invoiceFields = document.getElementById('invoice-fields');
                if (this.value === 'invoice') {
                    invoiceFields.classList.remove('hidden');
                    // Set required attributes
                    document.getElementById('nomor_bmk').required = true;
                    document.getElementById('tanggal_bmk').required = true;
                    document.getElementById('nominal_bmk').required = true;
                    document.getElementById('tanggal_jatuh_tempo').required = true;
                    document.getElementById('nominal_tempo').required = true;
                } else {
                    invoiceFields.classList.add('hidden');
                    // Remove required attributes
                    document.getElementById('nomor_bmk').required = false;
                    document.getElementById('tanggal_bmk').required = false;
                    document.getElementById('nominal_bmk').required = false;
                    document.getElementById('tanggal_jatuh_tempo').required = false;
                    document.getElementById('nominal_tempo').required = false;
                }
            });

            // Calculate netto and total
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

                // Auto-fill nominal tempo if empty
                const nominalTempo = document.getElementById('nominal_tempo');
                if (nominalTempo && !nominalTempo.value) {
                    nominalTempo.value = total;
                }
            }

            document.getElementById('gross').addEventListener('input', hitungNetto);
            document.getElementById('tara').addEventListener('input', hitungNetto);
            document.getElementById('harga_satuan').addEventListener('input', hitungTotalHarga);
        </script>
    @endpush
</x-app-layout>
