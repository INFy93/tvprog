<!DOCTYPE html lang="ru">
<head>
	<link rel="stylesheet" href="/css/app.css?v=<?php echo filectime('css/app.css'); ?>">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
	<link href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" rel="stylesheet">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	@toastr_css
	<title>@yield('title')</title>
</head>
<body>
	<a id="button"></a>

	@include('inc.header')
	<div class="container-fluid">
		@include('inc.messages')
		<div class="row">
			<div class="col-md-2 col-lg-2 navbar-container bg-light">
			 @yield('categories')


		 <div class="col-md-10 col-lg-10 content-container">
        <!-- Основной контент страницы  -->
        	@yield('content')
      </div>



		</div>
	</div>

</body>
<script
  src="https://code.jquery.com/jquery-3.5.1.min.js"
  integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
  crossorigin="anonymous"></script>
	<!-- подключение popper.js, необходимого для корректной работы некоторых плагинов Bootstrap 4 -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
	integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous">
	</script>
<script type="text/javascript" src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
<script type="text/javascript" src="{{ asset('js/moment.js') }}"></script>
<script async type="text/javascript" src="{{ asset('js/ajax.js') }}?v=<?php echo filectime('js/ajax.js'); ?>"></script>
<script type="text/javascript" src="{{ asset('js/mixitup.min.js') }}"></script>
@toastr_js
@toastr_render
</html>
