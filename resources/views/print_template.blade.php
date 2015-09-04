<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	{!! Html::style('bootstrap/css/bootstrap.min.css') !!}
	
	<link href="{{ asset('bootstrap/css/bootstrap-theme.css') }}" rel="stylesheet">

	<!-- Fonts -->
	<link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>
</head>
<body role="document">

	@yield('content')

</body>
</html>
