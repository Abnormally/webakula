<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Заголовок страницы')</title>
    <meta name="description" content="@yield('description', 'Описание страницы')">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @yield('stylesheets')
</head>

<body>
    <header role="navigation">
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
        <script src="{{ asset('js/app.js') }}"></script>
        @yield('scripts')
    </div>
</body>

</html>
