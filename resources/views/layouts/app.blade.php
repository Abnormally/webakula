<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Заголовок страницы')</title>
    <meta name="description" content="@yield('description', 'Описание страницы')">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/font-awesome.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/noty.css') }}">
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
        <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/noty.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/validator.min.js') }}"></script>
        @if(Auth::user()->role > 2)
        <script type="text/javascript">
            $(document).ready(function () {
                $.get("{{ route('admin.getbadges') }}", [], function (data) {
                    data = JSON.parse(data);

                    var badges = {
                        waiting: $('#posts-new'),
                        published: $('#posts-published'),
                        hidden: $('#posts-hidden')
                    };

                    for (var i = 0; i < data.length; i++) {
                        if (data[i].status === 0) {
                            badges.waiting.empty().append(data[i].total);
                        } else if (data[i].status === 2) {
                            badges.published.empty().append(data[i].total);
                        } else if (data[i].status === 3) {
                            badges.hidden.empty().append(data[i].total);
                        }
                    }
                });
            });
        </script>
        @endif
        @yield('scripts')
    </div>
</body>

</html>
