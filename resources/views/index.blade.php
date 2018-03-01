@extends('layouts.app')

@section('content')
<div class="jumbotron bg-dark text-light">
  <h1 class="display-3">Hello, world!</h1>
  <p>
    Sit dolorum dicta quod culpa magnam placeat, pariatur sunt. Dignissimos dolor reprehenderit animi suscipit ipsam. Doloremque molestiae perferendis sunt fugit molestias? Repellendus esse possimus labore quo pariatur? Amet aperiam officiis est mollitia animi autem vitae adipisci tempora expedita debitis placeat.
  </p>
	<p class="lead"><a class="text-light" href="#" role="button">Learn more &raquo;</a></p>
</div>

<div class="card-columns">
  @foreach ($posts as $post)
    <div class="card">
      @if ($post->cover_image)
        <img src="/storage/cover_images/{{ $post->cover_image }}" class="card-img-top" alt="{{ $post->cover_image }}">
      @endif
      <div class="card-body">
        @foreach($post->tags as $tag)
          <span class="btn btn-sm btn-outline-{{ $tag->status }} mb-2">{{ $tag->name }}</span>
        @endforeach
        <h5 class="card-title">{{ $post->title }}</h5>
        <div class="card-text">{!! str_limit($post->body, $limit=150, $end='...') !!}</div>
        <p class="card-text">
          <a class="btn btn-secondary" href="{{ route('posts.show', $post->id) }}" role="button">
            View details &raquo;
          </a>
        </p>
      </div>
      <div class="card-footer">
        <small class="text-muted">Last updated at @date($post->updated_at)</small>
      </div>
    </div>
    @endforeach
</div>
@endsection
