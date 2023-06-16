@props([
    'type' => null,
    'message' => null,
    'title'=> null,
    'icon' => null,
    'slot' => null,
])

@php
    $colours = match ($type) {
        'primary' => 'bg-primary-50 ring-primary-400 text-primary-500 dark:bg-primary-800/25 dark:ring-primary-800 dark:text-primary-500',
        'success' => 'bg-success-100 ring-success-400 text-success-800 dark:bg-success-900/25 dark:ring-success-800 dark:text-success-500',
        'danger', 'error' => 'bg-danger-100 ring-danger-400 text-danger-800 dark:bg-danger-900/25 dark:ring-danger-800 dark:text-danger-500',
        'warning' => 'bg-warning-100 ring-warning-400 text-warning-600 dark:bg-warning-900/25 dark:ring-warning-800 dark:text-warning-500',
        'info' => 'bg-blue-100 ring-blue-400 text-blue-800 dark:bg-blue-900/25 dark:ring-blue-800 dark:text-blue-500',
        default => 'bg-gray-100 ring-gray-400 text-gray-800 dark:bg-gray-700/25 dark:ring-gray-700 dark:text-gray-500',
    };
    if (! $icon) {
        $icon = match ($type) {
            'primary', 'info' => 'heroicon-s-information-circle',
            'success' => 'heroicon-s-check-circle',
            'danger', 'error' => 'heroicon-s-x-circle',
            'warning' => 'heroicon-s-exclamation',
            default => 'heroicon-s-question-mark-circle',
        };
    }
@endphp

<div {{ $attributes->class("ring-1 ring-opacity-50 dark:ring-opacity-25 rounded-lg shadow-md overflow-hidden {$colours}") }} role="alert">
    <div class="pl-4 pr-6 py-3 dark:bg-gray-900/60">
        <div class="flex">
            <div class="py-1">
                <x-dynamic-component :component="$icon" class="fill-current h-8 w-8 mr-4"></x-dynamic-component>
            </div>
            <div>
                @if($title)
                    <div class="font-bold">{{$title}}</div>
                @endif
                <div class="text-sm text-gray-900 dark:text-gray-100 mt-2">{{$slot}}{{$message}}</div>
            </div>
        </div>
    </div>
</div>
