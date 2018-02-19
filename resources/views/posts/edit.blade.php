@extends('layouts.app')

@section('title', "Edit $post->title")

@section('content')
<div class="container mt-3">
	<nav aria-label="breadcrumb">
  	<ol class="breadcrumb">
    	<li class="breadcrumb-item"><a href="{{ route('index') }}">Home</a></li>
    	<li class="breadcrumb-item"><a href="{{ route('posts.index') }}">Posts</a></li>
    	<li class="breadcrumb-item"><a href="{{ route('posts.show', $post->id) }}">{{ $post->title }}</a></li>
    	<li class="breadcrumb-item active" aria-current="page">Edit</li>
  	</ol>
	</nav>
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card card-default">
        <div class="card-header">Edit {{ $post->title }}</div>
        <div class="card-body">
          <form action="{{ route('posts.update', $post->id) }}" method="post">
            @csrf
            @method('PUT')
            <div class="form-group">
              <label for="tags" ><b>Status</b></label>
              <select id="tags" class="form-control" name="tags[]" multiple>
                @if(count($post->tags) == 0)
                  @foreach($tags as $tag)
                    <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                  @endforeach
                @else
                  @foreach ($tags as $tag)
                    @foreach ($post->tags as $selected_tag)
                      @if ($tag->id == $selected_tag->id)
                        <option value="{{ $tag->id }}" selected>{{ $tag->name }}</option>
                        @break
                      @elseif ($loop->last)
                        <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                      @endif
                    @endforeach
                  @endforeach
                @endif
              </select>
            </div> <!-- /.form-group -->

            <div class="form-group">
              <label for="title"><b>Title</b></label>
              <input id="title" class="form-control{{ $errors->has('title') ? ' is-invalid' : ''}}" type="text" name="title" value="{{ $post->title }}" required autofocus>
              @if ($errors->has('title'))
                <span class="invalid-feedback">
                  <strong>{{ $errors->first('title') }}</strong>
                </span>
              @endif
            </div> <!-- /.form-group -->

            <div class="form-group">
              <label for="ckeditor"><b>Body</b></label>
              <textarea id="ckeditor" class="form-control{{ $errors->has('body') ? ' is-invalid' : ''}}" name="body" cols="30" rows="10" required>
                {{ $post->body }}
              </textarea>
              @if ($errors->has('body'))
                <span class="invalid-feedback">
                  <strong>{{ $errors->first('body') }}</strong>
                </span>
              @endif
            </div> <!-- /.form-group -->
            
            <button class="btn btn-primary" type="submit">Submit</button>

          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
