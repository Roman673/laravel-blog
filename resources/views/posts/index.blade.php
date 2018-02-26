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
    <div class="card-body">
      @foreach($post->tags as $tag)
        <span class="badge badge-{{ $tag->status }}">{{ $tag->name }}</span>
      @endforeach
      <h2 class="card-title mb-0"><a href="{{ route('posts.show', $post->id) }}">{{ $post->title }}</a></h2>
    </div>
    <div class="card-footer text-muted">
      <span>Create at @date($post->created_at)</span>
      <span>&#x2022;</span>
      <span>{{ $post->user->name }}</span>
      <span>&#x2022;</span>
      <span class="fa fa-comment"> {{ $post->comments->count() }}</span>
      <span>&#x2022;</span>
      <span class="fa fa-thumbs-o-up"> {{ $post->likes }}</span>
      <span>&#x2022;</span>
      <span class="fa fa-thumbs-o-down"> {{ $post->dislikes }}</span>
      <span>&#x2022;</span>
      <span class="fa fa-eye"> {{ $post->views }}</span>
      <span>&#x2022;</span>
    </div>
  </div>
  @empty
    <p>Posts List is Empty</p>
  @endforelse
  </div> {{-- /.col-md-8 --}}
  <aside class="col-md-4">
    @include('common.sidebar')
  </aside>
</section>
  {{ $posts->links() }}
@endsection
