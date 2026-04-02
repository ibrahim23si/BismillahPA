@props(['type' => 'info', 'message' => '', 'dismissible' => true])

@php
    $colors = [
        'success' => [
            'bg' => 'bg-green-50',
            'border' => 'border-green-400',
            'text' => 'text-green-800',
            'icon' => 'text-green-400',
            'iconPath' => 'M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
        ],
        'error' => [
            'bg' => 'bg-red-50',
            'border' => 'border-red-400',
            'text' => 'text-red-800',
            'icon' => 'text-red-400',
            'iconPath' => 'M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
        ],
        'warning' => [
            'bg' => 'bg-yellow-50',
            'border' => 'border-yellow-400',
            'text' => 'text-yellow-800',
            'icon' => 'text-yellow-400',
            'iconPath' =>
                'M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z',
        ],
        'info' => [
            'bg' => 'bg-blue-50',
            'border' => 'border-blue-400',
            'text' => 'text-blue-800',
            'icon' => 'text-blue-400',
            'iconPath' =>
                'M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z',
        ],
    ];

    $color = $colors[$type] ?? $colors['info'];
@endphp

<div {{ $attributes->merge(['class' => 'rounded-md ' . $color['bg'] . ' p-4 border-l-4 ' . $color['border'] . ' relative']) }}
    x-data="{ show: true }" x-show="show" x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 transform scale-90" x-transition:enter-end="opacity-100 transform scale-100"
    x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 transform scale-100"
    x-transition:leave-end="opacity-0 transform scale-90" role="alert">

    <div class="flex">
        <div class="flex-shrink-0">
            <svg class="h-5 w-5 {{ $color['icon'] }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linecap="round" d="{{ $color['iconPath'] }}" />
            </svg>
        </div>
        <div class="ml-3">
            <p class="text-sm font-medium {{ $color['text'] }}">
                {{ $message }}
            </p>
        </div>

        @if ($dismissible)
            <div class="ml-auto pl-3">
                <div class="-mx-1.5 -my-1.5">
                    <button type="button" @click="show = false"
                        class="inline-flex rounded-md p-1.5 {{ $color['bg'] }} {{ $color['text'] }} hover:{{ $color['bg'] }} focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-{{ $type }}-50 focus:ring-{{ $type }}-600">
                        <span class="sr-only">Dismiss</span>
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linecap="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        @endif
    </div>
</div>
