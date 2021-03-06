@extends('layouts.app')

@section('content')
<section class="row">
  <article class="col-md-8">
    <div class="row">
      <div class="col-1">
        <img src="{{ Gravatar::src($post->user->email) }}" width="40" class="rounded-circle" alt="Gavatar">
      </div>
      <div class="col-7">
        <h5>{{ $post->user->name }}</h5>
        <h6 class="mb-2 text-muted">Published on {{ $post->created_at }}</h6>
      </div>
      <div class="col-4">
        @auth
          @if (Auth::user()->id == $post->user_id)
            <a class="btn btn-outline-warning m-0" href="{{ route('posts.edit', $post->id) }}">Update</a>
            <button type="button" class="btn btn-outline-danger" data-toggle="modal" data-target="#postDelete{{ $post->id }}">
              Delete
            </button>
            @include('common.postDelete', ['redirectTo' => 'posts'])
          @endif
        @endauth
      </div>
    </div>
    
    <h1 class="mb-0">{{ $post->title }}</h1>
    <div class="h3 mb-2 text-muted">{{ $post->views }} views</div>
    @if ($post->cover_image)
      <img src="/storage/cover_images/{{ $post->cover_image }}" class="img-fluid" alt="{{ $post->cover_image }}">
    @endif
    <p>{!! $post->body !!}</p>      

    <div class="d-flex w-100 justify-content-between">
      <div>
        @foreach($post->tags as $tag)
          <span style="font-size:18px" class="badge badge-{{ $tag->status }}">{{ $tag->name }}</span>
        @endforeach
      </div>
      <div>
        <span id="like" style="font-size:24px;" 
          @if ($is_liked) class="fa fa-thumbs-up" @else class="fa fa-thumbs-o-up" @endif>
          {{ $post->likes }}
        </span>

        &nbsp;&nbsp;

        <span id="dislike" style="font-size:24px;"
          @if ($is_disliked) class="fa fa-thumbs-down" @else class="fa fa-thumbs-o-down" @endif>
          {{ $post->dislikes }}
        </span>

        <form id="like-form" method="post" action="{{ route('posts.like') }}" style="display:none;">
          @csrf
          <input type="hidden" name="post_id" value="{{ $post->id }}">
        </form>
        <form id="dislike-form" method="post" action="{{ route('posts.dislike') }}" style="display:none;">
          @csrf
          <input type="hidden" name="post_id" value="{{ $post->id }}">
        </form>
      </div>
    </div>
          
    <br><br>
    
    {{-- Display comments --}}
    <p><span class="fa fa-comments"> {{ $post->comments }} Comments</span></p>
    @forelse ($post->comment_set as $comment)
    <div class="card mb-3">
      <div class="card-body">
        <div class="row">
          <div class="col-1">
            <img src="{{ Gravatar::src($comment->user->email) }}" width="40" class="rounded-circle" alt="Gravatar">
          </div>
          <div class="col-9">
            <h5 class="card-title">{{ $comment->user->name }}</h5>
            <h6 class="card-subtitle text-muted mb-2">Published on {{ $comment->created_at }}</h6>
            <p class="card-text">{{ $comment->body }}</p>
          </div>
          <div class="col-2">
            @auth
              @if (Auth::user()->id == $comment->user_id)
                <button class="btn btn-sm btn-outline-danger" type="button" data-toggle="modal" data-target="#commentDelete{{ $comment->id }}">
                  Delete
                </button>
                @include('common.commentDelete', ['redirectTo' => 'posts/'.$post->id])
              @endif
            @endauth
          </div>
        </div>
      </div>
    </div>   
    @empty
    <div class="card border-info">
      <div class="card-body text-info">
        <p class="card-text">Comments Lists is Empty</p>
      </div>
    </div>
    @endforelse
    
    <br>

    <form action="{{ route('comments.store') }}" method="post">
      @csrf
      <input type="hidden" name="post_id" value="{{ $post->id }}">
      <div class="form-group">
        <label for="body" class="font-weight-bold">Enter your comments</label>
        <textarea id="body" class="form-control" name="body" rows="3"></textarea>
      </div>
      <button class="btn btn-primary" type="submit">Submit</button>
    </form>

  </article> <!-- /.col-8 -->
  <aside class="col-md-4">
    @include('common.sidebar')
  </aside>
</section> <!-- /.row -->
@endsection

@section('script')
<script src="{{ asset('js/like.js') }}"></script>
@endsection
