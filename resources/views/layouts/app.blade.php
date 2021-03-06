<!doctype html>
<html lang="{{ app()->getLocale() }}">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<meta name="csrf-token" content="{{ csrf_token() }}">

		<title>{{ $title }} - {{ config( 'app.name' ) }}</title>

		<link href="/css/app.css" rel="stylesheet" type="text/css">
	</head>
	<body>
		@include('partials.nav-main')

		<div id="app">

			<div class="app-container">
				@include('partials.alert')

				@include('partials.nav-top')

				@include('partials.nav-sec')

				<div id="content" class="container">
					@yield('content')
				</div>

			</div>

		</div>

		<script type="text/javascript" src="/js/app.js"></script>

		@stack('scripts')

	</body>
</html>
