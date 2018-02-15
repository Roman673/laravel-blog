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
    @foreach ($posts as $post)
    <div class="col-md-4">
      <h2>{{ $post->title }}</h2>
      {!! $post->body !!}
      <p>
        <a class="btn btn-secondary" href="{{ route('posts.show', $post->id) }}" role="button">
          View details &raquo;
        </a>
      </p>
    </div>
    @endforeach
  </div> <!-- /row -->

  <hr>

</div> <!-- /container -->
@endsection
