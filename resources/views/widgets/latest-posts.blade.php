<div class="dashboard__comments">
  @foreach($posts as $post)
  <div class="dashboard-comments__item">
    @if(app()->bound('orchestra.avatar'))
    <div class="dashboard-comments__avatar">
      <img src="{{ app('orchestra.avatar')->user($post->author)->setSize(55)->render() }}" alt="...">
    </div>
    @endif
    <div class="dashboard-comments__body">
      <h5 class="dashboard-comments__sender">
        {{ $post->author->fullname }} <small>{{ $post->published_at->diffForHumans() }}</small>
      </h5>
      <div class="dashboard-comments__content">
        <a href="{{ $post->url() }}">{{ $post->title }}</a>
      </div>
    </div>
  </div>
  @endforeach
</div>
