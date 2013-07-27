@include('orchestra/story::widgets.menu')

<?php echo Form::model($content, array('url' => $url, 'method' => $method, 'class' => 'form-horizontal')); ?>
	<?php echo Form::hidden('type'); ?>
	<?php echo Form::hidden('format'); ?>
	<fieldset>
		<div class="form-group<?php echo $errors->has('title') ? ' has-error': ' '; ?>">
			<label class="two columns control-label" for="title">Title</label>
			<div class="ten columns">
				<?php echo Form::text('title', null, array('id' => 'title', 'class' => 'form-control')); ?>
				<?php echo $errors->first('title', '<p class="help-block error">:message</p>'); ?>
			</div>
		</div>

		<div class="form-group<?php echo $errors->has('slug') ? ' has-error': ' '; ?>">
			<label class="two columns control-label" for="slug">Slug</label>
			<div class="ten columns">
				<?php echo Form::text('slug', null, array('role' => 'slug-editor', 'class' => 'form-control')); ?>
				<?php echo $errors->first('slug', '<p class="help-block error">:message</p>'); ?>
			</div>
		</div>

		<div class="form-group<?php echo $errors->has('content') ? ' has-error': ' '; ?>">
			<div class="twelve columns">
				<?php echo Form::textarea('content', null, array('class' => 'form-control')); ?>
				<?php echo $errors->first('content', '<p class="help-block error">:message</p>'); ?>
			</div>
		</div>
		
		<div class="row">
			<button type="submit" name="status" value="publish" class="btn btn-primary">Save as Publish</button>
			<button type="submit" name="status" value="draft" class="btn">Save as Draft</button>
		</div>
	</fieldset>
<?php echo Form::close(); ?>
