<!DOCTYPE html lang="ru">
@php
if (session('theme') == null)
{
session(['theme' => 'app']);
}
@endphp

<head>
    <link rel="stylesheet" href="/css/app.css?v=<?php echo filectime('css/app.css'); ?>">
    <link rel="stylesheet" href="/css/{{ session('theme') }}.css" id="theme-link">
    <link rel="stylesheet" href="{{ asset('css/font-awesome/all.min.css') }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="pragma" content="no-cache">
    <meta http-equiv="Refresh" content="300" />
    @toastr_css
    <title>@yield('title')</title>
</head>

<body class="main_page">
    <a id="button"></a>

    @include('inc.header')
    <div class="container-fluid">
        @include('inc.messages')
        <div class="row">
            @if(session('theme') == 'dark')
            <div class="col-md-2 col-lg-2 navbar-container bg-dark" id="left-panel">
                @else
                <div class="col-md-2 col-lg-2 navbar-container bg-light" id="left-panel">
                    @endif
                    @yield('categories')
                    <div class="col-md-10 col-lg-10 content-container">
                        <!-- Основной контент страницы  -->
                        @yield('content')
                    </div>
                </div>
            </div>
            @php
            $time_end = microtime(true);
            $time = $time_end - LARAVEL_START;
            if (Auth::check())
            {
            printf('Скрипт выполнялся %.4F сек.', $time);
            }
            @endphp
</body>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"
    integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<!-- подключение popper.js, необходимого для корректной работы некоторых плагинов Bootstrap 4 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
    integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous">
</script>
<script type="text/javascript" src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/mixitup/3.3.1/mixitup.min.js"
    integrity="sha512-nKZDK+ztK6Ug+2B6DZx+QtgeyAmo9YThZob8O3xgjqhw2IVQdAITFasl/jqbyDwclMkLXFOZRiytnUrXk/PM6A=="
    crossorigin="anonymous"></script>
<script src="{{ asset('css/font-awesome/all.min.js') }}" data-auto-replace-svg></script>
<script async type="text/javascript" src="{{ asset('js/common.js') }}?v=<?php echo filectime('js/common.js'); ?>">
</script>
<script async type="text/javascript" src="{{ asset('js/theme.js') }}?v=<?php echo filectime('js/theme.js'); ?>">
</script>

@toastr_js
@toastr_render

</html>
