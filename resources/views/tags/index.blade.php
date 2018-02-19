@extends('layouts.app')

@section('title', 'Tags')

@section('content')
  <div class="container">
	  <nav aria-label="breadcrumb">
  	  <ol class="breadcrumb">
    	  <li class="breadcrumb-item"><a href="{{ route('index') }}">Home</a></li>
    	  <li class="breadcrumb-item active" aria-current="page">Tags</li>
  	  </ol>
	  </nav>
  @forelse($tags as $tag)
    <a href="{{ route('posts.sortByTag', $tag->id) }}" class="btn btn-outline-{{ $tag->status }}">
      {{ $tag->name }}
    </a>
  @empty
    <p>Tags List is Empry</p>
  @endforelse
    <br>
    <a class="btn btn-primary mt-3" href="{{ route('tags.create') }}">Add new tag</a>
  </div>
@endsection
