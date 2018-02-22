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
  
  <div class="row justify-content-between">
    <div class="col-md-9">
  @forelse ($posts as $post)
  <div class="card mb-3">
    <div class="card-body">
      @foreach($post->tags as $tag)
        <span class="badge badge-{{ $tag->status }}">{{ $tag->name }}</span>
      @endforeach
      <h2 class="card-title mb-0"><a href="{{ route('posts.show', $post->id) }}">{{ $post->title }}</a></h2>
    </div>
    <div class="card-footer text-muted">
      Create at @date($post->created_at)
      <i>&#x2022;</i>
      {{ $post->user->name }}
      <i>&#x2022;</i>
      <i class="fa fa-comment"></i> {{ $post->comments->count() }}
      <i>&#x2022;</i>
      <i class="fa fa-thumbs-o-up"></i> {{ $post->likes }}
      <i>&#x2022;</i>
      <i class="fa fa-thumbs-o-down"></i> {{ $post->dislikes }}
      <i>&#x2022;</i>
      <i class="fa fa-eye"></i> {{ $post->views }}
      <i>&#x2022;</i>
    </div>
  </div>
  @empty
    <p>Posts List is Empty</p>
  @endforelse
    </div> <!-- /.col-md-8 -->
    <div class="col-md-3">
      <div class="list-group text-center">
        <a class="list-group-item list-group-item-action active" href="#">List group item 01</a>
        <a class="list-group-item list-group-item-action" href="#">List group item 02</a>
        <a class="list-group-item list-group-item-action" href="#">List group item 03</a>
        <a class="list-group-item list-group-item-action" href="#">List group item 04</a>
        <a class="list-group-item list-group-item-action" href="#">List group item 05</a>
      </div>
    </div>
  </div> <!-- /.row -->

  {{ $posts->links() }}
</div>
@endsection
