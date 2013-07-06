@include('orchestra/story::widgets.menu')

<?php 

use Illuminate\Support\Facades\Auth;
use Orchestra\Support\Facades\Acl;
use Orchestra\Support\Facades\Site;
use Orchestra\Support\Str;

$acl  = Acl::make('orchestra/story');
$auth = Auth::user(); 
Site::set('header::add-button', true); ?>

<div class="row">
	<div class="col col-lg-12 box white rounded">
		<table class="table table-striped">
			<thead>
				<tr>
					<th>Title</th>
					<th>Author</th>
					<th>Format</th>
					<th>Status</th>
					<th>&nbsp;</th>
				</tr>
			</thead>
			<tbody>
			<?php if ($contents->isEmpty()) : ?>
				<tr>
					<td colspan="5">No records at the moment.</td>
				</tr>
			<?php else : foreach ($contents as $content) : 
				$owner = ($content->user_id === $auth->id); ?>
				<tr>
					<td>
						<a href="<?php echo $content->link; ?>" target="_blank">
							<?php echo e($content->title); ?>
						</a>
					</td>
					<td><?php echo e($content->author->fullname); ?></td>
					<td><?php echo Str::title($content->format); ?></td>
					<td><?php echo Str::title($content->status); ?></td>
					<td>
						<div class="btn-group">
						<?php if ($acl->can("manage {$content->type}") or ($owner and $acl->can("update {$content->type}"))) : ?>
							<a href="<?php echo resources("storycms.{$type}/{$content->id}/edit"); ?>" class="btn btn-mini btn-warning">
								Edit
							</a>
						<?php endif; ?>
						<?php if ($acl->can("manage {$content->type}") or ($owner and $acl->can("delete {$content->type}"))) : ?>
							<a href="<?php echo resources("storycms.{$type}/{$content->id}/delete"); ?>" class="btn btn-mini btn-danger">
								Delete
							</a>
						<?php endif; ?>
						</div>
					</td>
				</tr>
			<?php endforeach; endif; ?>
			</tbody>
		</table>
	</div>
</div>
