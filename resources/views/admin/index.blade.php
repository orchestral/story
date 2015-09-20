@extends('orchestra/foundation::layouts.main')

<?php

use Orchestra\Support\Str;
use Orchestra\Story\Model\Content; ?>

@can('create', Content::class, $type)
	@set_meta('header::add-button', true)
@endcan

@section('content')
@include('orchestra/story::widgets.header')

<div class="row">
	<div class="twelve columns white rounded box">
		<table class="table table-striped">
			<thead>
				<tr>
					<th>Title</th>
					<th>Author</th>
					<th class="th-actions">&nbsp;</th>
				</tr>
			</thead>
			<tbody>
			@forelse($contents as $content)
				<tr>
					<td>
						<strong>
							@can('update', $content)
							<a href="{!! $content->editUrl() !!}">
								{{ $content->title }}
							</a>
							@else
							{{ $content->title }}
							@endcan
						</strong>
						<br>
						<span class="meta">
							<span class="label label-default">{{ Str::title($content->format) }}</span>
							<span class="label label-success">{{ Str::title($content->status) }}</span>
						</span>
					</td>
					<td>{{ $content->author->fullname }}</td>
					<td>
						<div class="btn-group">
						@can('delete', $content)
							<a href="{!! $content->deleteUrl() !!}" class="btn btn-mini btn-danger">
								Delete
							</a>
						@endcan
						</div>
					</td>
				</tr>
			@empty
				<tr>
					<td colspan="5">No records at the moment.</td>
				</tr>
			@endforelse
			</tbody>
		</table>

		{!! $contents !!}
	</div>
</div>

@stop
