@props([
    'title' => config('app.name'),
])

<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>{{ $title }} - {{ config('app.name') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- HAPUS kalau kamu belum pakai Vite / Tailwind --}}
    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}

    {{-- Bootstrap 5.3 CDN --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    @include('layouts.navigation')

    <main>
        {{ $slot }}
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
