@include('orchestra/story::widgets.menu')

<?php echo Form::model($content, array('url' => $url, 'method' => $method, 'class' => 'form-horizontal')); ?>
	<?php echo Form::hidden('type'); ?>
	<?php echo Form::hidden('format'); ?>
	<fieldset>
		<div class="row<?php echo $errors->has('title') ? ' has-error': ' '; ?>">
			<label class="col-lg-2 control-label" for="title">Title</label>
			<div class="col-lg-10">
				<?php echo Form::text('title', null, array('id' => 'title')); ?>
				<?php echo $errors->first('title', '<p class="help-block error">:message</p>'); ?>
			</div>
		</div>

		<div class="row">
			<label class="col-lg-2 control-label" for="slug">Slug</label>
			<div class="col-lg-10">
				<?php echo Form::text('slug', null, array('role' => 'slug-editor')); ?>
			</div>
		</div>

		<div class="row">
			<div class="col col-lg-12">
				<?php echo Form::textarea('content'); ?>
			</div>
		</div>
		
		<div class="row">
			<button type="submit" name="status" value="publish" class="btn btn-primary">Save as Publish</button>
			<button type="submit" name="status" value="draft" class="btn">Save as Draft</button>
		</div>
	</fieldset>
<?php echo Form::close(); ?>
