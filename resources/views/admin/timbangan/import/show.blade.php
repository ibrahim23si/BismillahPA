<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail Import: ' . $import->original_filename) }}
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
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-6">
                    <!-- Status Badge -->
                    <div class="mb-6">
                        @if($import->status == 'pending')
                            <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                Status: Pending
                            </span>
                        @elseif($import->status == 'processing')
                            <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                Status: Processing
                            </span>
                        @elseif($import->status == 'completed')
                            <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                Status: Completed
                            </span>
                        @else
                            <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                Status: Failed
                            </span>
                        @endif
                    </div>

                    <!-- Detail Table -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <div class="border-b border-gray-200 pb-4">
                                <h3 class="text-lg font-medium text-gray-900 mb-3">Informasi File</h3>
                                <dl class="grid grid-cols-3 gap-2 text-sm">
                                    <dt class="font-medium text-gray-500">Nama File:</dt>
                                    <dd class="col-span-2 text-gray-900">{{ $import->original_filename }}</dd>
                                    
                                    <dt class="font-medium text-gray-500">Diupload:</dt>
                                    <dd class="col-span-2 text-gray-900">{{ $import->created_at->format('d/m/Y H:i:s') }}</dd>
                                    
                                    <dt class="font-medium text-gray-500">Oleh:</dt>
                                    <dd class="col-span-2 text-gray-900">{{ $import->user->name ?? '-' }}</dd>
                                </dl>
                            </div>

                            <div>
                                <h3 class="text-lg font-medium text-gray-900 mb-3">Statistik Import</h3>
                                <dl class="grid grid-cols-3 gap-2 text-sm">
                                    <dt class="font-medium text-gray-500">Berhasil:</dt>
                                    <dd class="col-span-2 text-gray-900">{{ $import->imported_count }}</dd>
                                    
                                    <dt class="font-medium text-gray-500">Gagal:</dt>
                                    <dd class="col-span-2 text-gray-900">{{ $import->failed_count }}</dd>
                                    
                                    <dt class="font-medium text-gray-500">Total:</dt>
                                    <dd class="col-span-2 text-gray-900">{{ $import->imported_count + $import->failed_count }}</dd>
                                </dl>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 mb-3">Waktu Proses</h3>
                                <dl class="grid grid-cols-3 gap-2 text-sm">
                                    <dt class="font-medium text-gray-500">Mulai:</dt>
                                    <dd class="col-span-2 text-gray-900">{{ $import->started_at ? $import->started_at->format('d/m/Y H:i:s') : '-' }}</dd>
                                    
                                    <dt class="font-medium text-gray-500">Selesai:</dt>
                                    <dd class="col-span-2 text-gray-900">{{ $import->completed_at ? $import->completed_at->format('d/m/Y H:i:s') : '-' }}</dd>
                                    
                                    @if($import->started_at && $import->completed_at)
                                    <dt class="font-medium text-gray-500">Durasi:</dt>
                                    <dd class="col-span-2 text-gray-900">
                                        {{ $import->started_at->diffInSeconds($import->completed_at) }} detik
                                    </dd>
                                    @endif
                                </dl>
                            </div>

                            @if($import->error_message)
                            <div class="mt-4">
                                <h3 class="text-lg font-medium text-red-900 mb-3">Error Message</h3>
                                <div class="bg-red-50 border border-red-200 rounded-md p-4">
                                    <pre class="text-sm text-red-800 whitespace-pre-wrap">{{ $import->error_message }}</pre>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Processing Indicator -->
                    @if($import->status == 'processing')
                    <div class="mt-6 bg-blue-50 border-l-4 border-blue-400 p-4">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="animate-spin h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-blue-700">
                                    Proses import sedang berjalan. Halaman ini akan otomatis memperbarui status.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Auto Refresh Script -->
                    <script>
                        setTimeout(function() {
                            location.reload();
                        }, 5000); // Refresh setiap 5 detik
                    </script>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <!-- Script tambahan jika diperlukan -->
    @endpush
</x-app-layout>