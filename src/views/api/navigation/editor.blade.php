@include('orchestra/story::widgets.menu')
<script type="text/javascript">
$(function(){
	$("#link_type").change(function(){
		var link_type = $(this).val();
		$(".link_type").hide();
		$("#"+link_type).show();

	}).change();
	$("#navigation_group").change(function(){
		var group_id = $(this).val();
		if(group_id > 0)
		{
			$.post("{{{ resources("storycms.navigations/ajaxNavGroupList") }}}", {'group':group_id}, function(d){
				alert(d);
			});
		}

	}).change();
});
</script>
{{ Form::model($navigation, array('url' => $url, 'method' => $method, 'class' => 'form-horizontal')) }}

{{ Form::hidden('navigation_group_id', $navigation_group_id); }}
	<fieldset>
		<!-- Title -->
				<div class="form-group {{{ $errors->has('title') ? 'has-error' : '' }}}">
					<label class="control-label col-lg-2" for="title">Title</label>
					<div class="col-lg-6">
						{{ Form::text('title', Input::old('title', isset($navigation) ? $navigation->title : null), array('class' => 'form-control ')) }}
						<span class="help-inline">{{{ $errors->first('title', ':message') }}}</span>
					</div>
				</div>
				<!-- ./ Title -->

				<!-- navigation navigation_group_id -->
				<!-- <div class="form-group {{{ $errors->has('navigation_group_id') ? 'has-error' : '' }}}">
					<label class="control-label col-lg-2" for="navigation_group_id">Navigation group</label>
					<div class="col-lg-6">
						{{ Form::select('navigation_group_id', array('' => 'Select Group') + (array)$navigationGroupList, Input::old('navigation_group_id', isset($navigation) ? $navigation->navigation_group_id : ''), array('class' => 'form-control ', 'id' => 'navigation_group')); }}
						<span class="help-inline">{{{ $errors->first('navigation_group_id', ':message') }}}</span>
					</div>
				</div> -->
				<!-- ./ navigation navigation_group_id -->

				<!-- navigation parent -->
				<div class="form-group {{{ $errors->has('parent') ? 'has-error' : '' }}}">
					<label class="control-label col-lg-2" for="parent">Parent</label>
					<div class="col-lg-6">
						{{ Form::select('parent', array('' => 'Select Parent') + $navList, isset($navigation) ? $navigation->parent  : '', array('class' => 'form-control ')) }}
						<span class="help-inline">Do not select if this navigation is not under other navigation.</span>
						<span class="help-inline">{{{ $errors->first('parent', ':message') }}}</span>
					</div>
				</div>
				<!-- ./ navigation parent -->

				<!-- navigation link_type -->
				<div class="form-group {{{ $errors->has('link_type') ? 'has-error' : '' }}}">
					<label class="control-label col-lg-2" for="link_type">Link type</label>
					<div class="col-lg-6">
						{{ Form::select('link_type', array('page' => 'Page', 'url' => 'External Link', 'uri' => 'Site Link'), Input::old('link_type', isset($navigation) ? $navigation->link_type : ''), array('id' => 'link_type', 'class' => 'form-control ')) }}
						<span class="help-inline">{{{ $errors->first('link_type', ':message') }}}</span>
					</div>
				</div>
				<!-- ./ navigation link_type -->

				<!-- navigation page_id -->
				<div id="page" style="display: none;" class="form-group link_type {{{ $errors->has('page_id') ? 'has-error' : '' }}}">
					<label class="control-label col-lg-2" for="page_id">Page</label>
					<div class="col-lg-6">
						{{ Form::select('page_id', array('' => 'Select Page') + $pageList, Input::old('page_id', isset($navigation) ? $navigation->page_id : ''), array('class' => 'form-control ')) }}
						<span class="help-inline">{{{ $errors->first('page_id', ':message') }}}</span>
					</div>
				</div>
				<!-- ./ navigation page_id -->

				<!-- URL -->
				<div id="url" style="display: none;" class="form-group link_type {{{ $errors->has('url') ? 'has-error' : '' }}}">
					<label class="control-label col-lg-2" for="url">URL</label>
					<div class="col-lg-6">
						{{ Form::text('url', Input::old('url', isset($navigation) ? $navigation->url : null), array('class' => 'form-control ')) }}
						<span class="help-inline">{{{ $errors->first('url', ':message') }}}</span>
					</div>
				</div>
				<!-- ./ URL -->

				<!-- URL -->
				<div id="uri" style="display: none;" class="form-group link_type {{{ $errors->has('uri') ? 'has-error' : '' }}}">
					<label class="control-label col-lg-2" for="uri">URI</label>
					<div class="col-lg-6">
						{{ Form::text('uri', Input::old('uri', isset($navigation) ? $navigation->uri : null), array('class' => 'form-control ')) }}
						<span class="help-inline">{{{ $errors->first('uri', ':message') }}}</span>
					</div>
				</div>
				<!-- ./ URL -->

				<!-- navigation target -->
				<div class="form-group {{{ $errors->has('target') ? 'has-error' : '' }}}">
					<label class="control-label col-lg-2" for="target">Target</label>
					<div class="col-lg-6">
						{{ Form::select('target', array('selected'=>'Self', '_blank' => 'Blank Page'), Input::old('page_id', isset($navigation) ? $navigation->target : ''), array('class' => 'form-control ')) }}
						<span class="help-inline">{{{ $errors->first('target', ':message') }}}</span>
					</div>
				</div>
				<!-- ./ navigation target -->

				<!-- Css Class -->
				<div class="form-group {{{ $errors->has('class') ? 'has-error' : '' }}}">
					<label class="control-label col-lg-2" for="class">Class</label>
					<div class="col-lg-6">
						{{ Form::text('class', Input::old('class', isset($navigation) ? $navigation->class : null), array('class' => 'form-control ')) }}
						<span class="help-inline">The class will be appended on navigation class attribute</span>
						<span class="help-inline">{{{ $errors->first('class', ':message') }}}</span>
					</div>
				</div>
				<!-- ./ Css Class -->

		<div class="row">
			<button type="submit" name="status" value="publish" class="btn btn-primary">Save Navigation</button>
		</div>
	</fieldset>
{{ Form::close() }}
