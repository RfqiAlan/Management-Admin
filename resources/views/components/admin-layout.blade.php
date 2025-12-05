@props(['title' => 'Admin', 'header' => 'Dashboard'])

<x-layouts.admin :title="$title" :header="$header">
    {{ $slot }}
</x-layouts.admin>
