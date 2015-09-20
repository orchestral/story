#{{ $navbar = new Illuminate\Support\Fluent([
	'id'    => 'story',
	'title' => 'Story CMS',
	'url'   => handles('orchestra::storycms'),
	'menu'  => view('orchestra/story::widgets._menu'),
]) }}

@decorator('navbar', $navbar)

<br>
