<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Favicon --}}
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    {{-- SEO Meta --}}
    <title>@yield('title', 'a remplir')</title>
    <meta name="description" content="@yield('description', 'a remplir')">
    <meta name="keywords" content="@yield('keywords', 'a remplir')">
    <meta name="author" content="@yield('author', 'a remplir')">    

    {{-- CSS (via Vite) --}}
    @if (app()->environment('production'))
        @vite(['resources/js/app.js'], 'build')
    @else
        @vite(['resources/js/app.js'])
    @endif

    {{-- CSS personnalisé (optionnel) --}}
    @stack('css')

</head>
<body>

    {{-- HEADER --}}
    @include('partials.header')

    {{-- CONTENU PRINCIPAL --}}
    <main>
        @include('components.alerts')
        @yield('content')
    </main>

    {{-- FOOTER --}}
    @include('partials.footer')

    {{-- JS personnalisé (optionnel) --}}
    @stack('js')
</body>
</html>