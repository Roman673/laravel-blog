@extends('layouts.app')

@section('title', $post->title)

@section('content')
<div class="container">
	<nav aria-label="breadcrumb">
  	<ol class="breadcrumb">
    	<li class="breadcrumb-item"><a href="{{ route('index') }}">Home</a></li>
    	<li class="breadcrumb-item"><a href="{{ route('posts.index') }}">Posts</a></li>
    	<li class="breadcrumb-item active" aria-current="page">{{ $post->title }}</li>
  	</ol>
	</nav>
  <div class="row">
    <div class="col-8">
      <h2 class="display-4 mb-0">{{ $post->title }}</h2>
      <p class="text-muted">@date($post->created_at) by {{ $post->user->name }}</p>
      {!! $post->body !!}
      <hr>
      <a class="btn btn-outline-warning" href="{{ route('posts.edit', $post->id) }}">Update</a>
			<button type="button" class="btn btn-outline-danger" data-toggle="modal" data-target="#delete">
  			Delete
			</button>
      <div class="modal fade" id="delete" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Deleting Post</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <p>Are you sure you want to delete post {{ $post->title }}?</p>
            </div>
            <div class="modal-footer">
              <form action="{{ route('posts.destroy', $post->id) }}" method="post">
                @csrf
                @method('DELETE')
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-danger">Delete post</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
