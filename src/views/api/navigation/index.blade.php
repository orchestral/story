@include('orchestra/story::widgets.menu')

<?

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

			@if ($contents->isEmpty())
				No records at the moment.
			@else
			<div class="panel-group" id="accordion">
			@foreach ($contents as $key => $group)
			<div class="panel panel-default">
				<div class="panel-heading">
					<div class="pull-right">
						<a class="btn btn-primary btn-xs" href="{{{resources('storycms.navigations/'.$group->id.'/create')}}}">Add Link</a> 
						<a class="btn btn-warning btn-xs" href="{{{resources('storycms.navigations.group/'.$group->id.'/edit')}}}">Edit</a> 
						<a class="btn btn-danger btn-xs" href="{{{resources('storycms.navigations.group/'.$group->id.'/delete')}}}">Delete</a> 
					</div>
					<h3 class="panel-title">
						<a data-toggle="collapse" data-parent="#accordion" href="#collapse{{{$key}}}">{{{ $group->title }}} <!-- <small><i class="glyphicon glyphicon-plus"></i></small> --></a>
					</h3>
				</div>
				<div id="collapse{{{$key}}}" class="panel-collapse collapse <?php echo  ($key === 0) ? 'in' : ''; ?>">
					<div class="panel-body">
						<table class="table table-striped">
						<thead>
							<tr>
								<th>ID</th>
								<th>Title</th>
								<th>Parent</th>
								<th class="th-actions">&nbsp;</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($group->navigations as $content)
							<tr>
								<td>{{{ $content->id }}}</td>
								<td>
									<strong>
										@if ($acl->can("manage {$type}") or ($acl->can("update {$type}")))
										<a href="{{ resources("storycms.{$type}s/{$content->id}/edit") }}">
											{{{ $content->title }}}
										</a>
										@else
										{{{ $content->title }}}
										@endif
									</strong>
								</td>
								<td>{{{ $content->parent }}}</td>
								<td>
									<div class="btn-group">
									@if ($acl->can("manage {$type}") or ($owner and $acl->can("delete {$type}")))
										<a href="{{ resources("storycms.{$type}s/{$content->id}/delete") }}" class="btn btn-mini btn-danger">
											Delete
										</a>
									@endif
									</div>
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
			</div>
			@endforeach
			@endif
			</div>
		{{-- $contents->links() --}}
	</div>
</div>
