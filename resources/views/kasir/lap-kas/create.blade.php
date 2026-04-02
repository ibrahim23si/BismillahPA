{{-- resources/views/kasir/lap-kas/create.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Entri Manual Laporan Kas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-6">
                    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-yellow-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linecap="round"
                                        d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-yellow-700">
                                    <strong>Perhatian:</strong> Entri manual digunakan untuk saldo awal, setoran awal,
                                    atau koreksi.
                                    Untuk transaksi penjualan dan pengajuan kas, gunakan menu yang sudah disediakan.
                                </p>
                            </div>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('kasir.lap-kas.store') }}">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
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

                            <!-- Keterangan -->
                            <div class="md:col-span-2">
                                <label for="keterangan" class="block text-sm font-medium text-gray-700">Keterangan <span
                                        class="text-red-500">*</span></label>
                                <input type="text" name="keterangan" id="keterangan" value="{{ old('keterangan') }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                    required>
                                @error('keterangan')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Debet (Pemasukan) -->
                            <div>
                                <label for="debet" class="block text-sm font-medium text-gray-700">Debet
                                    (Pemasukan)</label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">Rp</span>
                                    </div>
                                    <input type="number" step="0.01" name="debet" id="debet"
                                        value="{{ old('debet') }}"
                                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 {{ $errors->has('debet') ? 'border-red-500' : '' }}"
                                        placeholder="Masukkan pemasukan">
                                </div>
                                @error('debet')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                                <p class="text-xs text-gray-500 mt-1" id="debet-hint">Isi jika ada pemasukan</p>
                            </div>

                            <!-- Kredit (Pengeluaran) -->
                            <div>
                                <label for="kredit" class="block text-sm font-medium text-gray-700">Kredit
                                    (Pengeluaran)</label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">Rp</span>
                                    </div>
                                    <input type="number" step="0.01" name="kredit" id="kredit"
                                        value="{{ old('kredit') }}"
                                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 {{ $errors->has('kredit') ? 'border-red-500' : '' }}"
                                        placeholder="Masukkan pengeluaran">
                                </div>
                                @error('kredit')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                                <p class="text-xs text-gray-500 mt-1" id="kredit-hint">Isi jika ada pengeluaran</p>
                            </div>
                        </div>

                        <div class="flex justify-end space-x-2 mt-6">
                            <a href="{{ route('kasir.lap-kas.index') }}"
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
            // Ambil elemen
            const debetInput = document.getElementById('debet');
            const kreditInput = document.getElementById('kredit');

            // Fungsi untuk memformat angka (opsional, biar lebih rapi)
            function formatAngka(angka) {
                return angka.replace(/[^0-9]/g, '');
            }

            // Event untuk debet
            debetInput.addEventListener('input', function() {
                // Hanya reset kredit jika debet diisi
                if (this.value && this.value !== '0') {
                    kreditInput.value = '';
                    // Hapus error styling jika ada
                    kreditInput.classList.remove('border-red-500');
                }
            });

            // Event untuk kredit
            kreditInput.addEventListener('input', function() {
                // Hanya reset debet jika kredit diisi
                if (this.value && this.value !== '0') {
                    debetInput.value = '';
                    debetInput.classList.remove('border-red-500');
                }
            });

            // Validasi sebelum submit
            document.querySelector('form').addEventListener('submit', function(e) {
                const debet = parseFloat(debetInput.value) || 0;
                const kredit = parseFloat(kreditInput.value) || 0;

                // Jika kedua-duanya diisi (seharusnya tidak terjadi, tapi jaga-jaga)
                if (debet > 0 && kredit > 0) {
                    e.preventDefault();
                    alert('Hanya boleh mengisi salah satu: Debet atau Kredit, tidak keduanya!');
                    return false;
                }

                // Jika keduanya kosong
                if (debet === 0 && kredit === 0) {
                    e.preventDefault();
                    alert('Harap isi Debet atau Kredit!');
                    return false;
                }
            });
        </script>
    @endpush
</x-app-layout>
