{{-- resources/views/super-admin/approvals/partials/jual-material-table.blade.php --}}
<div class="bg-white overflow-hidden shadow-sm rounded-lg">
    <div class="p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-900">Daftar Jual Material Pending</h3>
            <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                {{ $jualPending->total() }} total
            </span>
        </div>

        @if($jualPending->isEmpty())
            <div class="text-center py-8">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linecap="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
                </svg>
                <p class="mt-2 text-gray-500">Tidak ada data jual material pending</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">No. Tiket</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Customer</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Barang</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Netto</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total Harga</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jenis Bayar</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Dibuat Oleh</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($jualPending as $index => $item)
                        <tr>
                            <td class="px-4 py-3 text-sm">{{ $jualPending->firstItem() + $index }}</td>
                            <td class="px-4 py-3 text-sm">{{ $item->tanggal->format('d/m/Y') }}</td>
                            <td class="px-4 py-3 text-sm">{{ $item->nomor_tiket }}</td>
                            <td class="px-4 py-3 text-sm">{{ $item->nama_customer }}</td>
                            <td class="px-4 py-3 text-sm">{{ $item->nama_barang }}</td>
                            <td class="px-4 py-3 text-sm">{{ number_format($item->netto, 2) }} ton</td>
                            <td class="px-4 py-3 text-sm font-medium">Rp {{ number_format($item->total_harga, 0, ',', '.') }}</td>
                            <td class="px-4 py-3 text-sm">
                                @if($item->jenis_bayar == 'cash')
                                    <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Cash</span>
                                @else
                                    <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800">Invoice</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-sm">{{ $item->creator->name ?? '-' }}</td>
                            <td class="px-4 py-3 text-sm space-x-2">
                                <form action="{{ route('super-admin.approvals.jual.approve', $item->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="text-green-600 hover:text-green-900" onclick="return confirm('Setujui transaksi ini?')">
                                        <svg class="h-5 w-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linecap="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </button>
                                </form>
                                <button onclick="showRejectModal('jual', {{ $item->id }})" class="text-red-600 hover:text-red-900">
                                    <svg class="h-5 w-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linecap="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-4">
                {{ $jualPending->links() }}
            </div>
        @endif
    </div>
</div>