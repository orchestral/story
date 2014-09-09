@include('orchestra/story::widgets.menu')

<?php

use Illuminate\Support\Facades\Auth;
use Orchestra\Support\Facades\Acl;
use Orchestra\Support\Facades\Site;
use Orchestra\Support\Str;

$acl  = Acl::make('orchestra/story');
$auth = Auth::user();

if ($acl->can("create {$type}") or $acl->can("manage {$type}")) :
	Site::set('header::add-button', true);
endif; ?>

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
			@if ($contents->isEmpty())
				<tr>
					<td colspan="5">No records at the moment.</td>
				</tr>
			@else
			@foreach ($contents as $content)
				<? $owner = ($content->user_id === $auth->id); ?>
				<? $status = Str::title($content->status); ?>
				<tr>
					<td>
						<strong>
							@if ($acl->can("manage {$content->type}") or ($owner and $acl->can("update {$content->type}")))
							<a href="{!! resources("storycms.{$type}s/{$content->id}/edit") !!}">
								{{ $content->title }}
							</a>
							@else
							{{ $content->title }}
							@endif
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
						@if ($acl->can("manage {$content->type}") or ($owner and $acl->can("delete {$content->type}")))
							<a href="{!! resources("storycms.{$type}s/{$content->id}/delete") !!}" class="btn btn-mini btn-danger">
								Delete
							</a>
						@endif
						</div>
					</td>
				</tr>
			@endforeach
			@endif
			</tbody>
		</table>

		{!! $contents->links() !!}
	</div>
</div>
