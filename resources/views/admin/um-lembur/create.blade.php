{{-- resources/views/admin/um-lembur/create.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Data UM & Lembur') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('admin.um-lembur.store') }}" id="umLemburForm">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                            <!-- Periode -->
                            <div>
                                <label for="periode" class="block text-sm font-medium text-gray-700">Periode <span class="text-red-500">*</span></label>
                                <input type="month" name="periode" id="periode" value="{{ old('periode', request('periode', date('Y-m'))) }}" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                    required>
                                @error('periode')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Nama -->
                            <div>
                                <label for="nama" class="block text-sm font-medium text-gray-700">Nama Karyawan <span class="text-red-500">*</span></label>
                                <select name="nama" id="nama" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                    required>
                                    <option value="">Pilih Nama</option>
                                    @foreach($karyawan as $k)
                                        <option value="{{ $k['nama'] }}" data-jabatan="{{ $k['jabatan'] }}" {{ old('nama') == $k['nama'] ? 'selected' : '' }}>
                                            {{ $k['nama'] }} - {{ $k['jabatan'] }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('nama')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Jabatan (auto fill) -->
                            <div>
                                <label for="jabatan" class="block text-sm font-medium text-gray-700">Jabatan <span class="text-red-500">*</span></label>
                                <input type="text" name="jabatan" id="jabatan" value="{{ old('jabatan') }}" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                    readonly required>
                                @error('jabatan')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Upah Per Jam -->
                            <div>
                                <label for="upah_per_jam" class="block text-sm font-medium text-gray-700">Upah per Jam <span class="text-red-500">*</span></label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">Rp</span>
                                    </div>
                                    <input type="number" step="0.01" name="upah_per_jam" id="upah_per_jam" value="{{ old('upah_per_jam', 20000) }}" 
                                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                        required>
                                </div>
                                @error('upah_per_jam')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Keterangan -->
                            <div class="md:col-span-3">
                                <label for="keterangan" class="block text-sm font-medium text-gray-700">Keterangan (Izin/Sakit, Tanggal Merah, dll)</label>
                                <textarea name="keterangan" id="keterangan" rows="2" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">{{ old('keterangan') }}</textarea>
                                @error('keterangan')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Tabel Input Jam Lembur Harian -->
                        <div class="mt-8">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Input Jam Lembur Harian</h3>
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200 border">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            @for($i = 1; $i <= 31; $i++)
                                                <th class="px-2 py-2 text-center text-xs font-medium text-gray-500 uppercase border">
                                                    {{ $i }}
                                                </th>
                                            @endfor
                                            <th class="px-2 py-2 text-center text-xs font-medium text-gray-500 uppercase border bg-blue-50">
                                                Total
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        <tr>
                                            @for($i = 1; $i <= 31; $i++)
                                                <td class="px-2 py-2 border">
                                                    <input type="number" step="0.5" min="0" max="24" name="hari_{{ $i }}" id="hari_{{ $i }}" value="{{ old('hari_' . $i, 0) }}"
                                                        class="hari-input w-16 text-center rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 text-sm"
                                                        onchange="hitungTotal()">
                                                </td>
                                            @endfor
                                            <td class="px-2 py-2 border bg-blue-50 text-center font-bold" id="total-jam-display">
                                                0 jam
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <p class="text-xs text-gray-500 mt-2">* Isi jam lembur per hari (maks 24 jam)</p>
                        </div>

                        <!-- Ringkasan -->
                        <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <span class="text-sm text-gray-600">Total Jam Lembur:</span>
                                    <span class="ml-2 text-lg font-bold text-blue-600" id="total-jam-text">0 jam</span>
                                </div>
                                <div>
                                    <span class="text-sm text-gray-600">Upah per Jam:</span>
                                    <span class="ml-2 text-lg font-bold text-green-600" id="upah-text">Rp 20.000</span>
                                </div>
                                <div>
                                    <span class="text-sm text-gray-600">Total Upah:</span>
                                    <span class="ml-2 text-lg font-bold text-purple-600" id="total-upah-text">Rp 0</span>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end space-x-2 mt-6">
                            <a href="{{ route('admin.um-lembur.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                Batal
                            </a>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
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
        // Auto fill jabatan based on nama
        document.getElementById('nama').addEventListener('change', function() {
            const selected = this.options[this.selectedIndex];
            const jabatan = selected.getAttribute('data-jabatan');
            document.getElementById('jabatan').value = jabatan || '';
        });

        // Trigger on page load if there's old value
        window.addEventListener('load', function() {
            const namaSelect = document.getElementById('nama');
            if (namaSelect.value) {
                const selected = namaSelect.options[namaSelect.selectedIndex];
                const jabatan = selected.getAttribute('data-jabatan');
                document.getElementById('jabatan').value = jabatan || '';
            }
            
            // Initial calculation
            hitungTotal();
        });

        function hitungTotal() {
            let totalJam = 0;
            
            // Sum all hari inputs
            for (let i = 1; i <= 31; i++) {
                const input = document.getElementById('hari_' + i);
                const value = parseFloat(input.value) || 0;
                totalJam += value;
            }
            
            // Update display
            document.getElementById('total-jam-display').innerText = totalJam.toFixed(2) + ' jam';
            document.getElementById('total-jam-text').innerText = totalJam.toFixed(2) + ' jam';
            
            // Calculate total upah
            const upahPerJam = parseFloat(document.getElementById('upah_per_jam').value) || 0;
            const totalUpah = totalJam * upahPerJam;
            
            document.getElementById('total-upah-text').innerText = 'Rp ' + totalUpah.toLocaleString('id-ID');
            
            // Update upah text
            document.getElementById('upah-text').innerText = 'Rp ' + upahPerJam.toLocaleString('id-ID');
        }

        // Add event listeners to all hari inputs
        for (let i = 1; i <= 31; i++) {
            document.getElementById('hari_' + i).addEventListener('input', hitungTotal);
        }
        
        document.getElementById('upah_per_jam').addEventListener('input', hitungTotal);
    </script>
    @endpush
</x-app-layout>