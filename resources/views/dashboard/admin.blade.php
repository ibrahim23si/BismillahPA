{{-- resources/views/dashboard/admin.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Dashboard Admin Produksi') }}
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

                <!-- Total Jam Operasional Hari Ini -->
                <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                                <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linecap="round"
                                        d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600">Jam Operasional Hari Ini</p>
                                <p class="text-2xl font-semibold text-gray-900">8 jam</p>
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

            <!-- Grafik Produksi dengan Height Fix -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                <!-- Grafik Target vs Realisasi -->
                <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold text-gray-900">Produksi</h3>
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

                <!-- Produktivitas per Jam -->
                <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Produktivitas per Jam</h3>
                        <div class="relative" style="height: 300px;">
                            <canvas id="produktivitasChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <a href="{{ route('admin.produksi-raw.create') }}"
                            class="bg-blue-50 hover:bg-blue-100 rounded-lg p-4 text-center transition">
                            <svg class="h-8 w-8 text-blue-600 mx-auto mb-2" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linecap="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                            <span class="text-sm font-medium text-blue-700">Tambah Produksi</span>
                        </a>
                        <a href="{{ route('admin.timbangan.create') }}"
                            class="bg-green-50 hover:bg-green-100 rounded-lg p-4 text-center transition">
                            <svg class="h-8 w-8 text-green-600 mx-auto mb-2" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linecap="round"
                                    d="M12 3v17.25m0 0c-1.472 0-2.882.265-4.185.75M12 20.25c1.472 0 2.882.265 4.185.75M18.75 4.97A48.416 48.416 0 0012 4.5c-2.291 0-4.545.16-6.75.47m13.5 0c1.01.143 2.01.317 3 .52m-3-.52l2.62 10.726c.122.499-.106 1.028-.589 1.202a5.988 5.988 0 01-2.031.352 5.988 5.988 0 01-2.031-.352c-.483-.174-.711-.703-.589-1.202L18.75 4.971z" />
                            </svg>
                            <span class="text-sm font-medium text-green-700">Input Timbangan</span>
                        </a>
                        <a href="{{ route('admin.keluar-material.create') }}"
                            class="bg-purple-50 hover:bg-purple-100 rounded-lg p-4 text-center transition">
                            <svg class="h-8 w-8 text-purple-600 mx-auto mb-2" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linecap="round"
                                    d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
                            </svg>
                            <span class="text-sm font-medium text-purple-700">Keluar Material</span>
                        </a>
                        <a href="{{ route('admin.produksi-raw.index') }}"
                            class="bg-gray-50 hover:bg-gray-100 rounded-lg p-4 text-center transition">
                            <svg class="h-8 w-8 text-gray-600 mx-auto mb-2" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linecap="round"
                                    d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
                            </svg>
                            <span class="text-sm font-medium text-gray-700">Lihat Semua Data</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            let produksiChart = null;
            let produktivitasChart = null;
            
            $(document).ready(function() {
                // Initialize charts
                initializeCharts();
                
                // Handle apply button click
                $('#applyPeriode').on('click', function() {
                    const periode = $('#periodeInput').val();
                    
                    // Validation
                    if (!periode || periode < 1 || periode > 365) {
                        alert('Masukkan angka antara 1-365 hari');
                        return;
                    }
                    
                    updateCharts(periode);
                });
                
                // Handle Enter key on input
                $('#periodeInput').on('keypress', function(e) {
                    if (e.which === 13) { // Enter key
                        $('#applyPeriode').click();
                    }
                });
                
                function initializeCharts() {
                    // Grafik Produksi
                    const ctx1 = document.getElementById('produksiChart');
                    if (ctx1) {
                        const labels = {!! json_encode($grafikData['labels'] ?? []) !!};
                        const targetData = {!! json_encode($grafikData['target'] ?? []) !!};
                        const realisasiData = {!! json_encode($grafikData['realisasi'] ?? []) !!};

                        produksiChart = new Chart(ctx1.getContext('2d'), {
                            type: 'bar',
                            data: {
                                labels: labels,
                                datasets: [{
                                        label: 'Target Produksi (ton)',
                                        data: targetData,
                                        backgroundColor: 'rgba(59, 130, 246, 0.5)',
                                        borderColor: 'rgb(59, 130, 246)',
                                        borderWidth: 1,
                                        borderRadius: 5,
                                        barPercentage: 0.8,
                                        categoryPercentage: 0.9
                                    },
                                    {
                                        label: 'Realisasi Produksi (ton)',
                                        data: realisasiData,
                                        backgroundColor: 'rgba(16, 185, 129, 0.5)',
                                        borderColor: 'rgb(16, 185, 129)',
                                        borderWidth: 1,
                                        borderRadius: 5,
                                        barPercentage: 0.8,
                                        categoryPercentage: 0.9
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
                                                return value + ' ton';
                                            }
                                        }
                                    },
                                    x: {
                                        grid: {
                                            display: false
                                        }
                                    }
                                },
                                layout: {
                                    padding: {
                                        top: 10,
                                        bottom: 10
                                    }
                                }
                            }
                        });
                    }

                    // Grafik Produktivitas
                    const ctx2 = document.getElementById('produktivitasChart');
                    if (ctx2) {
                        const produktivitasData = {!! json_encode($produktivitasPerJam ?? [10.5, 11.2, 9.8, 12.1, 10.8, 11.5, 12.3]) !!};

                        produktivitasChart = new Chart(ctx2.getContext('2d'), {
                            type: 'line',
                            data: {
                                labels: {!! json_encode($grafikData['labels'] ?? []) !!},
                                datasets: [{
                                    label: 'Produktivitas (ton/jam)',
                                    data: produktivitasData,
                                    borderColor: 'rgb(139, 92, 246)',
                                    backgroundColor: 'rgba(139, 92, 246, 0.1)',
                                    borderWidth: 3,
                                    tension: 0.1,
                                    fill: true,
                                    pointBackgroundColor: 'rgb(139, 92, 246)',
                                    pointBorderColor: 'white',
                                    pointBorderWidth: 2,
                                    pointRadius: 5,
                                    pointHoverRadius: 7
                                }]
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
                                    }
                                },
                                scales: {
                                    y: {
                                        beginAtZero: true,
                                        grid: {
                                            color: 'rgba(0, 0, 0, 0.05)'
                                        },
                                        title: {
                                            display: true,
                                            text: 'Ton/Jam'
                                        },
                                        ticks: {
                                            callback: function(value) {
                                                return value.toFixed(1) + ' t/jam';
                                            }
                                        }
                                    },
                                    x: {
                                        grid: {
                                            display: false
                                        }
                                    }
                                },
                                layout: {
                                    padding: {
                                        top: 10,
                                        bottom: 10
                                    }
                                }
                            }
                        });
                    }
                }
                
                function updateCharts(periode) {
                    // Show loading
                    $('#produksiChart, #produktivitasChart').addClass('opacity-50');
                    
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
                            
                            // Update produktivitas chart
                            if (produktivitasChart && response.produktivitasPerJam) {
                                produktivitasChart.data.labels = response.grafikData.labels;
                                produktivitasChart.data.datasets[0].data = response.produktivitasPerJam;
                                produktivitasChart.update();
                            }
                            
                            // Update produktivitas rata-rata card
                            if (response.produktivitasRataRata !== undefined) {
                                // Find the produktivitas card and update it
                                $('.grid .bg-white').each(function() {
                                    if ($(this).find('p:contains("Rata-rata Produktivitas")').length > 0) {
                                        $(this).find('.text-2xl').text(response.produktivitasRataRata.toFixed(2) + ' ton/jam');
                                    }
                                });
                            }
                            
                            // Remove loading
                            $('#produksiChart, #produktivitasChart').removeClass('opacity-50');
                        },
                        error: function() {
                            // Remove loading
                            $('#produksiChart, #produktivitasChart').removeClass('opacity-50');
                            alert('Gagal memuat data. Silakan coba lagi.');
                        }
                    });
                }
            });
        </script>
    @endpush
</x-app-layout>
