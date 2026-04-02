<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">

    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- Custom Select2 Styling (Tailwind-compatible) -->
    <style>
        /* Container */
        .select2-container--default .select2-selection--single {
            height: 42px;
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
            padding: 6px 12px;
            background-color: #fff;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        /* Focus state */
        .select2-container--default.select2-container--open .select2-selection--single,
        .select2-container--default.select2-container--focus .select2-selection--single {
            border-color: #93c5fd;
            box-shadow: 0 0 0 3px rgba(147, 197, 253, 0.5);
            outline: none;
        }

        /* Rendered text */
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 28px;
            color: #374151;
            padding-left: 0;
            font-size: 0.875rem;
        }

        /* Placeholder */
        .select2-container--default .select2-selection--single .select2-selection__placeholder {
            color: #9ca3af;
            font-size: 0.875rem;
        }

        /* Arrow */
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 40px;
            right: 8px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow b {
            border-color: #6b7280 transparent transparent transparent;
            border-width: 5px 4px 0 4px;
            margin-top: -2px;
        }

        .select2-container--default.select2-container--open .select2-selection--single .select2-selection__arrow b {
            border-color: transparent transparent #6b7280 transparent;
            border-width: 0 4px 5px 4px;
        }

        /* Clear button */
        .select2-container--default .select2-selection--single .select2-selection__clear {
            color: #9ca3af;
            font-size: 1.25rem;
            font-weight: 400;
            margin-right: 4px;
            height: 28px;
            line-height: 28px;
        }

        .select2-container--default .select2-selection--single .select2-selection__clear:hover {
            color: #ef4444;
        }

        /* Dropdown panel */
        .select2-dropdown {
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -4px rgba(0, 0, 0, 0.1);
            margin-top: 4px;
            overflow: hidden;
        }

        /* Search field inside dropdown */
        .select2-container--default .select2-search--dropdown .select2-search__field {
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
            padding: 8px 12px;
            font-size: 0.875rem;
            color: #374151;
            outline: none;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        .select2-container--default .select2-search--dropdown .select2-search__field:focus {
            border-color: #93c5fd;
            box-shadow: 0 0 0 3px rgba(147, 197, 253, 0.5);
        }

        .select2-search--dropdown {
            padding: 8px;
        }

        /* Dropdown results */
        .select2-results__option {
            padding: 8px 12px;
            font-size: 0.875rem;
            color: #374151;
            transition: background-color 0.1s ease;
        }

        /* Hover state */
        .select2-container--default .select2-results__option--highlighted.select2-results__option--selectable {
            background-color: #3b82f6;
            color: #fff;
            border-radius: 0;
        }

        /* Selected state */
        .select2-container--default .select2-results__option--selected {
            background-color: #eff6ff;
            color: #1d4ed8;
            font-weight: 500;
        }

        /* "Searching..." and "No results" messages */
        .select2-results__message {
            padding: 8px 12px;
            font-size: 0.875rem;
            color: #9ca3af;
            font-style: italic;
        }

        /* Make loading spinner nicer */
        .select2-container--default .select2-results__option--load-more,
        .select2-container--default .select2-results__option[aria-disabled=true] {
            color: #9ca3af;
        }

        /* Full width */
        .select2-container {
            width: 100% !important;
        }
    </style>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- jQuery (required for DataTables) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>

    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Alpine.js untuk alert -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Additional Styles -->
    @stack('styles')
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        @include('layouts.navigation')

        <!-- Alert Container - HANYA MENGGUNAKAN INI -->
        <x-alert-container position="top-right" />

        <!-- Page Heading -->
        @isset($header)
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>

    <!-- Session Alerts - Menggunakan event system yang sama -->
    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                window.dispatchEvent(new CustomEvent('alert', {
                    detail: {
                        type: 'success',
                        message: '{{ session('success') }}'
                    }
                }));
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                window.dispatchEvent(new CustomEvent('alert', {
                    detail: {
                        type: 'error',
                        message: '{{ session('error') }}'
                    }
                }));
            });
        </script>
    @endif

    @if (session('warning'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                window.dispatchEvent(new CustomEvent('alert', {
                    detail: {
                        type: 'warning',
                        message: '{{ session('warning') }}'
                    }
                }));
            });
        </script>
    @endif

    @if (session('info'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                window.dispatchEvent(new CustomEvent('alert', {
                    detail: {
                        type: 'info',
                        message: '{{ session('info') }}'
                    }
                }));
            });
        </script>
    @endif

    <!-- Reject Modal (Super Admin) -->
    @if (auth()->check() && auth()->user()->role === 'super_admin')
        <div id="rejectModal" class="hidden fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title"
            role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div
                    class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <form id="rejectForm" method="POST">
                        @csrf
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <div class="sm:flex sm:items-start">
                                <div
                                    class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                    <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linecap="round"
                                            d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                                    </svg>
                                </div>
                                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                    <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                        Tolak Pengajuan
                                    </h3>
                                    <div class="mt-2">
                                        <label for="catatan_reject"
                                            class="block text-sm font-medium text-gray-700">Alasan Penolakan</label>
                                        <textarea name="catatan_reject" id="catatan_reject" rows="3"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                            required></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <button type="submit"
                                class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                                Tolak
                            </button>
                            <button type="button"
                                onclick="document.getElementById('rejectModal').classList.add('hidden')"
                                class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                Batal
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script>
            function showRejectModal(type, id) {
                document.getElementById('rejectModal').classList.remove('hidden');
                let actionUrl = type === 'jual' ?
                    "{{ url('super-admin/approvals/jual') }}/" + id + "/reject" :
                    "{{ url('super-admin/approvals/aju') }}/" + id + "/reject";
                document.getElementById('rejectForm').action = actionUrl;
            }
        </script>
    @endif

    <!-- Scripts -->
    @stack('scripts')

    <script>
        // Global AJAX setup for CSRF token
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Helper function to show alert from JavaScript
        window.showAlert = function(type, message) {
            window.dispatchEvent(new CustomEvent('alert', {
                detail: {
                    type: type,
                    message: message
                }
            }));
        };

        // Optional: Handle flash messages from Laravel that might be in data attributes
        document.addEventListener('DOMContentLoaded', function() {
            // Cek jika ada elemen dengan data-flash-message
            const flashElements = document.querySelectorAll('[data-flash-message]');
            flashElements.forEach(element => {
                const type = element.dataset.flashType || 'info';
                const message = element.dataset.flashMessage;
                if (message) {
                    window.showAlert(type, message);
                }
            });
        });
    </script>
</body>

</html>
