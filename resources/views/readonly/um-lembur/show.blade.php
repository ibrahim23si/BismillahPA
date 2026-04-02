{{-- resources/views/readonly/um-lembur/show.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail UM & Lembur') }} - {{ $umLembur->nama }}
            </h2>
            <a href="{{ route('readonly.um-lembur.index') }}"
                class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-6">
                    <!-- Informasi Umum -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                        <div class="border rounded-lg p-4">
                            <h3 class="font-semibold text-md mb-3 text-gray-700">Informasi Karyawan</h3>
                            <table class="w-full">
                                <tr>
                                    <td class="py-1 text-gray-600">Periode</td>
                                    <td class="py-1 font-medium">: {{ $umLembur->periode->format('F Y') }}</td>
                                </tr>
                                <tr>
                                    <td class="py-1 text-gray-600">Nama</td>
                                    <td class="py-1 font-medium">: {{ $umLembur->nama }}</td>
                                </tr>
                                <tr>
                                    <td class="py-1 text-gray-600">Jabatan</td>
                                    <td class="py-1 font-medium">: {{ $umLembur->jabatan }}</td>
                                </tr>
                            </table>
                        </div>

                        <div class="border rounded-lg p-4">
                            <h3 class="font-semibold text-md mb-3 text-gray-700">Ringkasan Lembur</h3>
                            <table class="w-full">
                                <tr>
                                    <td class="py-1 text-gray-600">Total Jam</td>
                                    <td class="py-1 font-bold text-blue-600">:
                                        {{ number_format($umLembur->total_jam, 2) }} jam</td>
                                </tr>
                                <tr>
                                    <td class="py-1 text-gray-600">Upah per Jam</td>
                                    <td class="py-1">: Rp {{ number_format($umLembur->upah_per_jam, 0, ',', '.') }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="py-1 text-gray-600">Total Upah</td>
                                    <td class="py-1 font-bold text-green-600">: Rp
                                        {{ number_format($umLembur->total_upah, 0, ',', '.') }}</td>
                                </tr>
                            </table>
                        </div>

                        <div class="border rounded-lg p-4">
                            <h3 class="font-semibold text-md mb-3 text-gray-700">Informasi Pembuat</h3>
                            <table class="w-full">
                                <tr>
                                    <td class="py-1 text-gray-600">Dibuat Oleh</td>
                                    <td class="py-1 font-medium">: {{ $umLembur->creator->name ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="py-1 text-gray-600">Tanggal</td>
                                    <td class="py-1">: {{ $umLembur->created_at->format('d/m/Y H:i') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <!-- Detail Jam Lembur Harian -->
                    <div class="border rounded-lg p-4">
                        <h3 class="font-semibold text-lg mb-4 text-gray-700">Detail Jam Lembur Harian -
                            {{ $umLembur->periode->format('F Y') }}</h3>

                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 border">
                                <thead class="bg-gray-50">
                                    <tr>
                                        @for ($i = 1; $i <= 31; $i++)
                                            <th
                                                class="px-2 py-2 text-center text-xs font-medium text-gray-500 uppercase border">
                                                {{ $i }}
                                            </th>
                                        @endfor
                                        <th
                                            class="px-2 py-2 text-center text-xs font-medium text-gray-500 uppercase border bg-blue-50">
                                            Total
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr>
                                        @for ($i = 1; $i <= 31; $i++)
                                            @php
                                                $hari = 'hari_' . $i;
                                                $nilai = $umLembur->$hari;
                                            @endphp
                                            <td
                                                class="px-2 py-2 text-center border {{ $nilai > 0 ? 'bg-green-50 font-medium' : 'text-gray-400' }}">
                                                {{ $nilai > 0 ? number_format($nilai, 2) . ' j' : '-' }}
                                            </td>
                                        @endfor
                                        <td class="px-2 py-2 text-center border bg-blue-50 font-bold">
                                            {{ number_format($umLembur->total_jam, 2) }} jam
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Keterangan -->
                        @if ($umLembur->keterangan)
                            <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                                <h4 class="font-medium text-gray-700 mb-2">Keterangan:</h4>
                                <p class="text-gray-600">{{ $umLembur->keterangan }}</p>
                            </div>
                        @endif

                        <!-- Legenda -->
                        <div class="mt-4 flex items-center space-x-4 text-xs">
                            <div class="flex items-center">
                                <span class="w-3 h-3 bg-green-50 border border-green-300 mr-1"></span>
                                <span>Ada lembur</span>
                            </div>
                            <div class="flex items-center">
                                <span class="w-3 h-3 bg-white border border-gray-300 mr-1"></span>
                                <span>Tidak lembur</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
