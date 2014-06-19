@include('orchestra/story::widgets.menu')
	{{-- Edit Page Form --}}
	{{ Form::model($navigationGroup, array('url' => $url, 'method' => $method, 'class' => 'form-horizontal')) }}
	{{ Form::hidden('type') }}

		<!-- Tabs Content -->
		<div class="tab-content">
			<!-- General tab -->
			<div class="tab-pane active" id="tab-general">
				<!-- Post Title -->
				<div class="form-group {{{ $errors->has('title') ? 'has-error' : '' }}}">
					<label class="control-label col-lg-2" for="title">Group Title</label>
					<div class="col-lg-6">
						{{ Form::text('title', Input::old('title', isset($navigationGroup) ? $navigationGroup->title : null), array('class' => 'form-control input-sm')) }}
						<span class="help-inline">{{{ $errors->first('title', ':message') }}}</span>
					</div>
				</div>
				<!-- ./ navigationGroup abbrev -->

				<!-- Post Title -->
				<div class="form-group {{{ $errors->has('abbrev') ? 'has-error' : '' }}}">
					<label class="control-label col-lg-2" for="abbrev">Group slug</label>
					<div class="col-lg-6">
						{{ Form::text('abbrev', Input::old('abbrev', isset($navigationGroup) ? $navigationGroup->abbrev : null), array('class' => 'form-control input-sm')) }}
						<span class="help-inline">{{{ $errors->first('abbrev', ':message') }}}</span>
					</div>
				</div>
				<!-- ./ navigationGroup abbrev -->

			</div>
			<!-- ./ general tab -->

		</div>
		<!-- ./ tabs content -->

		<!-- Form Actions -->
		<div class="form-group">
			<div class="col-lg-6 col-lg-offset-2">
				<button type="submit" class="btn btn-success">Save group</button>
			</div>
		</div>
		<!-- ./ form actions -->
{{ Form::close() }}
