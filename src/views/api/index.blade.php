@include('orchestra/story::widgets.menu')

<?php 

use Orchestra\Support\Str;
use Orchestra\Support\Facades\Site;

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
			<?php else : foreach ($contents as $content) : ?>
				<tr>
					<td><?php echo e($content->title); ?></td>
					<td><?php echo e($content->author->fullname); ?></td>
					<td><?php echo Str::title($content->format); ?></td>
					<td><?php echo Str::title($content->status); ?></td>
					<td></td>
				</tr>
			<?php endforeach; endif; ?>
			</tbody>
		</table>
	</div>
</div>
