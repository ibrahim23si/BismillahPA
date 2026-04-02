{{-- resources/views/dashboard/super-admin.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Dashboard Super Admin') }}
            </h2>
            <div class="text-sm text-gray-600">
                {{ now()->format('l, d F Y') }}
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Total Produksi Hari Ini -->
                <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
                                <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linecap="round"
                                        d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600">Total Produksi Hari Ini</p>
                                <p class="text-2xl font-semibold text-gray-900">
                                    {{ number_format($totalProduksiHariIni, 2) }} ton</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Penjualan Hari Ini -->
                <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                                <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linecap="round"
                                        d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600">Total Penjualan Hari Ini</p>
                                <p class="text-2xl font-semibold text-gray-900">Rp
                                    {{ number_format($totalPenjualanHariIni, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Rata-rata Produktivitas -->
                <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-purple-500 rounded-md p-3">
                                <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linecap="round"
                                        d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600">Rata-rata Produktivitas</p>
                                <p class="text-2xl font-semibold text-gray-900">
                                    {{ number_format($produktivitasRataRata, 2) }} ton/jam</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Capaian Target Bulanan -->
                <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-yellow-500 rounded-md p-3">
                                <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linecap="round"
                                        d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600">Capaian Target Bulanan</p>
                                <p class="text-2xl font-semibold text-gray-900">
                                    {{ number_format($capaianTargetProduksi['persentase'], 2) }}%</p>
                                <p class="text-xs text-gray-500">
                                    {{ number_format($capaianTargetProduksi['realisasi'], 2) }} /
                                    {{ number_format($capaianTargetProduksi['target'], 2) }} ton</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Grafik Perbandingan Target vs Realisasi -->
            <div class="bg-white overflow-hidden shadow-sm rounded-lg mt-8 mb-10">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-8">
                        <h3 class="text-lg font-semibold text-gray-900">Grafik Produksi</h3>
                        <div class="flex items-center space-x-2">
                            <label class="text-sm text-gray-600">Periode:</label>
                            <input type="number" 
                                   id="periodeInput" 
                                   value="{{ $periode }}" 
                                   min="1" 
                                   max="365"
                                   class="w-20 px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                                   placeholder="hari">
                            <span class="text-sm text-gray-600">hari terakhir</span>
                            <button id="applyPeriode" 
                                    class="px-3 py-2 bg-blue-600 text-white text-sm rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                Terapkan
                            </button>
                        </div>
                    </div>
                    <div class="relative" style="height: 300px;">
                        <canvas id="produksiChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Pending Approvals -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Pending Jual Material -->
                <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold text-gray-900">Pending Jual Material</h3>
                            <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                                {{ $pendingApprovals['jual']->count() }} pending
                            </span>
                        </div>

                        @if ($pendingApprovals['jual']->isEmpty())
                            <p class="text-gray-500 text-center py-4">Tidak ada pending approval</p>
                        @else
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">
                                                Tanggal</th>
                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">
                                                Customer</th>
                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">
                                                Total</th>
                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">
                                                Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach ($pendingApprovals['jual'] as $item)
                                            <tr>
                                                <td class="px-4 py-2 text-sm">{{ $item->tanggal->format('d/m/Y') }}</td>
                                                <td class="px-4 py-2 text-sm">{{ $item->nama_customer }}</td>
                                                <td class="px-4 py-2 text-sm">Rp
                                                    {{ number_format($item->total_harga, 0, ',', '.') }}</td>
                                                <td class="px-4 py-2 text-sm">
                                                    <a href="{{ route('super-admin.approvals.index') }}"
                                                        class="text-blue-600 hover:text-blue-900">Detail</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-4 text-right">
                                <a href="{{ route('super-admin.approvals.index') }}"
                                    class="text-sm text-blue-600 hover:text-blue-900">Lihat Semua →</a>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Pending Aju Kas -->
                <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold text-gray-900">Pending Aju Kas</h3>
                            <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                                {{ $pendingApprovals['aju']->count() }} pending
                            </span>
                        </div>

                        @if ($pendingApprovals['aju']->isEmpty())
                            <p class="text-gray-500 text-center py-4">Tidak ada pending approval</p>
                        @else
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">
                                                Tanggal</th>
                                            <th
                                                class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">
                                                Keterangan</th>
                                            <th
                                                class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">
                                                Nominal</th>
                                            <th
                                                class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">
                                                Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach ($pendingApprovals['aju'] as $item)
                                            <tr>
                                                <td class="px-4 py-2 text-sm">{{ $item->tanggal->format('d/m/Y') }}
                                                </td>
                                                <td class="px-4 py-2 text-sm">{{ Str::limit($item->keterangan, 30) }}
                                                </td>
                                                <td class="px-4 py-2 text-sm">Rp
                                                    {{ number_format($item->nominal, 0, ',', '.') }}</td>
                                                <td class="px-4 py-2 text-sm">
                                                    <a href="{{ route('super-admin.approvals.index') }}"
                                                        class="text-blue-600 hover:text-blue-900">Detail</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-4 text-right">
                                <a href="{{ route('super-admin.approvals.index') }}"
                                    class="text-sm text-blue-600 hover:text-blue-900">Lihat Semua →</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            let produksiChart = null;
            
            $(document).ready(function() {
                // Initialize chart
                initializeChart();
                
                // Handle apply button click
                $('#applyPeriode').on('click', function() {
                    const periode = $('#periodeInput').val();
                    
                    // Validation
                    if (!periode || periode < 1 || periode > 365) {
                        alert('Masukkan angka antara 1-365 hari');
                        return;
                    }
                    
                    updateChart(periode);
                });
                
                // Handle Enter key on input
                $('#periodeInput').on('keypress', function(e) {
                    if (e.which === 13) { // Enter key
                        $('#applyPeriode').click();
                    }
                });
                
                function initializeChart() {
                    const ctx = document.getElementById('produksiChart');
                    if (ctx) {
                        // Ambil data dari PHP
                        const labels = {!! json_encode($grafikData['labels'] ?? []) !!};
                        const targetData = {!! json_encode($grafikData['target'] ?? []) !!};
                        const realisasiData = {!! json_encode($grafikData['realisasi'] ?? []) !!};

                        // Tentukan apakah ini data produksi (ton) atau penjualan (rupiah)
                        // Cek nilai maksimum untuk menentukan skala
                        const maxTarget = Math.max(...targetData, 0);
                        const maxRealisasi = Math.max(...realisasiData, 0);
                        const maxValue = Math.max(maxTarget, maxRealisasi);

                        // Tentukan format tooltip berdasarkan nilai
                        const isRupiah = maxValue > 10000; // Jika > 10.000, anggap sebagai rupiah

                        produksiChart = new Chart(ctx.getContext('2d'), {
                            type: 'line',
                            data: {
                                labels: labels,
                                datasets: [{
                                        label: 'Target Produksi (ton)',
                                        data: targetData,
                                        borderColor: 'rgb(59, 130, 246)',
                                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                                        borderWidth: 2,
                                        tension: 0.1,
                                        fill: true,
                                        yAxisID: 'y' // Gunakan sumbu kiri
                                    },
                                    {
                                        label: 'Realisasi Produksi (ton)',
                                        data: realisasiData,
                                        borderColor: 'rgb(16, 185, 129)',
                                        backgroundColor: 'rgba(16, 185, 129, 0.1)',
                                        borderWidth: 2,
                                        tension: 0.1,
                                        fill: true,
                                        yAxisID: 'y' // Gunakan sumbu kiri
                                    }
                                ]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: {
                                    legend: {
                                        position: 'bottom',
                                        labels: {
                                            boxWidth: 12,
                                            padding: 15
                                        }
                                    },
                                    tooltip: {
                                        callbacks: {
                                            label: function(context) {
                                                let label = context.dataset.label || '';
                                                let value = context.raw || 0;
                                                if (label.includes('Harga') || label.includes('Rupiah') || label
                                                    .includes('Rp')) {
                                                    return label + ': Rp ' + value.toLocaleString('id-ID');
                                                } else {
                                                    return label + ': ' + value.toLocaleString('id-ID') +
                                                        ' ton';
                                                }
                                            }
                                        }
                                    }
                                },
                                scales: {
                                    y: {
                                        beginAtZero: true,
                                        grid: {
                                            color: 'rgba(0, 0, 0, 0.05)'
                                        },
                                        ticks: {
                                            callback: function(value) {
                                                if (isRupiah) {
                                                    if (value >= 1000000) {
                                                        return 'Rp ' + (value / 1000000).toFixed(1) + ' Jt';
                                                    } else if (value >= 1000) {
                                                        return 'Rp ' + (value / 1000).toFixed(1) + ' Rb';
                                                    } else {
                                                        return 'Rp ' + value;
                                                    }
                                                } else {
                                                    return value + ' t';
                                                }
                                            }
                                        }
                                    }
                                },
                                layout: {
                                    padding: {
                                        top: 20,
                                        bottom: 20
                                    }
                                }
                            }
                        });
                    }
                }
                
                function updateChart(periode) {
                    // Show loading
                    $('#produksiChart').addClass('opacity-50');
                    
                    $.ajax({
                        url: '{{ route("dashboard.update") }}',
                        method: 'GET',
                        data: { periode: periode },
                        success: function(response) {
                            // Update produksi chart
                            if (produksiChart && response.grafikData) {
                                produksiChart.data.labels = response.grafikData.labels;
                                produksiChart.data.datasets[0].data = response.grafikData.target;
                                produksiChart.data.datasets[1].data = response.grafikData.realisasi;
                                produksiChart.update();
                            }
                            
                            // Remove loading
                            $('#produksiChart').removeClass('opacity-50');
                        },
                        error: function() {
                            // Remove loading
                            $('#produksiChart').removeClass('opacity-50');
                            alert('Gagal memuat data. Silakan coba lagi.');
                        }
                    });
                }
            });
        </script>
    @endpush
</x-app-layout>
