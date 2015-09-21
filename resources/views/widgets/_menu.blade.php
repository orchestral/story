@inject('foundation', 'orchestra.app')

<ul class="nav navbar-nav">
	<li class="{!! $foundation->is('orchestra::storycms/posts*') ? 'active' : '' !!}">
		<a href="{!! handles('orchestra::storycms/posts') !!}">Posts</a>
	</li>
	<li class="{!! $foundation->is('orchestra::storycms/pages*') ? 'active' : '' !!}">
		<a href="{!! handles('orchestra::storycms/pages') !!}">Pages</a>
	</li>
</ul>
<ul class="nav navbar-nav pull-right">
	<li>
		<a href="{!! handles('orchestra/story::/') !!}" target="_blank">View Website</a>
	</li>
</ul>
