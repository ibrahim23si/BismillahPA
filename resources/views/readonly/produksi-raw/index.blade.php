{{-- resources/views/readonly/produksi-raw/index.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Data Produksi Raw (Read Only)') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @include('readonly.partials.export-filter', ['exportRoute' => 'readonly.produksi-raw.export'])

            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200" id="produksiRawTable">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal
                                    </th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total
                                        Output</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jam
                                        Mulai</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jam
                                        Selesai</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total
                                        Jam</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                        Produktivitas</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                        Keterangan</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Dibuat
                                        Oleh</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi
                                    </th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
        <script>
            $(document).ready(function() {
                $('#produksiRawTable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('readonly.produksi-raw.index') }}",
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'tanggal_produksi',
                            name: 'tanggal_produksi'
                        },
                        {
                            data: 'total_output',
                            name: 'total_output'
                        },
                        {
                            data: 'jam_mulai',
                            name: 'jam_mulai'
                        },
                        {
                            data: 'jam_selesai',
                            name: 'jam_selesai'
                        },
                        {
                            data: 'total_jam_operasional',
                            name: 'total_jam_operasional'
                        },
                        {
                            data: 'produktivitas_per_jam',
                            name: 'produktivitas_per_jam'
                        },
                        {
                            data: 'keterangan',
                            name: 'keterangan'
                        },
                        {
                            data: 'created_by_name',
                            name: 'created_by_name'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        }
                    ],
                    language: {
                        url: "//cdn.datatables.net/plug-ins/1.11.5/i18n/id.json"
                    }
                });
            });
        </script>
    @endpush
</x-app-layout>
