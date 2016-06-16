@extends('orchestra/foundation::layouts.page')

@php
use Orchestra\Support\Str;
@endphp

@set_meta('header::add-button', $create)

@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="panel panel-default">
      <div class="panel-body">
        <table class="table table-hover">
          <thead>
            <tr>
              <th>Title</th>
              <th>Author</th>
              <th class="th-actions">&nbsp;</th>
            </tr>
          </thead>
          <tbody>
          @forelse($contents as $content)
            <tr>
              <td>
                <strong>
                  @can('update', $content)
                  <a href="{!! $content->editUrl() !!}">
                    {{ $content->title }}
                  </a>
                  @else
                  {{ $content->title }}
                  @endcan
                </strong>
                <br>
                <span class="meta">
                  <span class="label label-default">{{ Str::title($content->format) }}</span>
                  <span class="label label-success">{{ Str::title($content->status) }}</span>
                </span>
              </td>
              <td>{{ $content->author->fullname }}</td>
              <td>
                <div class="btn-group">
                @can('delete', $content)
                  <a href="{!! $content->deleteUrl() !!}" class="btn btn-xs btn-label btn-danger">
                    Delete
                  </a>
                @endcan
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="5">No records at the moment.</td>
            </tr>
          @endforelse
          </tbody>
        </table>


        <div class="row">
          <div class="col-sm-5 col-xs-12 sm-text">
            @if($contents->total() > 0)
            Showing
            @if($contents->firstItem() !== $contents->lastItem())
            {{ $contents->firstItem() }} to {{ $contents->lastItem() }}
            @else
            {{ $contents->lastItem() }}
            @endif
            of {{ $contents->total() }} entries
            @endif
          </div>
          @if($contents->hasPages())
          <div class="col-sm-7 col-xs-12">
            <div class="pull-right">{{ $contents }}</div>
          </div>
          @endif
        </div>
      </div>
    </div>
  </div>
</div>
@stop

@push('orchestra.footer')
<script>
  var app = Platform.make('app').nav('storycms-{{ $type }}s').$mount('body')
</script>
@endpush
