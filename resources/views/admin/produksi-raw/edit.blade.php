{{-- resources/views/admin/produksi-raw/edit.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Data Produksi Raw') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('admin.produksi-raw.update', $produksi->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Tanggal Produksi -->
                            <div>
                                <label for="tanggal_produksi" class="block text-sm font-medium text-gray-700">Tanggal
                                    Produksi <span class="text-red-500">*</span></label>
                                <input type="date" name="tanggal_produksi" id="tanggal_produksi"
                                    value="{{ old('tanggal_produksi', $produksi->tanggal_produksi->format('Y-m-d')) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                    required>
                                @error('tanggal_produksi')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Total Output -->
                            <div>
                                <label for="total_output" class="block text-sm font-medium text-gray-700">Total Output
                                    (Ton) <span class="text-red-500">*</span></label>
                                <input type="number" step="0.01" name="total_output" id="total_output"
                                    value="{{ old('total_output', $produksi->total_output) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                    required>
                                @error('total_output')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Jam Mulai -->
                            <div>
                                <label for="jam_mulai" class="block text-sm font-medium text-gray-700">Jam Mulai <span
                                        class="text-red-500">*</span></label>
                                <input type="time" name="jam_mulai" id="jam_mulai"
                                    value="{{ old('jam_mulai', substr($produksi->jam_mulai, 0, 5)) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                    required>
                                @error('jam_mulai')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Jam Selesai -->
                            <div>
                                <label for="jam_selesai" class="block text-sm font-medium text-gray-700">Jam Selesai
                                    <span class="text-red-500">*</span></label>
                                <input type="time" name="jam_selesai" id="jam_selesai"
                                    value="{{ old('jam_selesai', substr($produksi->jam_selesai, 0, 5)) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                    required>
                                @error('jam_selesai')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Keterangan -->
                            <div class="md:col-span-2">
                                <label for="keterangan" class="block text-sm font-medium text-gray-700">Keterangan
                                    (Downtime, dll)</label>
                                <textarea name="keterangan" id="keterangan" rows="3"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">{{ old('keterangan', $produksi->keterangan) }}</textarea>
                                @error('keterangan')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Preview Perhitungan -->
                        <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                            <h3 class="text-sm font-medium text-gray-700 mb-2">Preview Perhitungan</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <span class="text-xs text-gray-500">Total Jam Operasional:</span>
                                    <span class="ml-2 text-sm font-medium"
                                        id="previewJam">{{ $produksi->total_jam_operasional }} jam</span>
                                </div>
                                <div>
                                    <span class="text-xs text-gray-500">Produktivitas per Jam:</span>
                                    <span class="ml-2 text-sm font-medium"
                                        id="previewProduktivitas">{{ $produksi->produktivitas_per_jam }} ton/jam</span>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end space-x-2 mt-6">
                            <a href="{{ route('admin.produksi-raw.index') }}"
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
            function hitungPreview() {
                const jamMulai = document.getElementById('jam_mulai').value;
                const jamSelesai = document.getElementById('jam_selesai').value;
                const totalOutput = parseFloat(document.getElementById('total_output').value) || 0;

                if (jamMulai && jamSelesai) {
                    const mulai = new Date('1970-01-01T' + jamMulai + ':00');
                    const selesai = new Date('1970-01-01T' + jamSelesai + ':00');

                    if (selesai < mulai) {
                        selesai.setDate(selesai.getDate() + 1);
                    }

                    const selisihJam = (selesai - mulai) / (1000 * 60 * 60);
                    document.getElementById('previewJam').innerText = selisihJam.toFixed(2) + ' jam';

                    if (selisihJam > 0 && totalOutput > 0) {
                        const produktivitas = totalOutput / selisihJam;
                        document.getElementById('previewProduktivitas').innerText = produktivitas.toFixed(2) + ' ton/jam';
                    } else {
                        document.getElementById('previewProduktivitas').innerText = '0 ton/jam';
                    }
                }
            }

            document.getElementById('jam_mulai').addEventListener('change', hitungPreview);
            document.getElementById('jam_selesai').addEventListener('change', hitungPreview);
            document.getElementById('total_output').addEventListener('input', hitungPreview);
        </script>
    @endpush
</x-app-layout>
