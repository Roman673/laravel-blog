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
  <div class="card mb-3">
    <div class="card-body">
      <h2 class="card-title mb-0"><a href="{{ route('posts.show', $post->id) }}">{{ $post->title }}</a></h2>
    </div>
    <div class="card-footer text-muted">
      @date($post->created_at)
      <i>&#x2022;</i>
      <i class="fa fa-comment"></i> {{ $post->comments->count() }}
    </div>
  </div>
  @empty
    <p>Posts List is Empty</p>
  @endforelse

  {{ $posts->links() }}
</div>
@endsection
