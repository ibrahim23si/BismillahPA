{{-- resources/views/kasir/aju-kas/edit.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Pengajuan Kas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-6">
                    @if ($aju->status != 'pending')
                        <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-4" role="alert">
                            <p class="font-bold">Perhatian!</p>
                            <p>Pengajuan ini sudah diproses ({{ $aju->status }}). Tidak dapat diedit.</p>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('kasir.aju-kas.update', $aju->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Tanggal -->
                            <div>
                                <label for="tanggal" class="block text-sm font-medium text-gray-700">Tanggal Pengajuan
                                    <span class="text-red-500">*</span></label>
                                <input type="date" name="tanggal" id="tanggal"
                                    value="{{ old('tanggal', $aju->tanggal->format('Y-m-d')) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                    {{ $aju->status != 'pending' ? 'readonly' : '' }} required>
                                @error('tanggal')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Nominal -->
                            <div>
                                <label for="nominal" class="block text-sm font-medium text-gray-700">Nominal <span
                                        class="text-red-500">*</span></label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">Rp</span>
                                    </div>
                                    <input type="number" step="0.01" name="nominal" id="nominal"
                                        value="{{ old('nominal', $aju->nominal) }}"
                                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                        {{ $aju->status != 'pending' ? 'readonly' : '' }} required>
                                </div>
                                @error('nominal')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Keterangan -->
                            <div class="md:col-span-2">
                                <label for="keterangan" class="block text-sm font-medium text-gray-700">Keterangan <span
                                        class="text-red-500">*</span></label>
                                <textarea name="keterangan" id="keterangan" rows="4"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                    {{ $aju->status != 'pending' ? 'readonly' : '' }} required>{{ old('keterangan', $aju->keterangan) }}</textarea>
                                @error('keterangan')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Status Info -->
                        @if ($aju->status != 'pending')
                            <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                                <h3 class="font-medium text-gray-700 mb-2">Informasi Status</h3>
                                <table class="w-full text-sm">
                                    <tr>
                                        <td class="py-1 text-gray-600 w-1/4">Status</td>
                                        <td class="py-1 font-medium">: {!! App\Helpers\Helper::getStatusBadge($aju->status) !!}</td>
                                    </tr>
                                    @if ($aju->approved_at)
                                        <tr>
                                            <td class="py-1 text-gray-600">Disetujui/Ditolak pada</td>
                                            <td class="py-1">: {{ $aju->approved_at->format('d/m/Y H:i') }}</td>
                                        </tr>
                                    @endif
                                    @if ($aju->approver)
                                        <tr>
                                            <td class="py-1 text-gray-600">Oleh</td>
                                            <td class="py-1">: {{ $aju->approver->name }}</td>
                                        </tr>
                                    @endif
                                    @if ($aju->catatan_reject)
                                        <tr>
                                            <td class="py-1 text-gray-600">Catatan Reject</td>
                                            <td class="py-1 text-red-600">: {{ $aju->catatan_reject }}</td>
                                        </tr>
                                    @endif
                                </table>
                            </div>
                        @endif

                        <div class="flex justify-end space-x-2 mt-6">
                            <a href="{{ route('kasir.aju-kas.index') }}"
                                class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                Batal
                            </a>
                            @if ($aju->status == 'pending')
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
</x-app-layout>
