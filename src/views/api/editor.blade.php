<?php echo Form::open(array('url' => resources('storycms.posts'), 'method' => 'post', 'class' => 'form-horizontal')); ?>
	<div class="row">
		<label class="col-lg-2 control-label" for="title">Title</label>
		<div class="col-lg-10">
			<?php echo Form::text('title', Input::old('title')); ?>
		</div>
	</div>

	<div class="row">
		<label class="col-lg-2 control-label" for="slug">Slug</label>
		<div class="col-lg-10">
			<?php echo Form::text('slug', Input::old('slug')); ?>
		</div>
	</div>

	<div class="row">
		<div class="col col-lg-12">
			<?php echo Form::textarea('content'); ?>
		</div>
	</div>

<?php echo Form::close(); ?>
