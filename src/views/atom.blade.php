<?php echo '<?xml version="1.0"?>'; ?>
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
	<channel>
		<title>{{ e(memorize('site.name')) }}</title>
		<link>{{ handles('orchestra/story::/') }}</link>
		<atom:link href="{{ handles('orchestra/story::rss') }}" rel="self" type="application/rss+xml" />
		<description></description>
		<copyright>{{ handles('orchestra/story::/') }}</copyright>
		<ttl>30</ttl>

		@foreach ($posts as $post)
			<item>
				<title>{{ $post->title }}</title>
				<description>
					{{ htmlspecialchars($post->body) }}
				</description>
				<link>{{ $post->link }}</link>
				<guid isPermaLink="true">{{ $post->link }}</guid>
				<pubDate>{{ $post->published_at->toATOMString() }}</pubDate>
			</item>
		@endforeach
	</channel>
</rss>
