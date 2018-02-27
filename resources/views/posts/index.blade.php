@extends('layouts.app')

@section('title', 'Posts')

@section('breadcrumb')
<li class="breadcrumb-item active" aria-current="page">Posts</li>
@endsection

@section('content')
<section class="row">
  <div class="col-md-8">
  @forelse ($posts as $post)
    <div class="card mb-3">
      <div class="card-header border-light text-muted">
        <span>@date($post->created_at)</span>
        &nbsp;&nbsp;
        <img src="{{ Gravatar::src($post->user->email) }}" width="20" class="rounded-circle" alt="Gavatar">
        <span>{{ $post->user->name }}</span>
      </div>
      <div class="card-body pb-0">
        @foreach($post->tags as $tag)
          <span class="badge badge-{{ $tag->status }}">{{ $tag->name }}</span>
        @endforeach
        <h2 class="card-title h2 mb-0">
          <b><a href="{{ route('posts.show', $post->id) }}">{{ $post->title }}</a></b>
        </h2>
        <div class="card-text">{!! str_limit($post->body, $limit=150, $end='...') !!}</div>
      </div>
      <div class="card-footer border-light text-muted">
        <div class="d-flex w-100 justify-content-between">
          <div>
            <span class="fa fa-comment"> {{ $post->comments }}</span>
            &nbsp;&nbsp;
            <span class="fa fa-eye"> {{ $post->views }}</span>
          </div>
          <div>
            <span class="fa fa-thumbs-o-up"> {{ $post->likes }}</span>
            &nbsp;&nbsp;
            <span class="fa fa-thumbs-o-down"> {{ $post->dislikes }}</span>
          </div>
        </div>
      </div>
    </div>
  @empty
    <div class="card border-info">
      <div class="card-body text-info">
        <p class="card-text">Post Lists is Empty</p>
      </div>
    </div>
  @endforelse
    {{ $posts->appends(['q' => Request::input('q')])->links() }}
  </div> {{-- /.col-md-8 --}}
  <aside class="col-md-4">
    @include('layouts.subnavbar')
    @include('common.sidebar')
  </aside>
</section>
@endsection
