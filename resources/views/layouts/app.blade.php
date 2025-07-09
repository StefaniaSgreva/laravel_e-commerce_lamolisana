<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="@yield('page-description', 'La Molisana - Pasta di qualità dal 1912')">

    <!-- Preload delle risorse critiche -->
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" as="style">
    <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" as="style">

    <!-- Titolo dinamico + fallback -->
    <title>@yield('page-title', 'La Molisana: pasta, semole e farina di qualità')</title>

    <!-- Preconnessione a domini esterni -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin>

    <!-- Font Google con caricamento ottimizzato (Montserrat) -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet" media="print" onload="this.media='all'">
    <noscript>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    </noscript>

    <!-- Font Awesome con fallback -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Favicon -->
    <link rel="icon" href="{{ Vite::asset('resources/img/favicon.ico') }}" type="image/x-icon">

    <!-- CSS/JS con Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Meta tag per social media (opzionali) -->
    {{-- <meta property="og:title" content="@yield('page-title', 'La Molisana')">
    <meta property="og:description" content="@yield('page-description', 'Pasta artigianale di qualità dal 1912')">
    <meta property="og:image" content="{{ Vite::asset('resources/img/social-share.jpg') }}">
    <meta name="theme-color" content="#ffffff"> --}}
</head>
<body class="antialiased text-gray-900 min-h-screen">
    {{-- HEADER --}}
    @include('partials.header')
    {{-- PAGE CONTENT --}}
    <main role="main" aria-label="Contenuto principale">
        @yield('content')
    </main>
    {{-- FOOTER --}}
    @include('partials.footer')
</body>
</html>
