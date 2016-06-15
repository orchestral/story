@extends('orchestra/foundation::layouts.page')

@section('content')
{{ Form::model($content, ['url' => $url, 'method' => $method, 'class' => 'form-horizontal']) }}
  {{ Form::hidden('type') }}
  {{ Form::hidden('format') }}
  <fieldset>
    <div class="form-group{!! $errors->has('title') ? ' has-error': '' !!}">
      <label class="col-md-2 control-label" for="title">Title</label>
      <div class="col-md-10">
        {{ Form::text('title', null, ['id' => 'title', 'class' => 'form-control', 'v-model' => 'content.title', '@keyup' => 'updateFromTitle']) }}
        {!! $errors->first('title', '<p class="help-block error">:message</p>') !!}
      </div>
    </div>

    <div class="form-group{!! $errors->has('slug') ? ' has-error': ' ' !!}">
      <label class="col-md-2 control-label" for="slug">Slug</label>
      <div class="col-md-10">
        {{ Form::text('slug', null, ['class' => 'form-control', 'v-model' => 'slug', '@blur' => 'updateFromSlug']) }}
        {!! $errors->first('slug', '<p class="help-block error">:message</p>') !!}
      </div>
    </div>

    <div class="form-group{!! $errors->has('content') ? ' has-error': '' !!}">
      <div class="twelve columns">
        {{ Form::textarea('content', null, ['class' => 'form-control', 'id' => 'content']) }}
        {!! $errors->first('content', '<p class="help-block error">:message</p>') !!}
      </div>
    </div>

    <div class="row">
      <div class="col-md-12">
        <button type="submit" name="status" value="publish" class="btn btn-primary">Save as Publish</button>
        <button type="submit" name="status" value="draft" class="btn">Save as Draft</button>
        @if($content->status === 'publish')
        <a href="{!! $content->url() !!}" target="_blank" class="btn btn-link">View Post</a>
        @endif
      </div>
    </div>
  </fieldset>
{{ Form::close() }}
@stop

@push('orchestra.footer')
<script>
  var app

  app = new App({
    data: {
      content: {!! $content->makeVisible('slug')->toJson() !!},
      sluggable: true,
      slug: '',
      sidebar: {
        active: 'storycms-write'
      }
    },

    ready: function() {
      this.sluggable = ! this.$get('content.id') > 0
      this.slug = this.slugify(this.$get('content.slug') || '', '-')
    },

    methods: {
      slugify: function(string, separator) {
        return string.toLowerCase()
          .replace(/^(_post_\/|_page_\/)/g, '')
          .replace(/[^\w\.]+/g, separator)
          .replace(/\s+/g, separator)
      },

      updateFromTitle: function() {
        if (this.sluggable) {
          this.slug = this.slugify(this.content.title, '-')
        }
      },

      updateFromSlug: function() {
        this.sluggable = false
        this.slug = this.slugify(this.slug, '-')
      }
    }
  }).$mount('body')
</script>
@endpush
