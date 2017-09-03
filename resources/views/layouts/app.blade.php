<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="theme-color" content="#000">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Заголовок страницы')</title>
    <meta name="description" content="@yield('description', 'Описание страницы')">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/all.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/dl_fix.css') }}">
    @yield('stylesheets')
</head>

<body>
    <header role="navigation" style="margin-bottom: 65px;">
        @include('layouts.partials.header')
    </header>

    <main role="main" id="app">
        @yield('content')
    </main>

    <footer role="contentinfo">
        @include('layouts.partials.footer')
    </footer>

    {{-- Scripts --}}
    <div style="display: none">
        <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/all.js') }}"></script>
        @if(!Auth::guest() && Auth::user()->role > 2)
        <script type="text/javascript" src="{{ asset('js/admin.js') }}"></script>
        @endif
        @yield('scripts')
    </div>
</body>

</html>
