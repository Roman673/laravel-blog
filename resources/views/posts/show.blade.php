@extends('layouts.app')

@section('title', $post->title)

@section('style')
 .like-style { font-size: 24px; }
@endsection

@section('content')
<div class="container">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('index') }}">Home</a></li>
      <li class="breadcrumb-item"><a href="{{ route('posts.index') }}">Posts</a></li>
      <li class="breadcrumb-item active" aria-current="page">{{ $post->title }}</li>
    </ol>
  </nav>
  <div class="row justify-content-md-center">
    <div class="col-8">
      <div class="row justify-content-between">
        <div class="col-1">
          <img src="{{ Gravatar::src($post->user->email) }}" width="40" class="rounded-circle" alt="Gavatar">
        </div>
        <div class="col-8">
          <div class="h4 mb-0">{{ $post->user->name }}</div>
          <div class="text-muted">Published on {{ $post->created_at }}</div>
        </div>
        <div class="col-3">
	        @auth
	          @if (Auth::user()->id == $post->user_id)
		          <a class="btn btn-outline-warning m-0" href="{{ route('posts.edit', $post->id) }}">Update</a>
		          <button type="button" class="btn btn-outline-danger" data-toggle="modal" data-target="#postDelete{{ $post->id }}">
		            Delete
		          </button>
	            @include('common.postDelete', ['redirectTo' => 'posts'])
	          @endif
	        @endauth
        </div> <!-- /.col -->
      </div> <!-- /.row -->
      <hr>
      @foreach($post->tags as $tag)
        <span class="badge badge-{{ $tag->status }}">{{ $tag->name }}</span>
      @endforeach
      <h2 class="mb-0">{{ $post->title }}</h2>
      <p class="text-muted">{{ $post->views }} views</p>
      <div class="text-justify">{!! $post->body !!}</div>
      
      <hr>

      <!-- Likes buttons -->
      <i
        id="like"
	      style="font-size:24px;" 
      @if ($is_liked)
	      class="fa fa-thumbs-up"
      @else
	      class="fa fa-thumbs-o-up"
      @endif
      > {{ $post->likes }}</i>
      &nbsp;&nbsp;
      <!-- dislike button -->
      <i 
        id="dislike"
	      style="font-size:24px;"
      @if ($is_disliked)
	      class="fa fa-thumbs-down"
      @else
	      class="fa fa-thumbs-o-down"
      @endif
      > {{ $post->dislikes }}</i>

      <form id="like-form" method="post" action="{{ route('posts.like') }}" style="display:none;">
	      @csrf
	      <input type="hidden" name="post_id" value="{{ $post->id }}">
      </form>
      <form id="dislike-form" method="post" action="{{ route('posts.dislike') }}" style="display:none;">
	      @csrf
	      <input type="hidden" name="post_id" value="{{ $post->id }}">
      </form>
      <!-- end like button -->
      
      <br><br>
      <p>{{ $post->comments->count() }} Comments</p>
      @auth
      <!-- Comment Create -->
      <form action="{{ route('comments.store') }}" method="post" class="mb-3">
        @csrf
        <input type="hidden" name="post_id" value="{{ $post->id }}">
        <div class="input-group">
          <input class="form-control" name="body" type="text" placeholder="Add a public comment...">
          <div class="input-group-append">
            <button class="btn btn-outline-secondary" type="submit">Submit</button>
          </div>
        </div>
      </form>
      @endauth

      @forelse ($comments as $comment)
        <hr>
        <div class="row justify-content-between">
          <div class="col-md-1">
            <img src="{{ Gravatar::src($comment->user->email) }}" width="50" class="rounded-circle" alt="Gravatar">
          </div> <!-- /.col-md-2 -->
          <div class="col-md-9">
            <div class="h5 mb-0"><b>{{ $comment->user->name }}</b></div>
            <p class="card-text mt-0"><small class="text-muted">Published on {{ $comment->created_at }}</small></p>
            <p class="card-text">{{ $comment->body }}</p>
          </div> <!-- /.col-md-7 -->
          <div class="col-md-2">
            @auth
	            @if (Auth::user()->id == $comment->user_id)
                <button class="btn btn-sm btn-outline-danger" type="button" data-toggle="modal" data-target="#commentDelete{{ $comment->id }}">
                  Comment delete
                </button>
                @include('common.commentDelete', ['redirectTo' => 'posts/'.$post->id])
              @endif
            @endauth
          </div> <!-- /.col-md-2 -->
        </div> <!-- /.row -->
      @empty
        <p>Comments Lists is Empty</p>
      @endforelse
    </div> <!-- /.col-8 -->
  </div> <!-- /.row -->
</div> <!-- /.container -->
@endsection

@section('script')
  $(document).ready(function() {
    // like submit
    $( "#like" ).click(function() {
      $( "#like-form" ).submit();
    });
    // dislike submit
    $( "#dislike" ).click(function() {
      $( "#dislike-form" ).submit();
    });
  });
@endsection
