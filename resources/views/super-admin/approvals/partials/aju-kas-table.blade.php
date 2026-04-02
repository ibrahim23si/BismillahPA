{{-- resources/views/super-admin/approvals/partials/aju-kas-table.blade.php --}}
<div class="bg-white overflow-hidden shadow-sm rounded-lg">
    <div class="p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-900">Daftar Aju Kas Pending</h3>
            <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                {{ $ajuPending->total() }} total
            </span>
        </div>

        @if ($ajuPending->isEmpty())
            <div class="text-center py-8">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linecap="round"
                        d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15" />
                </svg>
                <p class="mt-2 text-gray-500">Tidak ada data aju kas pending</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">No. Pengajuan
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Keterangan</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nominal</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Diajukan Oleh
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($ajuPending as $index => $item)
                            <tr>
                                <td class="px-4 py-3 text-sm">{{ $ajuPending->firstItem() + $index }}</td>
                                <td class="px-4 py-3 text-sm">{{ $item->nomor_pengajuan }}</td>
                                <td class="px-4 py-3 text-sm">{{ $item->tanggal->format('d/m/Y') }}</td>
                                <td class="px-4 py-3 text-sm max-w-xs truncate">{{ $item->keterangan }}</td>
                                <td class="px-4 py-3 text-sm font-medium">Rp
                                    {{ number_format($item->nominal, 0, ',', '.') }}</td>
                                <td class="px-4 py-3 text-sm">{{ $item->creator->name ?? '-' }}</td>
                                <td class="px-4 py-3 text-sm space-x-2">
                                    <form action="{{ route('super-admin.approvals.aju.approve', $item->id) }}"
                                        method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="text-green-600 hover:text-green-900"
                                            onclick="return confirm('Setujui pengajuan ini?')">
                                            <svg class="h-5 w-5 inline" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linecap="round"
                                                    d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </button>
                                    </form>
                                    <button onclick="showRejectModal('aju', {{ $item->id }})"
                                        class="text-red-600 hover:text-red-900">
                                        <svg class="h-5 w-5 inline" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linecap="round"
                                                d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
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
                {{ $ajuPending->links() }}
            </div>
        @endif
    </div>
</div>
