<?php echo '<?xml version="1.0"?>'; ?>
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
	<channel>
		<title>{{ memorize('site.name') }}</title>
		<link>{!! handles('orchestra/story::/') !!}</link>
		<atom:link href="{!! handles('orchestra/story::rss') !!}" rel="self" type="application/rss+xml" />
		<description>{{ memorize('site.description') }}</description>
		<copyright>{!! handles('orchestra/story::/') !!}</copyright>
		<ttl>30</ttl>

		@foreach ($posts as $post)
			<item>
				<title>{!! $post->title !!}</title>
				<description>
					<![CDATA[{!! $post->body !!}]]>
				</description>
				<link>{!! $post->url() !!}</link>
				<guid isPermaLink="true">{!! $post->url() !!}</guid>
				<pubDate>{!! $post->published_at->toATOMString() !!}</pubDate>
			</item>
		@endforeach
	</channel>
</rss>
