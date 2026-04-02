@props(['position' => 'top-right'])

@php
    $positions = [
        'top' => 'top-0 left-1/2 transform -translate-x-1/2 mt-4',
        'top-right' => 'top-0 right-0 mt-4 mr-4',
        'top-left' => 'top-0 left-0 mt-4 ml-4',
        'bottom' => 'bottom-0 left-1/2 transform -translate-x-1/2 mb-4',
        'bottom-right' => 'bottom-0 right-0 mb-4 mr-4',
        'bottom-left' => 'bottom-0 left-0 mb-4 ml-4',
    ];

    $positionClass = $positions[$position] ?? $positions['top-right'];
@endphp

<div x-data="alertContainer()" x-init="init" @alert.window="addAlert($event.detail)"
    class="fixed z-50 {{ $positionClass }} space-y-2 w-96 max-w-full pointer-events-none">

    <template x-for="(alert, index) in alerts" :key="index">
        <div x-show="alert.show" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform translate-x-5"
            x-transition:enter-end="opacity-100 transform translate-x-0"
            x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="opacity-100 transform translate-x-0"
            x-transition:leave-end="opacity-0 transform translate-x-5" class="pointer-events-auto">

            <div :class="{
                'bg-green-50 border-green-400 text-green-800': alert.type === 'success',
                'bg-red-50 border-red-400 text-red-800': alert.type === 'error',
                'bg-yellow-50 border-yellow-400 text-yellow-800': alert.type === 'warning',
                'bg-blue-50 border-blue-400 text-blue-800': alert.type === 'info'
            }"
                class="rounded-md p-4 border-l-4 shadow-lg">

                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg x-show="alert.type === 'success'" class="h-5 w-5 text-green-400" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linecap="round"
                                d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <svg x-show="alert.type === 'error'" class="h-5 w-5 text-red-400" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linecap="round"
                                d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <svg x-show="alert.type === 'warning'" class="h-5 w-5 text-yellow-400" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linecap="round"
                                d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                        </svg>
                        <svg x-show="alert.type === 'info'" class="h-5 w-5 text-blue-400" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linecap="round"
                                d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                        </svg>
                    </div>

                    <div class="ml-3 flex-1">
                        <p class="text-sm font-medium" x-text="alert.message"></p>
                    </div>

                    <div class="ml-auto pl-3">
                        <div class="-mx-1.5 -my-1.5">
                            <button @click="removeAlert(index)"
                                :class="{
                                    'hover:bg-green-100 focus:ring-green-600': alert.type === 'success',
                                    'hover:bg-red-100 focus:ring-red-600': alert.type === 'error',
                                    'hover:bg-yellow-100 focus:ring-yellow-600': alert.type === 'warning',
                                    'hover:bg-blue-100 focus:ring-blue-600': alert.type === 'info'
                                }"
                                class="inline-flex rounded-md p-1.5 focus:outline-none focus:ring-2 focus:ring-offset-2">
                                <span class="sr-only">Dismiss</span>
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linecap="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </template>
</div>

<script>
    function alertContainer() {
        return {
            alerts: [],

            init() {
                // Auto dismiss after 5 seconds
                setInterval(() => {
                    this.alerts.forEach((alert, index) => {
                        if (alert.show && alert.autoDismiss !== false) {
                            this.removeAlert(index);
                        }
                    });
                }, 5000);
            },

            addAlert(detail) {
                const alert = {
                    type: detail.type || 'info',
                    message: detail.message,
                    show: true,
                    autoDismiss: detail.autoDismiss !== false
                };

                this.alerts.push(alert);

                // Auto dismiss individual alert after 5 seconds
                if (alert.autoDismiss) {
                    setTimeout(() => {
                        const index = this.alerts.indexOf(alert);
                        if (index !== -1) {
                            this.removeAlert(index);
                        }
                    }, 5000);
                }
            },

            removeAlert(index) {
                if (this.alerts[index]) {
                    this.alerts[index].show = false;
                    setTimeout(() => {
                        this.alerts.splice(index, 1);
                    }, 300);
                }
            }
        }
    }
</script>
