<!DOCTYPE html lang="ru">
<head>
	<link rel="stylesheet" href="/css/app.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>@yield('title')</title>
</head>
<body>
	@include('inc.header')
	<div class="container">
		@include('inc.messages')
        <!-- Основной контент страницы  -->
        	@yield('content')

    </div>
</body>
<script
  src="https://code.jquery.com/jquery-3.5.1.min.js"
  integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
  crossorigin="anonymous"></script>
<script type="text/javascript" src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>


@yield('scripts')
</html>
