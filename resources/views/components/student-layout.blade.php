@props(['title' => 'Dashboard'])

<x-layouts.student :title="$title">
    {{ $slot }}
</x-layouts.student>
