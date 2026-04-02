{{-- resources/views/dashboard/kasir.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Dashboard Kasir') }}
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
                <!-- Saldo Kas -->
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
                                <p class="text-sm font-medium text-gray-600">Saldo Kas</p>
                                <p class="text-2xl font-semibold text-gray-900">Rp
                                    {{ number_format($saldoKas, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Penjualan Hari Ini -->
                <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
                                <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linecap="round"
                                        d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600">Penjualan Hari Ini</p>
                                <p class="text-2xl font-semibold text-gray-900">Rp
                                    {{ number_format($totalPenjualanHariIni, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Piutang -->
                <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-yellow-500 rounded-md p-3">
                                <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linecap="round"
                                        d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600">Total Piutang</p>
                                <p class="text-2xl font-semibold text-gray-900">Rp
                                    {{ number_format($totalPiutang ?? 0, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Piutang Jatuh Tempo -->
                <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-red-500 rounded-md p-3">
                                <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linecap="round"
                                        d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600">Jatuh Tempo</p>
                                <p class="text-2xl font-semibold text-gray-900">{{ $piutangJatuhTempo->count() }}</p>
                                <p class="text-xs text-gray-500">Piutang</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts & Tables -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                <!-- Grafik Penjualan -->
                <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Grafik Penjualan 7 Hari Terakhir</h3>
                        <div class="relative" style="height: 300px;">
                            <canvas id="penjualanChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Ringkasan Kas -->
                <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Ringkasan Kas Bulan Ini</h3>
                        <div class="space-y-4">
                            <div class="flex justify-between items-center pb-2 border-b">
                                <span class="text-gray-600">Total Pemasukan</span>
                                <span class="text-lg font-semibold text-green-600">Rp
                                    {{ number_format($totalDebet ?? 0, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between items-center pb-2 border-b">
                                <span class="text-gray-600">Total Pengeluaran</span>
                                <span class="text-lg font-semibold text-red-600">Rp
                                    {{ number_format($totalKredit ?? 0, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between items-center pt-2">
                                <span class="text-gray-800 font-medium">Selisih</span>
                                <span class="text-xl font-bold text-blue-600">Rp
                                    {{ number_format(($totalDebet ?? 0) - ($totalKredit ?? 0), 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Piutang Jatuh Tempo List -->
            @if ($piutangJatuhTempo->isNotEmpty())
                <div class="bg-white overflow-hidden shadow-sm rounded-lg mb-8">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold text-gray-900">Piutang Jatuh Tempo (7 Hari ke Depan)</h3>
                            <span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                                {{ $piutangJatuhTempo->count() }} piutang
                            </span>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">
                                            Tanggal</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">
                                            Customer</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">
                                            Jatuh Tempo</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">
                                            Nominal</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Sisa
                                        </th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">
                                            Action</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($piutangJatuhTempo as $piutang)
                                        <tr>
                                            <td class="px-4 py-2 text-sm">{{ $piutang->tanggal->format('d/m/Y') }}</td>
                                            <td class="px-4 py-2 text-sm">{{ $piutang->nama_debitur }}</td>
                                            <td class="px-4 py-2 text-sm">
                                                {{ $piutang->tanggal_jatuh_tempo->format('d/m/Y') }}</td>
                                            <td class="px-4 py-2 text-sm">Rp
                                                {{ number_format($piutang->nominal, 0, ',', '.') }}</td>
                                            <td class="px-4 py-2 text-sm">Rp
                                                {{ number_format($piutang->sisa, 0, ',', '.') }}</td>
                                            <td class="px-4 py-2 text-sm">
                                                <a href="{{ route('kasir.piutang.edit', $piutang->id) }}"
                                                    class="text-blue-600 hover:text-blue-900">Bayar</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Quick Actions -->
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <a href="{{ route('kasir.jual-material.create') }}"
                            class="bg-blue-50 hover:bg-blue-100 rounded-lg p-4 text-center transition">
                            <svg class="h-8 w-8 text-blue-600 mx-auto mb-2" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linecap="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                            <span class="text-sm font-medium text-blue-700">Tambah Penjualan</span>
                        </a>
                        <a href="{{ route('kasir.aju-kas.create') }}"
                            class="bg-green-50 hover:bg-green-100 rounded-lg p-4 text-center transition">
                            <svg class="h-8 w-8 text-green-600 mx-auto mb-2" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linecap="round"
                                    d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15" />
                            </svg>
                            <span class="text-sm font-medium text-green-700">Aju Kas</span>
                        </a>
                        <a href="{{ route('kasir.piutang.index') }}"
                            class="bg-yellow-50 hover:bg-yellow-100 rounded-lg p-4 text-center transition">
                            <svg class="h-8 w-8 text-yellow-600 mx-auto mb-2" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linecap="round"
                                    d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.745 3.745 0 011.043 3.296A3.745 3.745 0 0121 12z" />
                            </svg>
                            <span class="text-sm font-medium text-yellow-700">Tagih Piutang</span>
                        </a>
                        <a href="{{ route('kasir.lap-kas.index') }}"
                            class="bg-gray-50 hover:bg-gray-100 rounded-lg p-4 text-center transition">
                            <svg class="h-8 w-8 text-gray-600 mx-auto mb-2" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linecap="round"
                                    d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
                            </svg>
                            <span class="text-sm font-medium text-gray-700">Laporan Kas</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            $(document).ready(function() {
                const ctx = document.getElementById('penjualanChart');
                if (ctx) {
                    // Data penjualan (dalam rupiah)
                    const penjualanTunai = [12000000, 15000000, 8000000, 18000000, 14000000, 16000000, 11000000];
                    const penjualanInvoice = [5000000, 7000000, 4000000, 9000000, 6000000, 8000000, 3000000];

                    // Hitung nilai maksimum untuk skala
                    const maxTunai = Math.max(...penjualanTunai);
                    const maxInvoice = Math.max(...penjualanInvoice);
                    const maxValue = Math.max(maxTunai, maxInvoice);

                    new Chart(ctx.getContext('2d'), {
                        type: 'line',
                        data: {
                            labels: {!! json_encode($grafikData['labels'] ?? ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min']) !!},
                            datasets: [{
                                    label: 'Penjualan Tunai',
                                    data: penjualanTunai,
                                    borderColor: 'rgb(16, 185, 129)',
                                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
                                    borderWidth: 2,
                                    tension: 0.1,
                                    fill: true
                                },
                                {
                                    label: 'Penjualan Invoice',
                                    data: penjualanInvoice,
                                    borderColor: 'rgb(59, 130, 246)',
                                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                                    borderWidth: 2,
                                    tension: 0.1,
                                    fill: true
                                }
                            ]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    position: 'bottom'
                                },
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            let label = context.dataset.label || '';
                                            let value = context.raw || 0;
                                            return label + ': Rp ' + value.toLocaleString('id-ID');
                                        }
                                    }
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: {
                                        callback: function(value) {
                                            if (value >= 1000000) {
                                                return 'Rp ' + (value / 1000000).toFixed(1) + ' Jt';
                                            } else if (value >= 1000) {
                                                return 'Rp ' + (value / 1000).toFixed(1) + ' Rb';
                                            } else {
                                                return 'Rp ' + value;
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    });
                }

                // Grafik Piutang Jatuh Tempo (jika ada)
                const ctxPiutang = document.getElementById('piutangChart');
                if (ctxPiutang) {
                    new Chart(ctxPiutang.getContext('2d'), {
                        type: 'bar',
                        data: {
                            labels: {!! json_encode($piutangJatuhTempo->pluck('nama_debitur')->toArray() ?? []) !!},
                            datasets: [{
                                label: 'Nominal Piutang',
                                data: {!! json_encode($piutangJatuhTempo->pluck('sisa')->toArray() ?? []) !!},
                                backgroundColor: 'rgba(239, 68, 68, 0.5)',
                                borderColor: 'rgb(239, 68, 68)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    display: false
                                },
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            return 'Rp ' + context.raw.toLocaleString('id-ID');
                                        }
                                    }
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: {
                                        callback: function(value) {
                                            if (value >= 1000000) {
                                                return 'Rp ' + (value / 1000000).toFixed(1) + ' Jt';
                                            } else {
                                                return 'Rp ' + value.toLocaleString('id-ID');
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    });
                }
            });
        </script>
    @endpush
</x-app-layout>
