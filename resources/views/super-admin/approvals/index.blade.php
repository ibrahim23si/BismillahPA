{{-- resources/views/super-admin/approvals/index.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Approval Management') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Tab Navigation -->
            <div class="mb-6 border-b border-gray-200">
                <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="approvalTabs" role="tablist">
                    <li class="mr-2" role="presentation">
                        <button
                            class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 active-tab"
                            id="jual-tab" data-tabs-target="#jual" type="button" role="tab" aria-controls="jual"
                            aria-selected="true">
                            Jual Material
                            @if ($jualPending->total() > 0)
                                <span
                                    class="ml-2 bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                                    {{ $jualPending->total() }}
                                </span>
                            @endif
                        </button>
                    </li>
                    <li class="mr-2" role="presentation">
                        <button
                            class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300"
                            id="aju-tab" data-tabs-target="#aju" type="button" role="tab" aria-controls="aju"
                            aria-selected="false">
                            Aju Kas
                            @if ($ajuPending->total() > 0)
                                <span
                                    class="ml-2 bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                                    {{ $ajuPending->total() }}
                                </span>
                            @endif
                        </button>
                    </li>
                </ul>
            </div>

            <!-- Tab Content -->
            <div id="approvalTabContent">
                <!-- Jual Material Tab -->
                <div class="hidden" id="jual" role="tabpanel" aria-labelledby="jual-tab">
                    @include('super-admin.approvals.partials.jual-material-table', [
                        'jualPending' => $jualPending,
                    ])
                </div>

                <!-- Aju Kas Tab -->
                <div class="hidden" id="aju" role="tabpanel" aria-labelledby="aju-tab">
                    @include('super-admin.approvals.partials.aju-kas-table', ['ajuPending' => $ajuPending])
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // Tab functionality
            const tabs = document.querySelectorAll('[data-tabs-target]');
            const tabContents = document.querySelectorAll('[role="tabpanel"]');

            tabs.forEach(tab => {
                tab.addEventListener('click', () => {
                    const target = document.querySelector(tab.dataset.tabsTarget);

                    // Deactivate all tabs
                    tabs.forEach(t => {
                        t.classList.remove('border-b-2', 'border-blue-500', 'text-blue-600',
                            'active-tab');
                        t.classList.add('border-transparent', 'text-gray-500');
                        t.setAttribute('aria-selected', 'false');
                    });

                    // Hide all tab contents
                    tabContents.forEach(content => {
                        content.classList.add('hidden');
                    });

                    // Activate current tab
                    tab.classList.remove('border-transparent', 'text-gray-500');
                    tab.classList.add('border-b-2', 'border-blue-500', 'text-blue-600', 'active-tab');
                    tab.setAttribute('aria-selected', 'true');

                    // Show current tab content
                    target.classList.remove('hidden');
                });
            });

            // Activate first tab by default
            if (document.querySelector('#jual-tab')) {
                document.querySelector('#jual-tab').click();
            }

            // Modal functions
            function showRejectModal(type, id) {
                document.getElementById('rejectModal').classList.remove('hidden');
                document.getElementById('rejectForm').action = type === 'jual' ?
                    `{{ url('super-admin/approvals/jual') }}/${id}/reject` :
                    `{{ url('super-admin/approvals/aju') }}/${id}/reject`;
            }

            function closeRejectModal() {
                document.getElementById('rejectModal').classList.add('hidden');
            }
        </script>
    @endpush
</x-app-layout>
