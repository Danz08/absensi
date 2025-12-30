@props([
    'title' => '',
    'value' => 0,
    'color' => 'gray',
])

@php
    $colors = [
        'gray'   => 'border-gray-700 text-white',
        'green'  => 'border-green-600 text-green-400',
        'yellow' => 'border-yellow-500 text-yellow-400',
        'red'    => 'border-red-600 text-red-400',
        'orange' => 'border-orange-500 text-orange-400',
    ];

    $theme = $colors[$color] ?? $colors['gray'];
@endphp

<div class="bg-gray-900/90 backdrop-blur-md border {{ $theme }} rounded-xl p-6 shadow-xl text-center">
    <p class="text-sm text-gray-400 uppercase tracking-wide">
        {{ $title }}
    </p>
    <h3 class="text-3xl font-bold mt-2">
        {{ $value }}
    </h3>
</div>
