@include('orchestra/story::widgets.menu')

{{ Form::model($content, array('url' => $url, 'method' => $method, 'class' => 'form-horizontal')) }}
	{{ Form::hidden('type') }}
	{{ Form::hidden('format') }}
	<fieldset>
		<div class="form-group{{ $errors->has('title') ? ' has-error': ' ' }}">
			<label class="two columns control-label" for="title">Title</label>
			<div class="ten columns">
				{{ Form::text('title', null, array('id' => 'title', 'class' => 'form-control')) }}
				{{ $errors->first('title', '<p class="help-block error">:message</p>') }}
			</div>
		</div>

		<div class="form-group{{ $errors->has('slug') ? ' has-error': ' ' }}">
			<label class="two columns control-label" for="slug">Slug</label>
			<div class="ten columns">
				{{ Form::text('slug', null, array('role' => 'slug-editor', 'class' => 'form-control')) }}
				{{ $errors->first('slug', '<p class="help-block error">:message</p>') }}
			</div>
		</div>

		<div class="form-group{{ $errors->has('content') ? ' has-error': ' ' }}">
			<div class="twelve columns">
				{{ Form::textarea('content', null, array('class' => 'form-control')) }}
				{{ $errors->first('content', '<p class="help-block error">:message</p>') }}
			</div>
		</div>

		<div class="row">
			<button type="submit" name="status" value="publish" class="btn btn-primary">Save as Publish</button>
			<button type="submit" name="status" value="draft" class="btn">Save as Draft</button>
		</div>
	</fieldset>
{{ Form::close() }}
