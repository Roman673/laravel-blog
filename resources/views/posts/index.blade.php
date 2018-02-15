@extends('layouts.app')

@section('title', 'Posts')

@section('content')
<div class="container">
	<nav aria-label="breadcrumb">
  	<ol class="breadcrumb">
    	<li class="breadcrumb-item"><a href="{{ route('index') }}">Home</a></li>
    	<li class="breadcrumb-item active" aria-current="page">Posts</li>
  	</ol>
	</nav>
  @forelse ($posts as $post)
  <div class="row">
    <div class="col-8">
      <h2 class="display-4 mb-0">{{ $post->title }}</h2>
      <p class="text-muted"><small>@date($post->created_at) by {{ $post->user->name }}</small></p>
      {!! $post->body !!}
      <p><a class="btn btn-primary" href="{{ route('posts.show', $post->id) }}">Read more &raquo;</a>
    </div>
  </div>
  @empty
    <p>Posts List is Empty</p>
  @endforelse

  {{ $posts->links() }}
</div>
@endsection
