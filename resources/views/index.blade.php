@extends('layouts.app')

@section('title', 'Index Page')

@section('style')
  p { font-size: 0.9rem; }
@endsection

@section('content')
  <div class="container">
<div class="jumbotron bg-dark text-light">
    <h1 class="display-3">Hello, world!</h1>
    <p>This is a template for a simple marketing or informational website. It includes a large callout called a jumbotron and three supporting pieces of content. Use it as a starting point to create something more unique.</p>
		<p class="lead"><a class="text-light" href="#" role="button">Learn more &raquo;</a></p>
  </div>
</div>
<div class="container">
  <!-- Example row of columns -->
  <div class="row">
  <div class="card-columns">
    @foreach ($posts as $post)
    <div class="card">
      <div class="card-header">
        <small class="text-muted">Last updated at @date($post->updated_at)</small>
      </div>
      <div class="card-body">
        @foreach($post->tags as $tag)
          <span class="btn btn-sm btn-outline-{{ $tag->status }} mb-2">{{ $tag->name }}</span>
        @endforeach
        <h5 class="card-title">{{ $post->title }}</h5>
        <div class"card-text">{!! $post->body !!}</div>
        <p class="card-text">
          <a class="btn btn-secondary" href="{{ route('posts.show', $post->id) }}" role="button">
            View details &raquo;
          </a>
        </p>
      </div>
    </div>
    @endforeach
  </div> <!-- /.card-coluns -->
  </div> <!-- /row -->

  <hr>

</div> <!-- /container -->
@endsection
