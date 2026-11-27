<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- Google Fonts: Montserrat (headings) + Poppins (body and buttons) --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800;900&family=Poppins:wght@300;400;500;600&family=Urbanist:wght@500;700&display=swap" rel="stylesheet">

    {{-- Plain CSS served from public/css/style.css --}}
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home.css') }}?v={{ filemtime(public_path('css/home.css')) }}">

    {{-- Vue app bundle (Vite) --}}
    @vite('resources/js/app.js')

    {{-- <title> and meta tags rendered by each page's <Head> component --}}
    @inertiaHead
</head>
<body>
    {{-- Root element where Inertia mounts (or hydrates, with SSR) the Vue app --}}
    @inertia
</body>
</html>
