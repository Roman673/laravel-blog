@extends('layouts.app')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('tags.index') }}">Tags</a></li>
@endsection

@section('content')
<section class="row">
  <div class="col-md-8">
    <a class="btn btn-primary mb-3" href="{{ route('tags.create') }}">Add new tag</a><br>
    @forelse($tags as $tag)
      <a href="{{ route('posts.sortByTag', $tag->id) }}" class="btn btn-outline-{{ $tag->status }}">
        {{ $tag->name }}
      </a>
    @empty
      <p>Tags List is Empry</p>
    @endforelse
  </div> <!-- /.col-md-8 -->
  <aside class="col-md-4">
    @include('common.sidebar')
  </aside>
</section> <!-- /.row -->
@endsection
