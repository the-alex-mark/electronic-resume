<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>

    {{-- Заголовок сайта --}}
    <title>@yield('title', 'Главная') – {{ config('app.name', 'Электронное резюме') }}</title>

    {{-- Настройки страницы --}}
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="MobileOptimized" content="width">
    <meta name="HandheldFriendly" content="true">
    <meta name="description" content="Помогаем бизнесу, решая проблемы безопасности">

    {{-- Индекцация сайта --}}
    @if(!config('app.indexing', true))
        <meta name="robots" content="noindex, nofollow">
    @endif

    {{-- Шрифты --}}
    @stack('fonts')

    {{-- Стили --}}
    <link rel="stylesheet" href="{{ asset('assets/styles/app.css') }}">
    @stack('styles')
</head>
<body>

    {{-- Содержимое страницы --}}
    @yield('content')

    {{-- Модальные окна --}}
    @stack('modals')

    {{-- Скрипты --}}
    <script src="{{ asset('assets/scripts/app.js') }}"></script>
    @stack('scripts')
</body>
</html>
