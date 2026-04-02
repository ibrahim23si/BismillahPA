{{-- resources/views/readonly/partials/export-filter.blade.php --}}
{{-- Usage: @include('readonly.partials.export-filter', ['exportRoute' => 'readonly.produksi-raw.export']) --}}

<div class="bg-white overflow-hidden shadow-sm rounded-lg mb-6">
    <div class="p-4">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
            <div>
                <label class="block text-sm font-medium text-gray-700">Dari Tanggal</label>
                <input type="date" id="filter_start_date" value="{{ request('start_date', date('Y-m-01')) }}"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Sampai Tanggal</label>
                <input type="date" id="filter_end_date" value="{{ request('end_date', date('Y-m-d')) }}"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
            </div>
            <div class="flex space-x-2">
                <a href="#" id="exportBtn"
                    class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded inline-flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Export Excel
                </a>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function updateExportUrl() {
        var startDate = document.getElementById('filter_start_date').value;
        var endDate = document.getElementById('filter_end_date').value;
        var exportUrl = "{{ route($exportRoute) }}?start_date=" + startDate + "&end_date=" + endDate;
        document.getElementById('exportBtn').href = exportUrl;
    }
    // Update on load and on change
    document.addEventListener('DOMContentLoaded', function() {
        updateExportUrl();
        document.getElementById('filter_start_date').addEventListener('change', updateExportUrl);
        document.getElementById('filter_end_date').addEventListener('change', updateExportUrl);
    });
</script>
@endpush
