<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		{!! HTML::title() !!}
		<link href='http://fonts.googleapis.com/css?family=OFL+Sorts+Mill+Goudy+TT' rel='stylesheet' type='text/css'/>
		<link href="{!! asset('packages/orchestra/story/css/style.css') !!}" rel="stylesheet" media="screen">
	</head>
	<body>
		<div class="container">
			@include('orchestra/story::header')

			<div class="content">
				@yield('content')
			</div>
			<footer>
				<p>Powered by Story</p>
			</footer>
		</div>
	</body>
</html>
