<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Upload File Import Timbangan') }}
            </h2>
            <a href="{{ route('admin.timbangan.import.index') }}" 
               class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linecap="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <strong class="font-bold">Terjadi kesalahan!</strong>
                    <ul class="mt-2 list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Form Upload -->
                <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                    <div class="p-6">
                        <form action="{{ route('admin.timbangan.import.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-4">
                                <label for="file" class="block text-sm font-medium text-gray-700 mb-2">
                                    File Excel/CSV <span class="text-red-500">*</span>
                                </label>
                                <div class="flex items-center justify-center w-full">
                                    <label for="file" class="flex flex-col items-center justify-center w-full h-48 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100">
                                        <div class="flex flex-col items-center justify-center pt-5 pb-6" id="upload-area">
                                            <svg class="w-10 h-10 mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linecap="round" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                            </svg>
                                            <p class="mb-2 text-sm text-gray-500">
                                                <span class="font-semibold">Klik untuk upload</span> atau drag and drop
                                            </p>
                                            <p class="text-xs text-gray-500">XLSX, XLS, CSV (Maks. 10MB)</p>
                                            <p class="text-xs text-gray-500 mt-2" id="file-name"></p>
                                        </div>
                                        <input id="file" name="file" type="file" class="hidden" accept=".xlsx,.xls,.csv" />
                                    </label>
                                </div>
                                @error('file')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex justify-end">
                                <button type="submit" 
                                        class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linecap="round" d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M12 4v12m0 0l-4-4m4 4l4-4" />
                                    </svg>
                                    Upload & Proses
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Informasi -->
                <div class="space-y-6">
                    <!-- Alert Info -->
                    <div class="bg-blue-50 border-l-4 border-blue-400 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-blue-800">Informasi Penting</h3>
                                <div class="mt-2 text-sm text-blue-700">
                                    <ul class="list-disc list-inside space-y-1">
                                        <li>Download template terlebih dahulu untuk melihat format yang benar</li>
                                        <li>Pastikan kolom yang diisi sesuai dengan template</li>
                                        <li>transporter_id, customer_id, product_id harus sesuai dengan ID di database</li>
                                        <li>Proses import akan dijalankan di background, Anda bisa meninggalkan halaman ini</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Struktur File -->
                    <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Struktur File</h3>
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Kolom</th>
                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Contoh</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200">
                                        <tr><td class="px-4 py-2 text-sm">date</td><td class="px-4 py-2 text-sm">2025-12-01</td></tr>
                                        <tr><td class="px-4 py-2 text-sm">ticket_number</td><td class="px-4 py-2 text-sm">001080</td></tr>
                                        <tr><td class="px-4 py-2 text-sm">plate_number</td><td class="px-4 py-2 text-sm">BM 8959 JO</td></tr>
                                        <tr><td class="px-4 py-2 text-sm">transporter_id</td><td class="px-4 py-2 text-sm">13</td></tr>
                                        <tr><td class="px-4 py-2 text-sm">customer_id</td><td class="px-4 py-2 text-sm">7</td></tr>
                                        <tr><td class="px-4 py-2 text-sm">product_id</td><td class="px-4 py-2 text-sm">9</td></tr>
                                        <tr><td class="px-4 py-2 text-sm">gross_weight</td><td class="px-4 py-2 text-sm">44.88</td></tr>
                                        <tr><td class="px-4 py-2 text-sm">tare_weight</td><td class="px-4 py-2 text-sm">13.69</td></tr>
                                        <tr><td class="px-4 py-2 text-sm">status_sale</td><td class="px-4 py-2 text-sm">1</td></tr>
                                        <tr><td class="px-4 py-2 text-sm">price_per_unit</td><td class="px-4 py-2 text-sm">10000</td></tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.getElementById('file').addEventListener('change', function(e) {
                const fileName = e.target.files[0]?.name || '';
                document.getElementById('file-name').textContent = fileName ? 'File: ' + fileName : '';
            });

            // Drag and drop visual effect
            const dropZone = document.querySelector('label[for="file"]');
            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                dropZone.addEventListener(eventName, preventDefaults, false);
            });

            function preventDefaults(e) {
                e.preventDefault();
                e.stopPropagation();
            }

            ['dragenter', 'dragover'].forEach(eventName => {
                dropZone.addEventListener(eventName, highlight, false);
            });

            ['dragleave', 'drop'].forEach(eventName => {
                dropZone.addEventListener(eventName, unhighlight, false);
            });

            function highlight(e) {
                dropZone.classList.add('border-indigo-500', 'bg-indigo-50');
            }

            function unhighlight(e) {
                dropZone.classList.remove('border-indigo-500', 'bg-indigo-50');
            }

            dropZone.addEventListener('drop', handleDrop, false);

            function handleDrop(e) {
                const dt = e.dataTransfer;
                const files = dt.files;
                document.getElementById('file').files = files;
                
                const fileName = files[0]?.name || '';
                document.getElementById('file-name').textContent = fileName ? 'File: ' + fileName : '';
            }
        </script>
    @endpush
</x-app-layout>