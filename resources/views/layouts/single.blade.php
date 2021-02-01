<!DOCTYPE html lang="ru">

<head>
    <link rel="stylesheet" href="/css/app.css?v=<?php echo filectime('css/app.css'); ?>">
    <link rel="stylesheet" href="/css/{{ session('theme') }}.css" id="theme-link">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Refresh" content="300" />
    @toastr_css
    <title>@yield('title')</title>
</head>

<body>
    @include('inc.header')
    <div class="container mt-5">
        @include('inc.messages')
        <div class="row">
            <div class="col-md-12 col-lg-12 content-container">
                <!-- Основной контент страницы  -->
                @yield('content')
            </div>
        </div>
    </div>
    </div>
    @include('inc.footer')
</body>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"
    integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script type="text/javascript" src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
<script async type="text/javascript"
    src="{{ asset('js/ajax.js') }}?v=<?php echo filectime('js/ajax.js'); ?>"></script>
<<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mixitup/3.3.1/mixitup.min.js"
        integrity="sha512-nKZDK+ztK6Ug+2B6DZx+QtgeyAmo9YThZob8O3xgjqhw2IVQdAITFasl/jqbyDwclMkLXFOZRiytnUrXk/PM6A=="
        crossorigin="anonymous"></script>
    @toastr_js
    @toastr_render
    <script type="text/javascript" src="{{ asset('js/check.js') }}"></script>
    @yield('scripts')

    </html>
